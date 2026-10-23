<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests\Integration;

class SmokeTest extends IntegrationTestCase
{
    public function test_merchant(): void
    {
        $merchant = $this->loyverse()->merchant();

        $this->assertNotSame('', $merchant->id);
        $this->assertNotSame('', $merchant->businessName);
    }

    public function test_categories(): void
    {
        $page = $this->loyverse()->categories(['limit' => 1]);

        $this->assertArrayHasKey('categories', $page);
        $this->assertArrayHasKey('cursor', $page);
    }

    public function test_stores(): void
    {
        $page = $this->loyverse()->stores(['limit' => 1]);

        $this->assertArrayHasKey('stores', $page);
    }
}
