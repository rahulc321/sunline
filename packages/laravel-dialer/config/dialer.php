<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Host App Models
    |--------------------------------------------------------------------------
    | user_model    — the app's User Eloquent model (used in all belongsTo agent relations)
    | contact_model — must implement PowerDialer\Dialer\Contracts\DialableContact interface
    */
    'user_model'       => env('DIALER_USER_MODEL', \App\Models\User::class),
    'contact_model'    => env('DIALER_CONTACT_MODEL', \PowerDialer\Dialer\Models\DialerContact::class),
    'contact_edit_url' => env('DIALER_CONTACT_EDIT_URL', ''),

    /*
    |--------------------------------------------------------------------------
    | Project Key
    |--------------------------------------------------------------------------
    | Scopes all dialer queue, call, and TCPA records to this project key.
    | Enables reuse across multiple Laravel applications sharing the same DB.
    */
    'project_key' => env('DIALER_PROJECT_KEY', env('AUTOMATION_PROJECT_KEY', 'default')),

    /*
    |--------------------------------------------------------------------------
    | Twilio (Voice)
    |--------------------------------------------------------------------------
    */
    'twilio' => [
        'sid'          => env('TWILIO_SID'),
        'auth_token'   => env('TWILIO_AUTH_TOKEN'),
        'from_numbers' => array_values(array_filter([
            env('TWILIO_FROM_NUMBER_1'),
            env('TWILIO_FROM_NUMBER_2'),
        ])),
        'app_sid'    => env('TWILIO_APP_SID'),
        'api_key'    => env('TWILIO_API_KEY'),
        'api_secret' => env('TWILIO_API_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Dialer Operational Settings
    |--------------------------------------------------------------------------
    */
    'dialer' => [
        'max_concurrent_agents' => env('DIALER_MAX_AGENTS', 200),
    ],

    /*
    |--------------------------------------------------------------------------
    | n8n Webhook Orchestration
    |--------------------------------------------------------------------------
    */
    'n8n' => [
        'webhook'            => env('N8N_WEBHOOK'),
        'dial_webhook'       => env('N8N_DIAL_WEBHOOK'),
        'automation_webhook' => env('N8N_AUTOMATION_WEBHOOK'),
        'webhook_secret'     => env('N8N_WEBHOOK_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | TCPA Compliance
    |--------------------------------------------------------------------------
    */
    'tcpa' => [
        'enabled'                  => env('TCPA_ENABLED', true),
        'quiet_hours_start'        => env('TCPA_QUIET_START', '21:00'),
        'quiet_hours_end'          => env('TCPA_QUIET_END', '08:00'),
        'timezone'                 => env('TCPA_TIMEZONE', 'America/New_York'),
        'enforce_per_state'        => env('TCPA_ENFORCE_PER_STATE', true),
        'consent_required_for_sms' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | State → Timezone Map (US)
    |--------------------------------------------------------------------------
    */
    'state_timezones' => [
        'AL' => 'America/Chicago',    'AK' => 'America/Anchorage',
        'AZ' => 'America/Phoenix',    'AR' => 'America/Chicago',
        'CA' => 'America/Los_Angeles','CO' => 'America/Denver',
        'CT' => 'America/New_York',   'DE' => 'America/New_York',
        'FL' => 'America/New_York',   'GA' => 'America/New_York',
        'HI' => 'Pacific/Honolulu',   'ID' => 'America/Denver',
        'IL' => 'America/Chicago',    'IN' => 'America/Indiana/Indianapolis',
        'IA' => 'America/Chicago',    'KS' => 'America/Chicago',
        'KY' => 'America/New_York',   'LA' => 'America/Chicago',
        'ME' => 'America/New_York',   'MD' => 'America/New_York',
        'MA' => 'America/New_York',   'MI' => 'America/Detroit',
        'MN' => 'America/Chicago',    'MS' => 'America/Chicago',
        'MO' => 'America/Chicago',    'MT' => 'America/Denver',
        'NE' => 'America/Chicago',    'NV' => 'America/Los_Angeles',
        'NH' => 'America/New_York',   'NJ' => 'America/New_York',
        'NM' => 'America/Denver',     'NY' => 'America/New_York',
        'NC' => 'America/New_York',   'ND' => 'America/Chicago',
        'OH' => 'America/New_York',   'OK' => 'America/Chicago',
        'OR' => 'America/Los_Angeles','PA' => 'America/New_York',
        'RI' => 'America/New_York',   'SC' => 'America/New_York',
        'SD' => 'America/Chicago',    'TN' => 'America/Chicago',
        'TX' => 'America/Chicago',    'UT' => 'America/Denver',
        'VT' => 'America/New_York',   'VA' => 'America/New_York',
        'WA' => 'America/Los_Angeles','WV' => 'America/New_York',
        'WI' => 'America/Chicago',    'WY' => 'America/Denver',
        'DC' => 'America/New_York',
    ],

    /*
    |--------------------------------------------------------------------------
    | Blade Layout
    |--------------------------------------------------------------------------
    | The dialer views extend this layout. Set to your app's admin layout name.
    */
    'layout' => env('DIALER_LAYOUT', 'layouts.admin'),

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    */
    'route_prefix'      => env('DIALER_ROUTE_PREFIX', ''),
    'route_name_prefix' => env('DIALER_ROUTE_PREFIX', '') !== '' ? env('DIALER_ROUTE_PREFIX', '') . '.' : '',
    'auth_middleware'   => ['auth'],

    /*
    |--------------------------------------------------------------------------
    | Gate Definitions
    |--------------------------------------------------------------------------
    | Set to false if your host app already defines dialer_access / dialer_supervisor
    | gates (e.g. via an AuthGates middleware).
    */
    'define_gates' => true,

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    | When true the package fires Laravel events instead of calling host-app
    | classes directly. Host app registers listeners in EventServiceProvider.
    |
    | DialerCallDispositioned  → log to CallConversation
    | DialerRecordingArchived  → update CallConversation recording path
    | DialerQueueUpdated       → call PollService::bumpDialer()
    */
    'fire_events' => true,

];
