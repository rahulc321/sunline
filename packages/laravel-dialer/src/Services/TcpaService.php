<?php

namespace PowerDialer\Dialer\Services;

use Carbon\Carbon;
use PowerDialer\Dialer\Models\TcpaSetting;

class TcpaService
{
    public TcpaSetting $settings;

    public function __construct()
    {
        $this->settings = TcpaSetting::forProject(config('dialer.project_key'));
    }

    public function isOptedOutByPhone(string $phone): bool
    {
        $contactClass = config('dialer.contact_model');

        if (method_exists($contactClass, 'isOptedOutByPhone')) {
            return $contactClass::isOptedOutByPhone($phone);
        }

        return false;
    }

    public function isQuietHoursByState(?string $state): bool
    {
        if (! $this->settings->enabled) {
            return false;
        }

        $tz  = $this->resolveTimezone($state);
        $now = Carbon::now($tz);

        $start = Carbon::parse($this->settings->quiet_hours_start, $tz);
        $end   = Carbon::parse($this->settings->quiet_hours_end,   $tz);

        // Window crosses midnight (e.g. 21:00 → 08:00)
        if ($start->gt($end)) {
            return $now->gte($start) || $now->lt($end);
        }

        return $now->between($start, $end);
    }

    public function nextAllowedAtByState(?string $state): Carbon
    {
        $tz   = $this->resolveTimezone($state);
        $now  = Carbon::now($tz);
        $next = $now->copy()->setTimeFromTimeString($this->settings->quiet_hours_end);

        if ($next->lte($now)) {
            $next->addDay();
        }

        return $next->utc();
    }

    protected function resolveTimezone(?string $state): string
    {
        if ($this->settings->enforce_per_state && $state) {
            $map = config('dialer.state_timezones', []);
            $key = strtoupper(trim($state));
            if (isset($map[$key])) {
                return $map[$key];
            }
        }

        return $this->settings->timezone;
    }
}
