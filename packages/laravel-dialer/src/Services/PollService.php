<?php

namespace PowerDialer\Dialer\Services;

use Illuminate\Support\Facades\Redis;

class PollService
{
    public static function dialerKey(string $projectKey): string
    {
        return "poll:dv:{$projectKey}";
    }

    public static function inboundKey(int $agentId): string
    {
        return "poll:inbound:{$agentId}";
    }

    public static function bumpDialer(string $projectKey): void
    {
        Redis::incr(self::dialerKey($projectKey));
    }

    public static function setInboundCall(int $agentId, array $callData): void
    {
        Redis::setex(self::inboundKey($agentId), 60, json_encode($callData));
        Redis::incr(self::dialerKey((string) $agentId));
    }

    public static function clearInboundCall(int $agentId): void
    {
        Redis::del(self::inboundKey($agentId));
    }

    public static function getInboundCall(int $agentId): ?array
    {
        $raw = Redis::get(self::inboundKey($agentId));
        return $raw ? json_decode($raw, true) : null;
    }

    public static function getDialerVersion(string $projectKey): int
    {
        return (int) Redis::get(self::dialerKey($projectKey));
    }
}
