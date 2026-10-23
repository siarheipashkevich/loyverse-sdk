<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use Pashkevich\Loyverse\WebhookSignature;
use PHPUnit\Framework\TestCase;

/**
 * Class WebhookSignatureTest
 */
class WebhookSignatureTest extends TestCase
{
    public function test_computes_and_verifies_signature()
    {
        $payload = '{"type":"items.update"}';
        $secret = 'client-secret';

        $signature = WebhookSignature::compute($payload, $secret);

        $this->assertSame(hash_hmac('sha1', $payload, $secret), $signature);
        $this->assertTrue(WebhookSignature::verify($payload, $signature, $secret));
    }

    public function test_rejects_invalid_signature()
    {
        $this->assertFalse(WebhookSignature::verify('payload', 'invalid-signature', 'client-secret'));
    }
}
