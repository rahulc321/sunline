<?php

namespace PowerDialer\Dialer\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PowerDialer\Dialer\Events\DialerRecordingArchived;
use PowerDialer\Dialer\Models\DialerCall;

class ArchiveRecordingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 10;
    public int $backoff = 30;

    public function __construct(private int $dialerCallId) {}

    public function handle(): void
    {
        $call = DialerCall::find($this->dialerCallId);

        if (! $call || ! $call->recording_sid || ! $call->recording_url) {
            $this->release(30);
            return;
        }

        $blobPath = 'call-recordings/'
            . now()->format('Y/m')
            . '/' . $call->recording_sid . '.mp3';

        if (! Storage::disk('azure')->exists($blobPath)) {
            $sid   = config('dialer.twilio.sid');
            $token = config('dialer.twilio.auth_token');

            $response = Http::withBasicAuth($sid, $token)
                ->timeout(120)
                ->get($call->recording_url);

            if (! $response->successful()) {
                Log::warning('ArchiveRecordingJob: Twilio download failed', [
                    'recording_sid' => $call->recording_sid,
                    'status'        => $response->status(),
                ]);
                $this->release(60);
                return;
            }

            Storage::disk('azure')->put($blobPath, $response->body());

            Http::withBasicAuth($sid, $token)
                ->delete("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Recordings/{$call->recording_sid}");

            Log::info('ArchiveRecordingJob: recording archived', [
                'recording_sid' => $call->recording_sid,
                'blob_path'     => $blobPath,
            ]);
        }

        // Fire event so the host app can update CallConversation (or any other log)
        if (config('dialer.fire_events', true)) {
            event(new DialerRecordingArchived(
                dialerCallId: $this->dialerCallId,
                blobPath: $blobPath,
                recordingSid: $call->recording_sid,
            ));
        }
    }
}
