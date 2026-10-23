<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use Pashkevich\Loyverse\Exceptions\RateLimitedException;
use Pashkevich\Loyverse\Loyverse;
use PHPUnit\Framework\TestCase;

class RetryTest extends TestCase
{
    public function test_retry_on_rate_limit_uses_retry_after()
    {
        $loyverse = Loyverse::fake();

        $attempts = 0;
        $delays = [];

        $result = $loyverse->retryOnRateLimit(
            function () use (&$attempts) {
                $attempts++;

                if ($attempts === 1) {
                    throw new RateLimitedException()
                        ->setContext(429, [], 'RATE_LIMITED', '2');
                }

                return 'ok';
            },
            3,
            1,
            function (int $delay) use (&$delays) {
                $delays[] = $delay;
            }
        );

        $this->assertSame('ok', $result);
        $this->assertSame(2, $attempts);
        $this->assertSame([2], $delays);
    }

    public function test_retry_on_rate_limit_throws_after_max_attempts()
    {
        $this->expectException(RateLimitedException::class);

        $loyverse = Loyverse::fake();

        $loyverse->retryOnRateLimit(
            function () {
                throw new RateLimitedException()
                    ->setContext(429, [], 'RATE_LIMITED', '1');
            },
            2,
            1,
            function () {}
        );
    }
}
