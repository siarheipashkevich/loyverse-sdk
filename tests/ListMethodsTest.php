<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use GuzzleHttp\Psr7\Response;
use Pashkevich\Loyverse\Loyverse;
use Pashkevich\Loyverse\Resources\{
    Category,
    Customer,
    Discount,
    Employee,
    InventoryLevel,
    Item,
    Modifier,
    PaymentType,
    PosDevice,
    Receipt,
    Shift,
    Store,
    Supplier,
    Tax,
    Variant,
    Webhook
};
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ListMethodsTest extends TestCase
{
    use FakesHttpRequests;

    #[DataProvider('listMethodsProvider')]
    public function test_list_methods_return_pages_with_cursor(
        string $method,
        string $path,
        string $key,
        string $class
    ): void {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $this->expectRequest('GET', $path, [], new Response(200, [], json_encode([
            $key => [['id' => 'resource-id']],
            'cursor' => 'next-cursor',
        ])));

        $page = $loyverse->{$method}();

        $this->assertArrayHasKey($key, $page);
        $this->assertArrayHasKey('cursor', $page);
        $this->assertSame('next-cursor', $page['cursor']);
        $this->assertCount(1, $page[$key]);
        $this->assertInstanceOf($class, $page[$key][0]);
    }

    /**
     * @return array<string, array{0: string, 1: string, 2: string, 3: class-string<\Pashkevich\Loyverse\Resources\Resource>}>
     */
    public static function listMethodsProvider(): array
    {
        return [
            'categories' => ['categories', 'categories', 'categories', Category::class],
            'customers' => ['customers', 'customers', 'customers', Customer::class],
            'discounts' => ['discounts', 'discounts', 'discounts', Discount::class],
            'employees' => ['employees', 'employees', 'employees', Employee::class],
            'inventory' => ['inventory', 'inventory', 'inventory_levels', InventoryLevel::class],
            'items' => ['items', 'items', 'items', Item::class],
            'modifiers' => ['modifiers', 'modifiers', 'modifiers', Modifier::class],
            'payment types' => ['paymentTypes', 'payment_types', 'payment_types', PaymentType::class],
            'pos devices' => ['posDevices', 'pos_devices', 'pos_devices', PosDevice::class],
            'receipts' => ['receipts', 'receipts', 'receipts', Receipt::class],
            'shifts' => ['shifts', 'shifts', 'shifts', Shift::class],
            'stores' => ['stores', 'stores', 'stores', Store::class],
            'suppliers' => ['suppliers', 'suppliers', 'suppliers', Supplier::class],
            'taxes' => ['taxes', 'taxes', 'taxes', Tax::class],
            'variants' => ['variants', 'variants', 'variants', Variant::class],
            'webhooks' => ['webhooks', 'webhooks', 'webhooks', Webhook::class],
        ];
    }

    public function test_list_methods_return_null_cursor_when_missing(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $this->expectRequest('GET', 'discounts', [], new Response(200, [], json_encode([
            'discounts' => [['id' => 'discount-id']],
        ])));

        $page = $loyverse->discounts();

        $this->assertNull($page['cursor']);
        $this->assertCount(1, $page['discounts']);
    }
}
