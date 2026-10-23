<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse;

class WebhookSignature
{
    /**
     * Compute the signature for the given payload.
     */
    public static function compute(string $payload, #[\SensitiveParameter] string $clientSecret): string
    {
        return hash_hmac('sha1', $payload, $clientSecret);
    }

    /**
     * Verify the signature of an incoming webhook request.
     */
    public static function verify(string $payload, string $signature, #[\SensitiveParameter] string $clientSecret): bool
    {
        return hash_equals(self::compute($payload, $clientSecret), $signature);
    }
}
