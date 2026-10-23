<?php

namespace Pashkevich\Loyverse\Tests;

use PHPUnit\Framework\TestCase;
use Pashkevich\Loyverse\WebhookSignature;

/**
 * Class WebhookSignatureTest
 *
 * @package Pashkevich\Loyverse\Tests
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
