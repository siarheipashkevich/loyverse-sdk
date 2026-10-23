<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests\Integration;

use Pashkevich\Loyverse\Loyverse;
use PHPUnit\Framework\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    protected static ?Loyverse $loyverse = null;

    protected static bool $skipped = false;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        if (static::$loyverse !== null) {
            return;
        }

        $envFile = __DIR__.'/.env.testing';

        if (! file_exists($envFile)) {
            static::$skipped = true;

            return;
        }

        $config = static::parseEnv($envFile);

        $token = $config['LOYVERSE_API_TOKEN'] ?? '';

        if ($token === '') {
            static::$skipped = true;

            return;
        }

        static::$loyverse = new Loyverse($token);

        $baseUri = $config['LOYVERSE_API_URL'] ?? null;

        if ($baseUri !== null && $baseUri !== '') {
            static::$loyverse->setBaseUri($baseUri);
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        if (static::$skipped) {
            $this->markTestSkipped('Integration tests require tests/Integration/.env.testing.');
        }

        sleep(1);
    }

    protected function loyverse(): Loyverse
    {
        return static::$loyverse;
    }

    private static function parseEnv(string $path): array
    {
        $config = [];

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $config[trim($key)] = trim($value);
            }
        }

        return $config;
    }
}
