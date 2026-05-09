# power-dialer/laravel-dialer

Twilio-powered dialer package for Laravel 9+. Includes outbound dialing, inbound call routing, agent softphone, call groups, voicemail, SMS, TCPA compliance, and call recording.

---

## Requirements

- PHP 8.1+
- Laravel 9 / 10 / 11
- Redis (for agent polling)
- Twilio account

---

## Installation

### Step 1 — Add to `composer.json`

**Option A — From GitHub (recommended):**

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/YOUR-USERNAME/laravel-dialer"
    }
],
"require": {
    "power-dialer/laravel-dialer": "^1.0"
}
```

**Option B — Local folder (same machine / development):**

Copy the package into your project:
```
your-project/
└── packages/
    └── power-dialer/
        └── laravel-dialer/
```

Then add to `composer.json`:

```json
"repositories": [
    {
        "type": "path",
        "url": "./packages/power-dialer/laravel-dialer",
        "options": { "symlink": true }
    }
],
"require": {
    "power-dialer/laravel-dialer": "*@dev"
}
```

Then run:

```bash
composer install
```

> If you get extension errors (ext-gd, ext-sodium), add `--ignore-platform-reqs`

---

### Step 2 — Publish config

```bash
php artisan vendor:publish --tag=dialer-config
```

This creates `config/dialer.php` in your project.

---

### Step 3 — Run migrations

```bash
php artisan migrate
```

The package creates these tables automatically:

| Table | Purpose |
|---|---|
| `dialer_contacts` | Built-in contact records (name, phone, state, consent) |
| `dialer_calls` | Call records (outbound + inbound) |
| `dialer_queues` | Contacts queued for dialing |
| `dialer_groups` | Agent groups with routing rules |
| `dialer_group_members` | Agents assigned to groups |
| `dialer_phone_numbers` | Twilio numbers assigned to groups |
| `dialer_agent_statuses` | Real-time agent availability |
| `tcpa_settings` | TCPA quiet hours config |

---

### Step 4 — Set `.env`

```env
# ── Twilio ──────────────────────────────────────────
TWILIO_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_APP_SID=APxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_API_KEY=SKxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_API_SECRET=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

# ── Dialer ──────────────────────────────────────────
DIALER_PROJECT_KEY=my-project
DIALER_USER_MODEL=App\Models\User
DIALER_LAYOUT=layouts.admin

# ── Route prefix ────────────────────────────────────
# Controls the URL the dialer is served under.
#
# Leave empty  →  /dialer             (route name: dialer.index)
# Set "admin"  →  /admin/dialer       (route name: admin.dialer.index)
# Set anything →  /anything/dialer    (route name: anything.dialer.index)
DIALER_ROUTE_PREFIX=
```

---

### Step 5 — Contact model

**No setup needed by default.**

The package ships with a built-in `DialerContact` model backed by the `dialer_contacts` table. You can add contacts directly:

```php
use PowerDialer\Dialer\Models\DialerContact;

DialerContact::create([
    'first_name'  => 'John',
    'last_name'   => 'Doe',
    'phone'       => '+12025551234',
    'state'       => 'NY',
    'has_consent' => true,
]);
```

**Using your own existing model instead:**

Set in `.env`:
```env
DIALER_CONTACT_MODEL=App\Models\YourModel
```

Then implement the `DialableContact` interface on that model:

```php
use PowerDialer\Dialer\Contracts\DialableContact;

class YourModel extends Model implements DialableContact
{
    public function getDialerPhone(): ?string
    {
        return $this->phone;
    }

    public function getDialerName(): ?string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getDialerState(): ?string
    {
        return $this->state;
    }

    public function getDialerHasConsent(): bool
    {
        return (bool) $this->has_consent;
    }

    public function stampCalled(): void
    {
        $this->update(['last_called_at' => now()]);
    }

    public static function findByPhone(string $e164): ?static
    {
        return static::where('phone', $e164)->first();
    }

    public static function isOptedOutByPhone(string $phone): bool
    {
        return static::where('phone', $phone)
            ->where('has_consent', false)
            ->exists();
    }
}
```

---

### Step 6 — Register event listeners

Create these 3 listener classes in your app, then register them in `app/Providers/EventServiceProvider.php`:

```php
use PowerDialer\Dialer\Events\DialerCallDispositioned;
use PowerDialer\Dialer\Events\DialerRecordingArchived;
use PowerDialer\Dialer\Events\DialerQueueUpdated;

protected $listen = [
    // Fired when agent dispositions a call — save to your call log
    DialerCallDispositioned::class => [
        \App\Listeners\LogCallConversation::class,
    ],

    // Fired when recording is saved to storage — update your call log
    DialerRecordingArchived::class => [
        \App\Listeners\SaveCallRecording::class,
    ],

    // Fired when queue changes — bump Redis poll version
    DialerQueueUpdated::class => [
        \App\Listeners\BumpDialerPoll::class,
    ],
];
```

**Example `LogCallConversation` listener:**

```php
namespace App\Listeners;

use App\Models\CallLog;
use PowerDialer\Dialer\Events\DialerCallDispositioned;

class LogCallConversation
{
    public function handle(DialerCallDispositioned $event): void
    {
        CallLog::create([
            'contact_id'      => $event->caseId,
            'agent_id'        => $event->agentId,
            'outcome'         => $event->disposition,
            'notes'           => $event->notes,
            'duration'        => $event->duration,
            'twilio_call_sid' => $event->twilioCallSid,
            'direction'       => $event->direction,
            'recording_sid'   => $event->recordingSid,
            'started_at'      => $event->startedAt,
            'ended_at'        => $event->endedAt,
            'dialer_call_id'  => $event->dialerCallId,
        ]);
    }
}
```

---

### Step 7 — Set Twilio webhook URLs

In your [Twilio console](https://console.twilio.com), configure each phone number:

| Event | URL |
|---|---|
| Voice (incoming call) | `https://your-app.com/webhooks/twilio/voice` |
| Call status callback | `https://your-app.com/webhooks/twilio/call-status` |
| Recording callback | `https://your-app.com/webhooks/twilio/recording` |
| SMS incoming | `https://your-app.com/webhooks/twilio/sms-inbound` |
| Fallback | `https://your-app.com/webhooks/twilio/inbound-fallback` |

---

## Done

Open your browser and visit:

```
# If DIALER_ROUTE_PREFIX is empty:
https://your-app.com/dialer

# If DIALER_ROUTE_PREFIX=admin:
https://your-app.com/admin/dialer
```

---

## Available Routes

### Admin (auth-protected)

| URL | Description |
|---|---|
| `/dialer` | Agent dashboard |
| `/dialer/softphone` | Softphone UI |
| `/dialer/queue` | Dialer queue |
| `/dialer/call-log` | Call history |
| `/dialer/supervisor` | Supervisor view |
| `/dialer/groups` | Manage groups |

> All URLs are prefixed with `DIALER_ROUTE_PREFIX` if set (e.g. `/admin/dialer`)

### Webhooks (Twilio posts here — no auth)

| URL | Description |
|---|---|
| `POST /webhooks/twilio/voice` | Inbound/outbound voice entry |
| `POST /webhooks/twilio/call-status` | Call status updates |
| `POST /webhooks/twilio/recording` | Recording ready |
| `POST /webhooks/twilio/sms-inbound` | Inbound SMS / opt-out |
| `POST /webhooks/twilio/inbound-fallback` | No-agent fallback |
| `POST /webhooks/twilio/voicemail-complete` | Voicemail done |

---

## Upgrading

```bash
composer update power-dialer/laravel-dialer
php artisan migrate
php artisan vendor:publish --tag=dialer-config --force
```
