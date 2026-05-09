<?php

namespace PowerDialer\Dialer\Contracts;

interface DialableContact
{
    public function getDialerPhone(): ?string;

    public function getDialerName(): ?string;

    public function getDialerState(): ?string;

    public function getDialerHasConsent(): bool;

    public function stampCalled(): void;

    public static function findByPhone(string $e164Digits): ?static;

    public static function isOptedOutByPhone(string $phone): bool;
}
