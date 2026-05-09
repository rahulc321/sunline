<?php

namespace PowerDialer\Dialer\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DialerRecordingArchived
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly int    $dialerCallId,
        public readonly string $blobPath,
        public readonly string $recordingSid,
    ) {}
}
