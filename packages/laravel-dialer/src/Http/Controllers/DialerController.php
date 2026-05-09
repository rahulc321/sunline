<?php

namespace PowerDialer\Dialer\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PowerDialer\Dialer\Events\DialerCallDispositioned;
use PowerDialer\Dialer\Events\DialerQueueUpdated;
use PowerDialer\Dialer\Jobs\ArchiveRecordingJob;
use PowerDialer\Dialer\Models\DialerAgentStatus;
use PowerDialer\Dialer\Models\DialerCall;
use PowerDialer\Dialer\Models\DialerGroup;
use PowerDialer\Dialer\Models\DialerGroupMember;
use PowerDialer\Dialer\Models\DialerQueue;
use PowerDialer\Dialer\Traits\ResolvesN8nWebhook;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DialerController extends Controller
{
    use ResolvesN8nWebhook;

    // ── Hub ────────────────────────────────────────────────────────────────────

    public function index()
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $todayCalls = DialerCall::where('project_key', config('dialer.project_key'))
            ->whereDate('created_at', today())->count();

        return view('dialer::admin.dialer.index', compact('todayCalls'));
    }

    // ── Agent Softphone ────────────────────────────────────────────────────────

    public function softphone()
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $agentStatus  = DialerAgentStatus::forUser(Auth::id());
        $agentGroups  = DialerGroupMember::where('user_id', Auth::id())
            ->where('is_active', true)
            ->with('group')
            ->get()
            ->filter(fn($m) => $m->group && $m->group->is_active && $m->group->twilio_number)
            ->values();

        return view('dialer::admin.dialer.softphone', compact('agentStatus', 'agentGroups'));
    }

    // ── Twilio Token (browser client) ──────────────────────────────────────────

    public function token()
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sid       = config('dialer.twilio.sid');
        $apiKey    = config('dialer.twilio.api_key');
        $apiSecret = config('dialer.twilio.api_secret');
        $appSid    = config('dialer.twilio.app_sid');

        if (empty($sid) || empty($apiKey) || empty($apiSecret) || empty($appSid)) {
            return response()->json(['error' => 'Twilio not configured'], 503);
        }

        $maxAgents  = config('dialer.dialer.max_concurrent_agents', 200);
        $liveAgents = DialerAgentStatus::whereIn('status', ['available', 'on_call', 'wrap_up'])->count();
        if ($liveAgents >= $maxAgents) {
            return response()->json(['error' => 'Dialer at capacity. Try again shortly.'], 503);
        }

        $userId   = Auth::id();
        $identity = 'agent_' . $userId;

        if (request()->boolean('force')) {
            \Cache::forget("dialer_token_{$userId}");
        }

        $jwt = \Cache::remember("dialer_token_{$userId}", 3000, function () use ($sid, $apiKey, $apiSecret, $appSid, $identity) {
            $accessToken = new \Twilio\Jwt\AccessToken($sid, $apiKey, $apiSecret, 3600, $identity);
            $voiceGrant  = new \Twilio\Jwt\Grants\VoiceGrant();
            $voiceGrant->setOutgoingApplicationSid($appSid);
            $voiceGrant->setIncomingAllow(true);
            $accessToken->addGrant($voiceGrant);
            return $accessToken->toJWT();
        });

        DialerAgentStatus::forUser($userId)
            ->update(['twilio_identity' => $identity]);

        return response()->json(['token' => $jwt, 'identity' => $identity]);
    }

    // ── Agent Status ───────────────────────────────────────────────────────────

    public function setStatus(Request $request)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate(['status' => 'required|in:offline,available,on_call,wrap_up,break']);
        DialerAgentStatus::forUser(Auth::id())->setStatus($request->status);
        return response()->json(['ok' => true]);
    }

    // ── Set active group ───────────────────────────────────────────────────────

    public function setGroup(Request $request)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate(['group_id' => 'nullable|exists:dialer_groups,id']);

        $agentId = Auth::id();
        $groupId = $request->input('group_id');

        if ($groupId) {
            $isMember = DialerGroupMember::where('user_id', $agentId)
                ->where('group_id', $groupId)
                ->where('is_active', true)
                ->exists();
            if (! $isMember) {
                return response()->json(['error' => 'Not a member of this group'], 403);
            }
        }

        DialerAgentStatus::forUser($agentId)->update(['active_group_id' => $groupId]);

        $number = null;
        if ($groupId) {
            $number = DialerGroup::where('id', $groupId)->value('twilio_number');
        }

        return response()->json(['ok' => true, 'twilio_number' => $number]);
    }

    // ── Queue Polling ─────────────────────────────────────────────────────────

    public function queueStatus()
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectKey  = config('dialer.project_key');
        $agentId     = Auth::id();
        $agentStatus = DialerAgentStatus::forUser($agentId);

        $pendingCount = Cache::remember("dialer:pending_count:{$projectKey}", 2, function () use ($projectKey) {
            return DialerQueue::where('project_key', $projectKey)
                ->where('status', 'pending')->count();
        });

        $nextCall = null;
        if ($agentStatus->status === 'available') {
            $cacheKey = "dialer:next_call:{$projectKey}:{$agentId}";
            $nextCall = Cache::remember($cacheKey, 3, function () use ($projectKey, $agentId) {
                return DialerQueue::where('project_key', $projectKey)
                    ->where('status', 'pending')
                    ->where('queue_mode', 'human_agent')
                    ->where(function ($q) {
                        $q->whereNull('scheduled_at')->orWhere('scheduled_at', '<=', now());
                    })
                    ->where(function ($q) use ($agentId) {
                        $q->whereNull('assigned_agent_id')->orWhere('assigned_agent_id', $agentId);
                    })
                    ->with('caseIntake:id,full_name,last_name')
                    ->orderBy('priority')
                    ->orderBy('created_at')
                    ->first();
            });
        }

        $inboundQueued = DialerCall::where('project_key', $projectKey)
            ->where('direction', 'inbound')
            ->where('status', 'queued')
            ->count();

        $nextInbound = null;
        if ($agentStatus->status === 'available' && $inboundQueued > 0) {
            $nextInbound = DialerCall::where('project_key', $projectKey)
                ->where('direction', 'inbound')
                ->where('status', 'queued')
                ->with('caseIntake:id,full_name,last_name')
                ->orderBy('id')
                ->first(['id', 'phone', 'twilio_call_sid', 'case_id']);
        }

        return response()->json([
            'agent_status'   => $agentStatus->status,
            'pending_count'  => $pendingCount,
            'inbound_queued' => $inboundQueued,
            'next_call'      => $nextCall ? [
                'queue_id'     => $nextCall->id,
                'phone'        => $nextCall->phone,
                'contact_name' => $nextCall->contact_name,
                'case_id'      => $nextCall->case_id,
                'case_name'    => $nextCall->caseIntake
                    ? trim($nextCall->caseIntake->full_name . ' ' . $nextCall->caseIntake->last_name)
                    : $nextCall->contact_name,
                'call_type'    => $nextCall->call_type,
                'notes'        => $nextCall->notes,
            ] : null,
            'next_inbound'   => $nextInbound ? [
                'call_id'         => $nextInbound->id,
                'phone'           => $nextInbound->phone,
                'twilio_call_sid' => $nextInbound->twilio_call_sid,
                'case_id'         => $nextInbound->case_id,
                'caller_name'     => $nextInbound->caseIntake
                    ? trim($nextInbound->caseIntake->full_name . ' ' . ($nextInbound->caseIntake->last_name ?? ''))
                    : null,
            ] : null,
        ]);
    }

    // ── Initiate Call (queue-based) ────────────────────────────────────────────

    public function call(Request $request)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'queue_id' => 'required|exists:dialer_queue,id',
        ]);

        $agentId    = Auth::id();
        $projectKey = config('dialer.project_key');

        $agentStatus = DialerAgentStatus::forUser($agentId);
        if ($agentStatus->status !== 'available') {
            return response()->json(['error' => 'You must be in Available status to dial'], 409);
        }

        $result = DB::transaction(function () use ($request, $agentId, $projectKey) {
            $item = DialerQueue::where('id', $request->queue_id)
                ->where('status', 'pending')
                ->lockForUpdate()
                ->first();

            if (! $item) return null;

            $item->update([
                'status'            => 'calling',
                'assigned_agent_id' => $agentId,
                'called_at'         => now(),
                'attempt'           => $item->attempt + 1,
            ]);

            $call = DialerCall::create([
                'project_key' => $projectKey,
                'queue_id'    => $item->id,
                'case_id'     => $item->case_id,
                'agent_id'    => $agentId,
                'phone'       => $item->phone,
                'direction'   => 'outbound',
                'status'      => 'initiated',
                'call_source' => $item->queue_mode === 'human_agent' ? 'direct' : 'ai_agent',
                'started_at'  => now(),
            ]);

            return ['call' => $call, 'item' => $item];
        });

        if (! $result) {
            return response()->json(['error' => 'Call already taken by another agent'], 409);
        }

        $call = $result['call'];
        $item = $result['item'];

        if ($item->queue_mode === 'human_agent') {
            $confName = 'conf_' . $call->id . '_' . time();
            $call->update(['conference_name' => $confName]);

            $agentStatus->update([
                'status'            => 'on_call',
                'current_call_id'   => $call->id,
                'status_changed_at' => now(),
            ]);

            Cache::forget("dialer:pending_count:{$projectKey}");
            Cache::forget("dialer:next_call:{$projectKey}:{$agentId}");

            return response()->json([
                'call_id'    => $call->id,
                'conference' => $confName,
                'phone'      => $item->phone,
                'mode'       => 'human_agent',
            ]);
        }

        $contactClass = config('dialer.contact_model');
        $case    = $item->case_id ? $contactClass::find($item->case_id) : null;
        $payload = [
            'trigger'          => 'queue_dial',
            'internal_call_id' => $call->id,
            'phone'            => $item->phone,
            'from_number'      => $this->agentFromNumber($agentId),
            'agent_id'         => $agentId,
            'case_id'          => $item->case_id,
            'contact_name'     => $item->contact_name,
            'state'            => $case ? $case->getDialerState() : null,
        ];

        $n8nUrl = $this->n8nUrl('dial');

        if (empty($n8nUrl)) {
            $item->update(['status' => 'failed']);
            $call->update(['status' => 'failed']);
            return response()->json(['error' => 'Dialer not configured'], 503);
        }

        try {
            $response = Http::timeout(15)
                ->withHeaders($this->n8nHeaders())
                ->post($n8nUrl, $payload);
        } catch (\Exception $e) {
            $item->update(['status' => 'pending', 'assigned_agent_id' => null, 'called_at' => null]);
            $call->update(['status' => 'failed']);
            Log::error('n8n queue dial request failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Could not reach automation service'], 502);
        }

        if (! $response->successful()) {
            $item->update(['status' => 'pending', 'assigned_agent_id' => null, 'called_at' => null]);
            $call->update(['status' => 'failed']);
            return response()->json(['error' => 'Automation service error'], 502);
        }

        $n8nResult = $response->json();

        if (! ($n8nResult['success'] ?? false)) {
            $reason = $n8nResult['reason'] ?? 'blocked';
            $item->update(['status' => 'skipped']);
            $call->update(['status' => 'canceled', 'agent_notes' => "Blocked: {$reason}"]);
            return response()->json(['error' => $reason], 422);
        }

        $voiceCallId = $n8nResult['voice_call_id'] ?? null;
        $call->update(['voice_call_id' => $voiceCallId]);

        $agentStatus->update([
            'status'            => 'on_call',
            'current_call_id'   => $call->id,
            'status_changed_at' => now(),
        ]);

        Cache::forget("dialer:pending_count:{$projectKey}");
        Cache::forget("dialer:next_call:{$projectKey}:{$agentId}");

        return response()->json([
            'call_id'       => $call->id,
            'voice_call_id' => $voiceCallId,
            'phone'         => $item->phone,
            'mode'          => 'ai_agent',
        ]);
    }

    // ── Manual Dial ────────────────────────────────────────────────────────────

    public function manualDial(Request $request)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'phone'        => 'required|string',
            'case_id'      => 'nullable|exists:' . app(config('dialer.contact_model'))->getTable() . ',id',
            'contact_name' => 'nullable|string|max:255',
            'dial_mode'    => 'nullable|in:system,human_agent',
        ]);

        $phone        = preg_replace('/[^0-9+]/', '', $request->phone);
        $dialMode     = $request->input('dial_mode', 'human_agent');
        $projectKey   = config('dialer.project_key');
        $agentId      = Auth::id();
        $contactClass = config('dialer.contact_model');

        $agentStatus = DialerAgentStatus::forUser($agentId);
        if ($agentStatus->status !== 'available') {
            return response()->json(['error' => 'You must be in Available status to dial'], 409);
        }

        $case = $request->case_id ? $contactClass::find($request->case_id) : null;

        if (! $case) {
            $digits = preg_replace('/\D/', '', $phone);
            $case   = method_exists($contactClass, 'findByPhone')
                ? $contactClass::findByPhone($digits)
                : null;
        }

        $contactName = $request->contact_name
            ?? ($case ? $case->getDialerName() : null);

        $item = DialerQueue::create([
            'project_key'       => $projectKey,
            'case_id'           => $case?->id ?? $request->case_id,
            'assigned_agent_id' => $agentId,
            'phone'             => $phone,
            'contact_name'      => $contactName,
            'status'            => 'calling',
            'call_type'         => 'manual',
            'queue_mode'        => $dialMode,
            'called_at'         => now(),
            'attempt'           => 1,
        ]);

        $call = DialerCall::create([
            'project_key' => $projectKey,
            'queue_id'    => $item->id,
            'case_id'     => $case?->id ?? $request->case_id,
            'agent_id'    => $agentId,
            'phone'       => $phone,
            'direction'   => 'outbound',
            'status'      => 'initiated',
            'call_source' => $dialMode === 'human_agent' ? 'direct' : 'ai_agent',
            'started_at'  => now(),
        ]);

        if ($dialMode === 'human_agent') {
            $confName = 'conf_' . $call->id . '_' . time();
            $call->update(['conference_name' => $confName]);

            $agentStatus->update([
                'status'            => 'on_call',
                'current_call_id'   => $call->id,
                'status_changed_at' => now(),
            ]);

            Cache::forget("dialer:pending_count:{$projectKey}");
            Cache::forget("dialer:next_call:{$projectKey}:{$agentId}");

            return response()->json([
                'call_id'      => $call->id,
                'conference'   => $confName,
                'phone'        => $phone,
                'mode'         => 'human_agent',
                'contact_name' => $contactName ?? $phone,
                'case_id'      => $case?->id,
                'case_type'    => $case?->case_type ?? null,
                'case_status'  => $case?->status ?? null,
            ]);
        }

        $payload = [
            'trigger'          => 'manual_dial',
            'internal_call_id' => $call->id,
            'phone'            => $phone,
            'from_number'      => $this->agentFromNumber($agentId),
            'agent_id'         => $agentId,
            'case_id'          => $request->case_id,
            'contact_name'     => $contactName,
            'state'            => $case ? $case->getDialerState() : null,
        ];

        $n8nUrl = $this->n8nUrl('dial');

        if (empty($n8nUrl)) {
            $item->update(['status' => 'failed']);
            $call->update(['status' => 'failed']);
            Log::error('n8n dial webhook not configured');
            return response()->json(['error' => 'Dialer not configured'], 503);
        }

        try {
            $response = Http::timeout(15)
                ->withHeaders($this->n8nHeaders())
                ->post($n8nUrl, $payload);
        } catch (\Exception $e) {
            $item->update(['status' => 'failed']);
            $call->update(['status' => 'failed']);
            Log::error('n8n manual dial request failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Could not reach automation service'], 502);
        }

        if (! $response->successful()) {
            $item->update(['status' => 'failed']);
            $call->update(['status' => 'failed']);
            Log::error('n8n manual dial returned error', ['status' => $response->status()]);
            return response()->json(['error' => 'Automation service error'], 502);
        }

        $result = $response->json();

        if (! ($result['success'] ?? false)) {
            $reason = $result['reason'] ?? 'blocked';
            $item->update(['status' => 'skipped']);
            $call->update(['status' => 'canceled', 'agent_notes' => "Blocked: {$reason}"]);
            return response()->json(['error' => $reason], 422);
        }

        $voiceCallId = $result['voice_call_id'] ?? null;
        $call->update(['voice_call_id' => $voiceCallId]);

        $agentStatus->update([
            'status'            => 'on_call',
            'current_call_id'   => $call->id,
            'status_changed_at' => now(),
        ]);

        Cache::forget("dialer:pending_count:{$projectKey}");
        Cache::forget("dialer:next_call:{$projectKey}:{$agentId}");

        return response()->json([
            'call_id'       => $call->id,
            'voice_call_id' => $voiceCallId,
            'phone'         => $phone,
            'mode'          => 'ai_agent',
        ]);
    }

    // ── Inbound Accept ─────────────────────────────────────────────────────────

    public function inboundAccept(Request $request)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'from'            => 'required|string',
            'twilio_call_sid' => 'nullable|string',
        ]);

        $agentId = Auth::id();
        $from    = $request->input('from');
        $sid     = $request->input('twilio_call_sid');

        $call = DialerCall::create([
            'project_key'     => config('dialer.project_key'),
            'phone'           => $from,
            'agent_id'        => $agentId,
            'direction'       => 'inbound',
            'status'          => 'in-progress',
            'twilio_call_sid' => $sid,
            'started_at'      => now(),
        ]);

        DialerAgentStatus::where('user_id', $agentId)
            ->update(['status' => 'on_call', 'current_call_id' => $call->id, 'status_changed_at' => now()]);

        return response()->json(['call_id' => $call->id]);
    }

    // ── Inbound Queue Pickup ───────────────────────────────────────────────────

    public function inboundPickup(Request $request, $callId)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $agentId     = Auth::id();
        $agentStatus = DialerAgentStatus::forUser($agentId);

        if ($agentStatus->status !== 'available') {
            return response()->json(['error' => 'You must be in Available status to pick up a queued call'], 409);
        }

        $call = DB::transaction(function () use ($callId, $agentId) {
            $c = DialerCall::where('id', $callId)
                ->where('direction', 'inbound')
                ->where('status', 'queued')
                ->lockForUpdate()
                ->first();

            if (! $c) return null;

            $confName = 'inbound_hold_' . $c->twilio_call_sid;

            $c->update([
                'agent_id'        => $agentId,
                'status'          => 'in-progress',
                'started_at'      => now(),
                'conference_name' => $confName,
            ]);

            return $c;
        });

        if (! $call) {
            return response()->json(['error' => 'Call no longer available — it may have been picked up or dropped'], 409);
        }

        $confName = 'inbound_hold_' . $call->twilio_call_sid;

        $agentStatus->update([
            'status'            => 'on_call',
            'current_call_id'   => $call->id,
            'status_changed_at' => now(),
        ]);

        // Look up caller info
        $contactClass = config('dialer.contact_model');
        $callerName   = null;
        $caseType     = null;
        $caseStatus   = null;
        if ($call->case_id) {
            $contact = $contactClass::find($call->case_id);
            if ($contact) {
                $callerName = $contact->getDialerName();
                $caseType   = $contact->case_type   ?? null;
                $caseStatus = $contact->status       ?? null;
            }
        }

        return response()->json([
            'call_id'      => $call->id,
            'conference'   => $confName,
            'phone'        => $call->phone,
            'case_id'      => $call->case_id,
            'caller_name'  => $callerName ?? $call->phone,
            'case_type'    => $caseType,
            'case_status'  => $caseStatus,
        ]);
    }

    // ── Disposition (wrap-up) ──────────────────────────────────────────────────

    public function disposition(Request $request, $callId)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'disposition' => 'required|in:contacted,voicemail,no_answer,busy,wrong_number,callback_requested,not_interested,retained',
            'notes'       => 'nullable|string|max:1000',
        ]);

        $call = DialerCall::where('agent_id', Auth::id())->findOrFail($callId);
        $call->update([
            'disposition'  => $request->disposition,
            'agent_notes'  => $request->notes,
            'ended_at'     => now(),
            'status'       => 'completed',
            'duration'     => $call->started_at ? now()->diffInSeconds($call->started_at) : 0,
        ]);

        if ($call->queue_id) {
            DialerQueue::where('id', $call->queue_id)->update(['status' => 'completed']);
        }

        DialerAgentStatus::forUser(Auth::id())->update([
            'status'            => 'available',
            'current_call_id'   => null,
            'status_changed_at' => now(),
        ]);

        $freshCall  = $call->fresh();
        $caseId     = $freshCall->case_id;
        $contactClass = config('dialer.contact_model');

        if (! $caseId && $freshCall->phone) {
            $digits = preg_replace('/\D/', '', $freshCall->phone);
            $found  = method_exists($contactClass, 'findByPhone')
                ? $contactClass::findByPhone($digits)
                : null;
            $caseId = $found?->id;
        }

        if ($caseId) {
            $contactClass::find($caseId)?->stampCalled();

            if (config('dialer.fire_events', true)) {
                event(new DialerCallDispositioned(
                    dialerCallId: $freshCall->id,
                    agentId: Auth::id(),
                    caseId: $caseId,
                    disposition: $request->disposition,
                    notes: $request->notes,
                    duration: $freshCall->duration,
                    twilioCallSid: $freshCall->twilio_call_sid,
                    direction: $freshCall->direction,
                    recordingSid: $freshCall->recording_sid,
                    startedAt: $freshCall->started_at,
                    endedAt: $freshCall->ended_at ?? now(),
                ));
            }

            if ($freshCall->recording_sid) {
                ArchiveRecordingJob::dispatch($freshCall->id);
            }
        }

        $projectKey = config('dialer.project_key');
        Cache::forget("dialer:next_call:{$projectKey}:" . Auth::id());

        if (config('dialer.fire_events', true)) {
            event(new DialerQueueUpdated($projectKey));
        }

        return response()->json(['ok' => true]);
    }

    // ── Dial Customer ─────────────────────────────────────────────────────────

    public function dialCustomer(Request $request, $callId)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $call = DialerCall::where('agent_id', Auth::id())->findOrFail($callId);

        if (! $call->conference_name) {
            return response()->json(['error' => 'No conference on record'], 422);
        }

        $this->dialCustomerIntoConference($call->phone, $call->conference_name, $call->id);

        return response()->json(['ok' => true]);
    }

    // ── Hangup Customer Leg ───────────────────────────────────────────────────

    public function hangupCall(Request $request, $callId)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $call = DialerCall::where('agent_id', Auth::id())->findOrFail($callId);

        // For inbound calls picked up from hold queue, the customer SID is the twilio_call_sid
        $customerSid = $call->customer_call_sid ?: ($call->direction === 'inbound' ? $call->twilio_call_sid : null);
        if ($customerSid) {
            try {
                $this->twilioClient()->calls($customerSid)
                    ->update(['status' => 'completed']);
            } catch (\Exception $e) {
                Log::info('hangupCall: call leg already ended', ['sid' => $customerSid, 'error' => $e->getMessage()]);
            }
        }

        return response()->json(['ok' => true]);
    }

    // ── Hold / Resume ─────────────────────────────────────────────────────────

    public function hold(Request $request, $callId)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate(['action' => 'required|in:hold,resume']);

        $call = DialerCall::where('agent_id', Auth::id())->findOrFail($callId);

        if (!$call->customer_call_sid || !$call->conference_name) {
            return response()->json(['error' => 'No active conference on record'], 422);
        }

        $twilio = $this->twilioClient();
        $held   = $request->action === 'hold';

        $twilio->conferences($call->conference_name)
               ->participants($call->customer_call_sid)
               ->update([
                   'hold'       => $held,
                   'holdUrl'    => $held ? url('/webhooks/twilio/hold-music') : null,
                   'holdMethod' => 'GET',
               ]);

        return response()->json(['ok' => true, 'held' => $held]);
    }

    // ── Transfer ───────────────────────────────────────────────────────────────

    public function transfer(Request $request, $callId)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'phone' => 'required|string',
            'type'  => 'required|in:cold,warm',
        ]);

        $call  = DialerCall::where('agent_id', Auth::id())->findOrFail($callId);
        $phone = preg_replace('/[^0-9+]/', '', $request->phone);
        $from  = $this->agentFromNumber(Auth::id());

        if (!$from) {
            return response()->json(['error' => 'No outbound number configured'], 503);
        }

        if (!$call->customer_call_sid || !$call->conference_name) {
            return response()->json(['error' => 'No active conference on record'], 422);
        }

        $twilio = $this->twilioClient();

        if ($request->type === 'cold') {
            $twilio->calls($call->customer_call_sid)->update([
                'twiml' => '<Response><Dial callerId="' . htmlspecialchars($from) . '">'
                         . '<Number>' . htmlspecialchars($phone) . '</Number>'
                         . '</Dial></Response>',
            ]);
            $twilio->conferences($call->conference_name)
                   ->participants($call->twilio_call_sid ?? '')
                   ->delete();
        } else {
            $twilio->conferences($call->conference_name)->participants->create($phone, $from, [
                'earlyMedia'          => true,
                'endConferenceOnExit' => false,
                'statusCallback'      => route('webhooks.twilio.call-status'),
                'statusCallbackMethod'=> 'POST',
            ]);
        }

        return response()->json(['ok' => true]);
    }

    // ── Conference Add Participant ─────────────────────────────────────────────

    public function conferenceAdd(Request $request, $callId)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate(['phone' => 'required|string']);

        $call  = DialerCall::where('agent_id', Auth::id())->findOrFail($callId);
        $phone = preg_replace('/[^0-9+]/', '', $request->phone);
        $from  = $this->agentFromNumber(Auth::id());

        if (!$from) {
            return response()->json(['error' => 'No outbound number configured'], 503);
        }

        if (!$call->conference_name) {
            return response()->json(['error' => 'No active conference on record'], 422);
        }

        $twilio = $this->twilioClient();

        $twilio->conferences($call->conference_name)->participants->create($phone, $from, [
            'earlyMedia'          => true,
            'endConferenceOnExit' => false,
            'statusCallback'      => route('webhooks.twilio.call-status'),
            'statusCallbackMethod'=> 'POST',
        ]);

        return response()->json(['ok' => true]);
    }

    // ── Call Log DataTable ─────────────────────────────────────────────────────

    public function callLog(Request $request)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projectKey = config('dialer.project_key');

        $query = DialerCall::where('project_key', $projectKey);

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        // Stats-only endpoint (called by JS separately)
        if ($request->boolean('stats')) {
            $totalDuration = (clone $query)->sum('duration');
            $h = floor($totalDuration / 3600);
            $m = floor(($totalDuration % 3600) / 60);
            $s = $totalDuration % 60;
            $durationFmt = $h > 0
                ? sprintf('%dh %dm', $h, $m)
                : ($m > 0 ? sprintf('%dm %ds', $m, $s) : sprintf('%ds', $s));

            return response()->json([
                'total'        => (clone $query)->count(),
                'contacted'    => (clone $query)->where('disposition', 'contacted')->count(),
                'recordings'   => (clone $query)->whereNotNull('recording_url')->count(),
                'duration_fmt' => $durationFmt ?: '0s',
            ]);
        }

        if ($request->ajax()) {
            $data = (clone $query)->with(['agent', 'caseIntake']);

            $grads = ['linear-gradient(135deg,#2563eb,#7c3aed)','linear-gradient(135deg,#dc2626,#ea580c)','linear-gradient(135deg,#059669,#0ea5e9)','linear-gradient(135deg,#7c3aed,#db2777)','linear-gradient(135deg,#0891b2,#2563eb)','linear-gradient(135deg,#00004f,#2f80ed)'];

            return DataTables::of($data)
                ->addColumn('agent_name', function($row) use ($grads) {
                    $name = $row->agent->name ?? '';
                    if (!$name) return '<span style="color:#94a3b8">—</span>';
                    $fi = strtoupper(substr($name, 0, 1));
                    return '<div class="mc-client"><div class="mc-ava mc-ava-sm" style="background:'.$grads[ord($fi)%count($grads)].'">'.$fi.'</div><span class="mc-name">'.$name.'</span></div>';
                })
                ->addColumn('contact', function($row) use ($grads) {
                    if (!$row->caseIntake) return '<span style="color:#94a3b8">—</span>';
                    $fn = $row->caseIntake->full_name ?? 'U';
                    $ln = $row->caseIntake->last_name ?? '';
                    $fi = strtoupper(substr($fn, 0, 1));
                    $li = strtoupper(substr($ln, 0, 1));
                    return '<div class="mc-client"><div class="mc-ava mc-ava-sm" style="background:'.$grads[ord($fi)%count($grads)].'">'.$fi.$li.'</div><span class="mc-name">'.trim($fn.' '.$ln).'</span></div>';
                })
                ->addColumn('duration_fmt', function($row) {
                    $dur = (int) $row->duration;
                    if (!$dur && $row->started_at && $row->ended_at) {
                        $dur = (int) $row->started_at->diffInSeconds($row->ended_at);
                    }
                    if (!$dur) return '—';
                    if ($dur >= 3600) {
                        return sprintf('%dh %dm %ds', floor($dur/3600), floor(($dur%3600)/60), $dur%60);
                    }
                    return gmdate('i:s', $dur);
                })
                ->addColumn('recording', function($row) {
                    if (!$row->recording_url) return '—';
                    return '<audio class="cr-audio" controls preload="none" src="'.e($row->recording_url).'"></audio>';
                })
                ->addColumn('status_badge', fn($row) => $this->callStatusBadge($row->status ?? ''))
                ->addColumn('disposition_badge', fn($row) => $row->disposition
                    ? '<span style="background:#f1f5f9;color:#475569;padding:2px 10px;border-radius:999px;font-size:11px;font-weight:600;display:inline-block;">' . ucwords(str_replace('_', ' ', $row->disposition)) . '</span>'
                    : '—')
                ->editColumn('created_at', fn($row) => $row->created_at
                    ? $row->created_at->format('M d, Y h:i A')
                    : '—')
                ->rawColumns(['status_badge', 'disposition_badge', 'agent_name', 'contact', 'recording'])
                ->make(true);
        }

        return view('dialer::admin.dialer.call-log');
    }

    // ── Test Ring (dev tool) ──────────────────────────────────────────────────

    public function testRing(Request $request)
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $agentId  = Auth::id();
        $identity = 'agent_' . $agentId;
        $from     = $this->agentFromNumber($agentId) ?? config('dialer.twilio.from_numbers.0');

        if (empty($from)) {
            return response()->json(['error' => 'No Twilio from-number configured'], 503);
        }

        $twiml = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<Response><Dial><Client><Identity>' . $identity . '</Identity>'
            . '<Parameter name="CallerName" value="Test Call"/>'
            . '</Client></Dial></Response>';

        try {
            $call = $this->twilioClient()->calls->create(
                'client:' . $identity,
                $from,
                ['twiml' => $twiml]
            );
            return response()->json(['ok' => true, 'call_sid' => $call->sid, 'identity' => $identity]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ── Recent Calls ──────────────────────────────────────────────────────────

    public function recentCalls()
    {
        abort_if(Gate::denies('dialer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $calls = DialerCall::where('agent_id', Auth::id())
            ->with('caseIntake:id,full_name,last_name')
            ->orderByDesc('id')
            ->limit(10)
            ->get(['id', 'case_id', 'phone', 'direction', 'disposition', 'status', 'duration', 'ended_at', 'created_at']);

        return response()->json($calls->map(function ($call) {
            $name = $call->caseIntake
                ? trim($call->caseIntake->full_name . ' ' . $call->caseIntake->last_name)
                : null;
            return [
                'id'          => $call->id,
                'case_id'     => $call->case_id,
                'phone'       => $call->phone,
                'name'        => $name ?: $call->phone,
                'direction'   => $call->direction,
                'status'      => $call->status,
                'disposition' => $call->disposition,
                'duration'    => $call->duration,
                'ended_at'    => ($call->ended_at ?? $call->created_at)?->diffForHumans(),
            ];
        }));
    }

    // ── Private Helpers ────────────────────────────────────────────────────────

    private function agentFromNumber(int $agentId): ?string
    {
        $status = DialerAgentStatus::forUser($agentId);

        if ($status->active_group_id) {
            $number = DialerGroup::where('id', $status->active_group_id)
                ->where('is_active', true)
                ->whereNotNull('twilio_number')
                ->value('twilio_number');
            if ($number) return $number;
        }

        $member = DialerGroupMember::where('user_id', $agentId)
            ->where('is_active', true)
            ->with(['group' => fn($q) => $q->where('is_active', true)->whereNotNull('twilio_number')])
            ->get()
            ->first(fn($m) => $m->group !== null);
        if ($member) return $member->group->twilio_number;

        $fromNumbers = array_values(array_filter(config('dialer.twilio.from_numbers', [])));
        return $fromNumbers[0] ?? null;
    }

    private function twilioClient(): \Twilio\Rest\Client
    {
        $sid   = config('dialer.twilio.sid');
        $token = config('dialer.twilio.auth_token');

        if (empty($sid) || empty($token)) {
            abort(503, 'Twilio not configured');
        }

        return new \Twilio\Rest\Client($sid, $token);
    }

    private function dialCustomerIntoConference(string $phone, string $confName, int $callId): void
    {
        if (empty(config('dialer.twilio.sid')) || empty(config('dialer.twilio.auth_token'))) {
            return;
        }

        $agentId = DialerCall::where('id', $callId)->value('agent_id');
        $from    = $agentId ? $this->agentFromNumber($agentId) : null;

        if (empty($from)) {
            return;
        }

        $inlineTwiml = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<Response><Dial><Conference '
            . 'startConferenceOnEnter="true" '
            . 'endConferenceOnExit="true" '
            . 'waitUrl="" '
            . 'beep="false">'
            . htmlspecialchars($confName)
            . '</Conference></Dial></Response>';

        try {
            $customerCall = $this->twilioClient()->calls->create($phone, $from, [
                'twiml'                => $inlineTwiml,
                'statusCallback'       => route('webhooks.twilio.call-status'),
                'statusCallbackMethod' => 'POST',
                'statusCallbackEvent'  => ['initiated', 'ringing', 'answered', 'completed'],
            ]);

            DialerCall::where('id', $callId)
                ->update(['customer_call_sid' => $customerCall->sid]);

        } catch (\Exception $e) {
            Log::error('Twilio dial error', ['error' => $e->getMessage()]);
        }
    }

    protected function callStatusBadge(string $status): string
    {
        if (! $status) return '<span style="color:#94a3b8">—</span>';
        $map = [
            'completed'   => ['#dcfce7', '#15803d'],
            'in-progress' => ['#dbeafe', '#1d4ed8'],
            'initiated'   => ['#e0e7ff', '#4338ca'],
            'queued'      => ['#fef9c3', '#713f12'],
            'no-answer'   => ['#fef3c7', '#92400e'],
            'busy'        => ['#fef3c7', '#92400e'],
            'failed'      => ['#fee2e2', '#991b1b'],
            'canceled'    => ['#f1f5f9', '#475569'],
        ];
        [$bg, $color] = $map[$status] ?? ['#f1f5f9', '#475569'];
        return '<span style="background:'.$bg.';color:'.$color.';padding:2px 10px;border-radius:999px;font-size:11px;font-weight:600;display:inline-block;">' . ucfirst($status) . '</span>';
    }

}
