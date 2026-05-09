<?php

namespace PowerDialer\Dialer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PowerDialer\Dialer\Contracts\DialableContact;

class DialerContact extends Model implements DialableContact
{
    use SoftDeletes;

    protected $table = 'dialer_contacts';

    protected $guarded = [];

    protected $casts = [
        'has_consent'    => 'boolean',
        'last_called_at' => 'datetime',
    ];

    public function getDialerPhone(): ?string
    {
        return $this->phone ?? null;
    }

    public function getDialerName(): ?string
    {
        return trim($this->first_name . ' ' . $this->last_name) ?: ($this->name ?? null);
    }

    public function getDialerState(): ?string
    {
        return $this->state ?? null;
    }

    public function getDialerHasConsent(): bool
    {
        return (bool) ($this->has_consent ?? true);
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
