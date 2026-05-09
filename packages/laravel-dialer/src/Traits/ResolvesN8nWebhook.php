<?php

namespace PowerDialer\Dialer\Traits;

trait ResolvesN8nWebhook
{
    protected function n8nUrl(string $type): ?string
    {
        return config("dialer.n8n.{$type}_webhook") ?: config('dialer.n8n.webhook') ?: null;
    }

    protected function n8nHeaders(): array
    {
        return ['x-webhook-secret' => config('dialer.n8n.webhook_secret')];
    }
}
