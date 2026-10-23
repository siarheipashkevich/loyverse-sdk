<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use GuzzleHttp\Psr7\Response;
use Pashkevich\Loyverse\Data\{CreateItemData, CreateReceiptData, InventoryUpdate, RefundReceiptData};
use Pashkevich\Loyverse\Loyverse;
use Pashkevich\Loyverse\Resources\{Inventory, Item, Receipt};
use PHPUnit\Framework\TestCase;

class DataTest extends TestCase
{
    use FakesHttpRequests;

    public function test_create_receipt_data_is_converted_to_array(): void
    {
        $data = new CreateReceiptData(
            'store-id',
            [['variant_id' => 'variant-id', 'quantity' => 1]],
            [['payment_type_id' => 'payment-type-id', 'money_amount' => 10.0]],
            [],
            'employee-id',
            'order-1',
            'customer-id',
            'My app',
            '2020-01-01T00:00:00.000Z',
            'note',
        );

        $this->assertSame([
            'store_id' => 'store-id',
            'line_items' => [['variant_id' => 'variant-id', 'quantity' => 1]],
            'payments' => [['payment_type_id' => 'payment-type-id', 'money_amount' => 10.0]],
            'total_discounts' => [],
            'employee_id' => 'employee-id',
            'order' => 'order-1',
            'customer_id' => 'customer-id',
            'source' => 'My app',
            'receipt_date' => '2020-01-01T00:00:00.000Z',
            'note' => 'note',
        ], $data->toArray());
    }

    public function test_refund_receipt_data_is_converted_to_array(): void
    {
        $data = new RefundReceiptData(
            [['id' => 'line-item-id', 'quantity' => 1]],
            '2020-01-01T00:00:00.000Z',
            'My app',
            'employee-id',
            'store-id',
        );

        $this->assertSame([
            'line_items' => [['id' => 'line-item-id', 'quantity' => 1]],
            'receipt_date' => '2020-01-01T00:00:00.000Z',
            'source' => 'My app',
            'employee_id' => 'employee-id',
            'store_id' => 'store-id',
        ], $data->toArray());
    }

    public function test_inventory_update_is_converted_to_array(): void
    {
        $data = new InventoryUpdate([
            ['variant_id' => 'variant-id', 'store_id' => 'store-id', 'stock_after' => 5],
        ]);

        $this->assertSame([
            'inventory_levels' => [
                ['variant_id' => 'variant-id', 'store_id' => 'store-id', 'stock_after' => 5],
            ],
        ], $data->toArray());
    }

    public function test_create_item_data_is_converted_to_array(): void
    {
        $data = new CreateItemData(
            'Item name',
            [['sku' => 'SKU']],
            'Description',
            'reference-id',
            'category-id',
            true,
            false,
            false,
            false,
            [],
            'supplier-id',
            ['tax-id'],
            ['modifier-id'],
            'SQUARE',
            'GREEN',
        );

        $this->assertSame([
            'item_name' => 'Item name',
            'variants' => [['sku' => 'SKU']],
            'description' => 'Description',
            'reference_id' => 'reference-id',
            'category_id' => 'category-id',
            'track_stock' => true,
            'sold_by_weight' => false,
            'is_composite' => false,
            'use_production' => false,
            'components' => [],
            'primary_supplier_id' => 'supplier-id',
            'tax_ids' => ['tax-id'],
            'modifiers_ids' => ['modifier-id'],
            'form' => 'SQUARE',
            'color' => 'GREEN',
        ], $data->toArray());
    }

    public function test_sdk_accepts_receipt_dto(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $data = new CreateReceiptData('store-id');

        $this->expectRequest('POST', 'receipts', ['json' => $data->toArray()], new Response(200, [], '{}'));

        $this->assertInstanceOf(Receipt::class, $loyverse->createReceipt($data));
    }

    public function test_sdk_accepts_refund_dto(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $data = new RefundReceiptData([['id' => 'line-item-id', 'quantity' => 1]]);

        $this->expectRequest('POST', 'receipts/1-1/refund', ['json' => $data->toArray()], new Response(200, [], '{}'));

        $this->assertInstanceOf(Receipt::class, $loyverse->createReceiptRefund('1-1', $data));
    }

    public function test_sdk_accepts_inventory_dto(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $data = new InventoryUpdate([
            ['variant_id' => 'variant-id', 'store_id' => 'store-id', 'stock_after' => 5],
        ]);

        $this->expectRequest('POST', 'inventory', ['json' => $data->toArray()], new Response(200, [], '{}'));

        $this->assertInstanceOf(Inventory::class, $loyverse->updateInventory($data));
    }

    public function test_sdk_accepts_item_dto(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $data = new CreateItemData('Item name');

        $this->expectRequest('POST', 'items', ['json' => $data->toArray()], new Response(200, [], '{}'));

        $this->assertInstanceOf(Item::class, $loyverse->createItem($data));
    }
}
