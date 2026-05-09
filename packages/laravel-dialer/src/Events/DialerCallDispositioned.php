<?php

namespace PowerDialer\Dialer\Events;

use Carbon\Carbon;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DialerCallDispositioned
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly int     $dialerCallId,
        public readonly int     $agentId,
        public readonly ?int    $caseId,
        public readonly string  $disposition,
        public readonly ?string $notes,
        public readonly ?int    $duration,
        public readonly ?string $twilioCallSid,
        public readonly string  $direction,
        public readonly ?string $recordingSid,
        public readonly ?Carbon $startedAt,
        public readonly ?Carbon $endedAt,
    ) {}
}
