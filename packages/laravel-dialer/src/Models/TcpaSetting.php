<?php

namespace PowerDialer\Dialer\Models;

use Illuminate\Database\Eloquent\Model;

class TcpaSetting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'enabled'                  => 'boolean',
        'enforce_per_state'        => 'boolean',
        'dnc_check_enabled'        => 'boolean',
        'consent_required_for_sms' => 'boolean',
    ];

    public static function forProject(string $projectKey): self
    {
        return static::firstOrCreate(
            ['project_key' => $projectKey],
            [
                'enabled'                  => true,
                'quiet_hours_start'        => '21:00:00',
                'quiet_hours_end'          => '08:00:00',
                'timezone'                 => 'America/New_York',
                'enforce_per_state'        => true,
                'dnc_check_enabled'        => false,
                'consent_required_for_sms' => true,
            ]
        );
    }
}
