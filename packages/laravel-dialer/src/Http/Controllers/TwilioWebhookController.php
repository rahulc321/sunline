<?php

namespace PowerDialer\Dialer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PowerDialer\Dialer\Jobs\ArchiveRecordingJob;
use PowerDialer\Dialer\Models\DialerAgentStatus;
use PowerDialer\Dialer\Models\DialerCall;
use PowerDialer\Dialer\Models\DialerGroup;
use PowerDialer\Dialer\Models\DialerGroupMember;

class TwilioWebhookController extends Controller
{
    // ── Call Status Callback ───────────────────────────────────────────────────

    public function callStatus(Request $request)
    {
        $sid      = $request->input('CallSid');
        $status   = $request->input('CallStatus');
        $duration = (int) $request->input('CallDuration', 0);

        $call = DialerCall::where('twilio_call_sid', $sid)->first();

        if (!$call) {
            $call = DialerCall::where('status', 'initiated')
                ->where('phone', $request->input('To'))
                ->latest()
                ->first();
        }

        if (!$call) {
            return response('OK', 200);
        }

        $updates = ['status' => $status, 'twilio_call_sid' => $sid];

        if ($status === 'in-progress') {
            $updates['started_at'] = now();
        }

        if (in_array($status, ['completed', 'busy', 'no-answer', 'failed', 'canceled'])) {
            $updates['ended_at'] = now();
            $updates['duration'] = $duration ?: ($call->started_at ? (int) now()->diffInSeconds($call->started_at) : 0);

            if ($call->agent_id) {
                DialerAgentStatus::where('user_id', $call->agent_id)
                    ->where('current_call_id', $call->id)
                    ->where('status', 'on_call')
                    ->update(['status' => 'wrap_up', 'current_call_id' => null, 'status_changed_at' => now()]);
            }
        }

        $oldStatus = $call->status; // save BEFORE update
        $call->update($updates);

        // Missed inbound call — caller hung up before any agent answered
        if (in_array($status, ['completed', 'canceled', 'no-answer', 'failed'])
            && $call->direction === 'inbound'
            && in_array($oldStatus, ['ringing', 'queued'])
            && !$call->agent_id) {

            $group = $call->group_id ? \PowerDialer\Dialer\Models\DialerGroup::find($call->group_id) : null;
            $this->markMissedCall($call->id, $group);
        }

        return response('OK', 200);
    }

    // ── Recording Callback ─────────────────────────────────────────────────────

    public function recording(Request $request)
    {
        $callSid      = $request->input('CallSid');
        $recordingSid = $request->input('RecordingSid');
        $recordingUrl = $request->input('RecordingUrl') . '.mp3';

        $call = DialerCall::where('twilio_call_sid', $callSid)->first();

        if (! $call) {
            return response('OK', 200);
        }

        $call->update([
            'recording_sid' => $recordingSid,
            'recording_url' => $recordingUrl,
        ]);

        // Fire event so host app can sync recording_sid to its own tables
        if (config('dialer.fire_events', true)) {
            event(new \PowerDialer\Dialer\Events\DialerRecordingArchived(
                dialerCallId: $call->id,
                blobPath: '',
                recordingSid: $recordingSid,
            ));
        }

        ArchiveRecordingJob::dispatch($call->id);

        return response('OK', 200);
    }

    // ── SMS Inbound ────────────────────────────────────────────────────────────

    public function smsInbound(Request $request)
    {
        $from = $request->input('From');
        $body = strtoupper(trim($request->input('Body', '')));

        $optOutKeywords = ['STOP', 'STOPALL', 'UNSUBSCRIBE', 'CANCEL', 'END', 'QUIT'];
        $optInKeywords  = ['START', 'UNSTOP', 'YES'];

        $contactClass = config('dialer.contact_model');

        if (in_array($body, $optOutKeywords)) {
            if (method_exists($contactClass, 'where')) {
                $contactClass::where('mobile', $from)->orWhere('home_phone', $from)
                    ->update(['has_consent' => false]);
            }
            Log::info('SMS opt-out received — consent revoked', ['phone_hash' => hash('sha256', $from)]);
        } elseif (in_array($body, $optInKeywords)) {
            if (method_exists($contactClass, 'where')) {
                $contactClass::where('mobile', $from)->orWhere('home_phone', $from)
                    ->update(['has_consent' => true]);
            }
            Log::info('SMS opt-in received — consent restored', ['phone_hash' => hash('sha256', $from)]);
        }

        return response(
            '<?xml version="1.0" encoding="UTF-8"?><Response></Response>',
            200,
            ['Content-Type' => 'text/xml']
        );
    }

    // ── TwiML for Outbound Browser Call ───────────────────────────────────────

    public function voice(Request $request)
    {
        $conf      = $request->input('Conference');
        $caller    = $request->input('Caller', '');
        $direction = $request->input('Direction', '');

        Log::info('Twilio voice webhook', [
            'Direction'  => $direction,
            'Caller'     => $caller,
            'Conference' => $conf,
            'To'         => $request->input('To'),
            'From'       => $request->input('From'),
            'CallSid'    => $request->input('CallSid'),
        ]);

        if ($request->input('Warmup')) {
            return response(
                '<?xml version="1.0" encoding="UTF-8"?><Response><Hangup/></Response>',
                200,
                ['Content-Type' => 'text/xml']
            );
        }

        if ($conf) {
            $twiml = '<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Dial>
        <Conference startConferenceOnEnter="true"
                    endConferenceOnExit="true"
                    waitUrl=""
                    beep="false">' . htmlspecialchars($conf) . '</Conference>
    </Dial>
</Response>';
            return response($twiml, 200, ['Content-Type' => 'text/xml']);
        }

        if ($direction === 'inbound' || str_starts_with($caller, 'client:')) {
            return $this->handleInbound($request);
        }

        Log::warning('Twilio voice webhook: unexpected outbound call leg', [
            'Direction' => $direction,
            'Caller'    => $caller,
            'To'        => $request->input('To'),
            'From'      => $request->input('From'),
        ]);

        return response(
            '<?xml version="1.0" encoding="UTF-8"?><Response><Say>Configuration error.</Say></Response>',
            200,
            ['Content-Type' => 'text/xml']
        );
    }

    // ── Conference join ────────────────────────────────────────────────────────

    public function conferenceJoin(Request $request)
    {
        $conf = $request->query('name', '');

        Log::info('Twilio conference-join', [
            'Conference' => $conf,
            'CallSid'    => $request->input('CallSid'),
            'Direction'  => $request->input('Direction'),
        ]);

        if (empty($conf)) {
            return response(
                '<?xml version="1.0" encoding="UTF-8"?><Response><Say>Conference not found.</Say></Response>',
                200,
                ['Content-Type' => 'text/xml']
            );
        }

        $twiml = '<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Dial>
        <Conference startConferenceOnEnter="true"
                    endConferenceOnExit="true"
                    waitUrl=""
                    beep="false">' . htmlspecialchars($conf) . '</Conference>
    </Dial>
</Response>';

        return response($twiml, 200, ['Content-Type' => 'text/xml']);
    }

    // ── Inbound call routing ───────────────────────────────────────────────────

    private function handleInbound(Request $request)
    {
        try {
            $to   = $request->input('To');
            $from = $request->input('From');
            $sid  = $request->input('CallSid');

            $group = Cache::remember("dialer_group_by_number_{$to}", 60, fn() =>
                DialerGroup::where('twilio_number', $to)->where('is_active', true)->first()
            );

            if (!$group) {
                Log::warning('Inbound call — no group found for number', ['to' => $to]);
                return $this->twimlSay('Sorry, this number is not currently available. Goodbye.');
            }

            [$callerName, $caseId] = $this->resolveCallerInfo($from);

            $call = DialerCall::create([
                'project_key'     => config('dialer.project_key'),
                'phone'           => $from,
                'group_id'        => $group->id,
                'direction'       => 'inbound',
                'status'          => 'ringing',
                'twilio_call_sid' => $sid,
                'case_id'         => $caseId,
            ]);

            Log::info('Inbound call routing', [
                'group'       => $group->name,
                'strategy'    => $group->ring_strategy,
                'caller_name' => $callerName,
                'case_id'     => $caseId,
                'call_id'     => $call->id,
            ]);

            $twiml = $this->ringGroup($group, $from, $callerName, $caseId, $call->id, []);

            if ($twiml) {
                return $twiml;
            }

            // No agents available — hold caller in conference queue instead of voicemail
            return $this->enqueueInConference($call->id, $sid, $group);

        } catch (\Throwable $e) {
            Log::error('handleInbound exception', ['error' => $e->getMessage()]);
            return $this->twimlSay('Sorry, a system error occurred. Please try again later.');
        }
    }

    // ── Inbound fallback ──────────────────────────────────────────────────────

    public function inboundFallback(Request $request)
    {
        $empty = '<?xml version="1.0" encoding="UTF-8"?><Response></Response>';

        try {
            $from       = $request->input('From', $request->query('from'));
            $groupId    = (int) $request->query('group_id');
            $callId     = (int) $request->query('call_id');
            $triedStr   = $request->query('tried', '');
            $tried      = $triedStr ? array_map('intval', explode(',', $triedStr)) : [];
            $dialStatus = $request->input('DialCallStatus', 'no-answer');

            Log::info('Inbound fallback', [
                'DialCallStatus' => $dialStatus,
                'group_id'       => $groupId,
                'call_id'        => $callId,
                'from'           => $from,
            ]);

            if (in_array($dialStatus, ['completed', 'answered'])) {
                return response($empty, 200, ['Content-Type' => 'text/xml']);
            }

            if ($dialStatus === 'canceled') {
                if ($callId) {
                    DialerCall::where('id', $callId)->update(['status' => 'canceled', 'ended_at' => now()]);
                }
                return response($empty, 200, ['Content-Type' => 'text/xml']);
            }

            $group = DialerGroup::find($groupId);

            if ($group && $group->ring_strategy === 'round_robin') {
                [$callerName, $caseId] = $this->resolveCallerInfo($from);
                $nextTwiml = $this->ringGroup($group, $from, $callerName, $caseId, $callId, $tried);
                if ($nextTwiml) return $nextTwiml;
            }

            if ($group && $group->backup_group_id) {
                $backup = DialerGroup::where('id', $group->backup_group_id)
                    ->where('is_active', true)
                    ->first();
                if ($backup) {
                    [$callerName, $caseId] = $this->resolveCallerInfo($from);
                    Log::info('Inbound fallback — trying backup group', ['backup' => $backup->name]);
                    $backupTwiml = $this->ringGroup($backup, $from, $callerName, $caseId, $callId, []);
                    if ($backupTwiml) return $backupTwiml;
                }
            }

            // All agents tried — hold caller in conference queue
            $call = DialerCall::find($callId);
            if ($call && $call->status !== 'queued') {
                return $this->enqueueInConference($callId, $call->twilio_call_sid ?? '', $group);
            }

            return response('<?xml version="1.0" encoding="UTF-8"?><Response></Response>', 200, ['Content-Type' => 'text/xml']);

        } catch (\Throwable $e) {
            Log::error('inboundFallback exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response($empty, 200, ['Content-Type' => 'text/xml']);
        }
    }

    // ── Voicemail recording complete ───────────────────────────────────────────

    public function voicemailComplete(Request $request)
    {
        $callId       = (int) $request->query('call_id');
        $recordingSid = $request->input('RecordingSid');
        $recordingUrl = $request->input('RecordingUrl');
        $transcript   = $request->input('TranscriptionText');

        if ($callId && $recordingSid) {
            DialerCall::where('id', $callId)->update([
                'recording_sid' => $recordingSid,
                'recording_url' => $recordingUrl ? $recordingUrl . '.mp3' : null,
                'status'        => 'voicemail',
                'agent_notes'   => $transcript ? 'Voicemail transcript: ' . $transcript : null,
                'ended_at'      => now(),
            ]);

            Log::info('Voicemail recorded', ['call_id' => $callId, 'recording_sid' => $recordingSid]);
        }

        return response('<?xml version="1.0" encoding="UTF-8"?><Response></Response>', 200, ['Content-Type' => 'text/xml']);
    }

    // ── Ring a group's available agents ───────────────────────────────────────

    private function ringGroup(DialerGroup $group, string $from, ?string $callerName, ?int $caseId, int $callId, array $alreadyTried)
    {
        $agentIds = DialerGroupMember::where('group_id', $group->id)
            ->where('is_active', true)
            ->pluck('user_id');

        $available = DialerAgentStatus::whereIn('user_id', $agentIds)
            ->where('status', 'available')
            ->orderBy('status_changed_at')
            ->pluck('user_id');

        if (!empty($alreadyTried)) {
            $available = $available->diff($alreadyTried)->values();
        }

        if ($available->isEmpty()) {
            return null;
        }

        $fallbackUrl = route('webhooks.twilio.inbound-fallback')
            . '?group_id=' . $group->id
            . '&call_id='  . $callId;

        if ($group->ring_strategy === 'round_robin') {
            $agentId     = $available->first();
            $nextTried   = array_merge($alreadyTried, [$agentId]);
            $fallbackUrl .= '&tried=' . implode(',', $nextTried);
            $clientTags  = $this->buildClientTag($agentId, $callerName, $caseId, $group->name);
        } else {
            $fallbackUrl .= '&tried=' . $available->implode(',');
            $clientTags  = $available
                ->map(fn($id) => $this->buildClientTag($id, $callerName, $caseId, $group->name))
                ->implode("\n");
        }

        $timeout = $group->ring_timeout ?: 20;

        $twiml = '<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Dial timeout="' . $timeout . '"
          action="' . htmlspecialchars($fallbackUrl) . '"
          method="POST"
          record="record-from-answer-dual"
          recordingStatusCallback="' . route('webhooks.twilio.recording') . '"
          recordingStatusCallbackMethod="POST">
' . $clientTags . '
    </Dial>
</Response>';

        return response($twiml, 200, ['Content-Type' => 'text/xml']);
    }

    private function buildClientTag(int $agentId, ?string $callerName, ?int $caseId, string $groupName): string
    {
        $params = '';
        if ($callerName) {
            $params .= '        <Parameter name="CallerName" value="' . htmlspecialchars($callerName) . '"/>' . "\n";
        }
        if ($caseId) {
            $params .= '        <Parameter name="CaseId" value="' . $caseId . '"/>' . "\n";
        }
        $params .= '        <Parameter name="GroupName" value="' . htmlspecialchars($groupName) . '"/>' . "\n";

        return '    <Client>
        <Identity>agent_' . $agentId . '</Identity>
' . $params . '    </Client>';
    }

    private function resolveCallerInfo(string $from): array
    {
        $digits = preg_replace('/\D/', '', $from);

        $contactClass = config('dialer.contact_model');

        if (! method_exists($contactClass, 'findByPhone')) {
            return [null, null];
        }

        $case = $contactClass::findByPhone($digits);

        if (!$case) return [null, null];

        $name = $case->getDialerName();
        return [$name ?: null, $case->id];
    }

    private function markMissedCall(int $callId, ?DialerGroup $group): void
    {
        DialerCall::where('id', $callId)->update([
            'status'   => 'no-answer',
            'ended_at' => now(),
        ]);

        if (!$group || !$group->missed_call_notify) return;

        $agentIds = DialerGroupMember::where('group_id', $group->id)
            ->where('is_active', true)
            ->pluck('user_id');

        $call = DialerCall::find($callId);
        if (!$call) return;

        $userModel = config('dialer.user_model');

        foreach ($agentIds as $userId) {
            DB::table('notifications')->insert([
                'id'              => Str::uuid(),
                'type'            => 'missed_inbound_call',
                'notifiable_type' => $userModel,
                'notifiable_id'   => $userId,
                'data'            => json_encode([
                    'message'    => 'Missed inbound call from ' . $call->phone,
                    'phone'      => $call->phone,
                    'case_id'    => $call->case_id,
                    'group_name' => $group->name,
                    'call_id'    => $callId,
                ]),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        Log::info('Missed call notifications sent', ['group' => $group->name, 'agents' => $agentIds->count()]);
    }

    private function enqueueInConference(int $callId, string $sid, ?DialerGroup $group): \Illuminate\Http\Response
    {
        $confName = 'inbound_hold_' . $sid;

        DialerCall::where('id', $callId)->update([
            'status' => 'queued',
        ]);

        Log::info('Inbound call queued — no agents available', [
            'call_id'   => $callId,
            'conf_name' => $confName,
            'group'     => $group?->name,
        ]);

        $holdUrl     = route('webhooks.twilio.hold-music') . ($group && $group->voicemail_enabled ? '?call_id=' . $callId : '');
        $vmActionUrl = $group && $group->voicemail_enabled
            ? route('webhooks.twilio.voicemail-action') . '?call_id=' . $callId
            : '';
        $timeLimit   = $group && $group->voicemail_enabled ? 300 : '';

        $twiml = '<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Say voice="alice">All agents are currently busy. Please hold and your call will be answered shortly.'
    . ($group && $group->voicemail_enabled ? ' Press 0 at any time to leave a voicemail.' : '') . '</Say>
    <Dial>
        <Conference startConferenceOnEnter="false"
                    waitUrl="' . $holdUrl . '"
                    waitMethod="GET"
                    endConferenceOnExit="true"
                    statusCallback="' . route('webhooks.twilio.call-status') . '"
                    statusCallbackMethod="POST"
                    beep="false"'
    . ($vmActionUrl ? "\n                    maxParticipants=\"10\"\n                    timeLimit=\"{$timeLimit}\"\n                    action=\"{$vmActionUrl}\"\n                    method=\"POST\"" : '')
    . '>' . htmlspecialchars($confName) . '</Conference>
    </Dial>
</Response>';

        return response($twiml, 200, ['Content-Type' => 'text/xml']);
    }

    private function twimlSay(string $message): \Illuminate\Http\Response
    {
        return response(
            '<?xml version="1.0" encoding="UTF-8"?><Response><Say voice="alice">' . htmlspecialchars($message) . '</Say></Response>',
            200,
            ['Content-Type' => 'text/xml']
        );
    }

    // ── Hold Music TwiML ───────────────────────────────────────────────────────

    public function holdMusic(Request $request)
    {
        $callId  = (int) $request->query('call_id', 0);
        $vmRoute = $callId ? route('webhooks.twilio.voicemail-action') . '?call_id=' . $callId : '';

        if ($vmRoute) {
            // Allow caller to press 0 for voicemail while on hold
            $twiml = '<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Gather numDigits="1" action="' . $vmRoute . '" method="POST" timeout="60">
        <Play loop="0">https://com.twilio.sounds.music.s3.amazonaws.com/MARKOVICHAMP-Borghestral.mp3</Play>
    </Gather>
</Response>';
        } else {
            $twiml = '<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Play loop="0">https://com.twilio.sounds.music.s3.amazonaws.com/MARKOVICHAMP-Borghestral.mp3</Play>
</Response>';
        }

        return response($twiml, 200, ['Content-Type' => 'text/xml']);
    }

    // ── Voicemail Action (hold timeout or caller presses 0) ───────────────────

    public function voicemailAction(Request $request)
    {
        $callId     = (int) $request->query('call_id');
        $vmUrl      = route('webhooks.twilio.voicemail-complete') . '?call_id=' . $callId;
        $transcribe = config('dialer.voicemail.transcribe', false);

        DialerCall::where('id', $callId)->where('status', 'queued')
            ->update(['status' => 'voicemail', 'ended_at' => now()]);

        $twiml = '<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Say voice="alice">All agents are still busy. Please leave a message after the tone and we will call you back shortly.</Say>
    <Record maxLength="120" action="' . $vmUrl . '" method="POST"' . ($transcribe ? ' transcribe="true" transcribeCallback="' . $vmUrl . '"' : '') . '/>
    <Say voice="alice">We did not receive a recording. Goodbye.</Say>
</Response>';

        return response($twiml, 200, ['Content-Type' => 'text/xml']);
    }
}
