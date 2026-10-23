<?php

namespace Pashkevich\Loyverse;

/**
 * Class WebhookSignature
 *
 * @package Pashkevich\Loyverse
 */
class WebhookSignature
{
    /**
     * Compute the signature for the given payload.
     *
     * @param string $payload
     * @param string $clientSecret
     * @return string
     */
    public static function compute(string $payload, string $clientSecret): string
    {
        return hash_hmac('sha1', $payload, $clientSecret);
    }

    /**
     * Verify the signature of an incoming webhook request.
     *
     * @param string $payload
     * @param string $signature
     * @param string $clientSecret
     * @return bool
     */
    public static function verify(string $payload, string $signature, string $clientSecret): bool
    {
        return hash_equals(self::compute($payload, $clientSecret), $signature);
    }
}
