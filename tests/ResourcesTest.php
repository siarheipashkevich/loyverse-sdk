<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use Pashkevich\Loyverse\Resources\{
    Inventory,
    Item,
    ItemComponent,
    ModifierOption,
    Receipt,
    ReceiptLineDiscount,
    ReceiptLineItem,
    ReceiptLineModifier,
    ReceiptLineTax,
    ReceiptPayment,
    ReceiptTotalDiscount,
    ReceiptTotalTax
};
use PHPUnit\Framework\TestCase;

class ResourcesTest extends TestCase
{
    public function test_modifier_option_exposes_timestamps(): void
    {
        $option = new ModifierOption([
            'id' => 'option-id',
            'name' => 'Large',
            'price' => 1.5,
            'position' => 1,
            'created_at' => '2020-01-01T00:00:00.000Z',
            'updated_at' => '2020-01-02T00:00:00.000Z',
            'deleted_at' => null,
        ]);

        $this->assertSame('2020-01-01T00:00:00.000Z', $option->createdAt);
        $this->assertSame('2020-01-02T00:00:00.000Z', $option->updatedAt);
        $this->assertNull($option->deletedAt);
    }

    public function test_inventory_exposes_cursor(): void
    {
        $inventory = new Inventory([
            'inventory_levels' => [],
            'cursor' => 'next-cursor',
        ]);

        $this->assertSame('next-cursor', $inventory->cursor);
        $this->assertSame([], $inventory->inventoryLevels);
    }

    public function test_receipt_hydrates_nested_models(): void
    {
        $receipt = new Receipt([
            'receipt_number' => '1-1',
            'tip' => 1.5,
            'surcharge' => 2.5,
            'total_discounts' => [[
                'id' => 'discount-id',
                'type' => 'FIXED_PERCENT',
                'name' => 'Discount',
                'percentage' => 10.5,
                'money_amount' => 1.25,
            ]],
            'total_taxes' => [[
                'id' => 'tax-id',
                'type' => 'INCLUDED',
                'name' => 'Tax',
                'rate' => 5.5,
                'money_amount' => 0.75,
            ]],
            'line_items' => [[
                'id' => 'line-id',
                'item_id' => 'item-id',
                'variant_id' => 'variant-id',
                'item_name' => 'Item',
                'variant_name' => 'Large',
                'sku' => 'SKU',
                'quantity' => 2.0,
                'price' => 10.0,
                'gross_total_money' => 20.0,
                'total_money' => 19.0,
                'cost' => 5.0,
                'cost_total' => 10.0,
                'line_note' => null,
                'line_taxes' => [[
                    'money_amount' => 0.5,
                    'id' => 'line-tax-id',
                    'type' => 'INCLUDED',
                    'name' => 'Tax',
                    'rate' => 5.0,
                ]],
                'total_discount' => 1.0,
                'line_discounts' => [[
                    'id' => 'line-discount-id',
                    'type' => 'FIXED_AMOUNT',
                    'name' => 'Line discount',
                    'percentage' => null,
                    'money_amount' => 1.0,
                ]],
                'line_modifiers' => [[
                    'id' => 'modifier-id',
                    'modifier_option_id' => 'option-id',
                    'name' => 'Modifier',
                    'option' => 'Option',
                    'price' => 0.5,
                    'money_amount' => 1.0,
                ]],
            ]],
            'payments' => [[
                'payment_type_id' => 'payment-type-id',
                'name' => 'Cash',
                'type' => 'CASH',
                'money_amount' => 19.0,
                'paid_at' => '2020-01-01T00:00:00.000Z',
                'payment_details' => null,
            ]],
        ]);

        $this->assertInstanceOf(ReceiptTotalDiscount::class, $receipt->totalDiscounts[0]);
        $this->assertInstanceOf(ReceiptTotalTax::class, $receipt->totalTaxes[0]);
        $this->assertInstanceOf(ReceiptLineItem::class, $receipt->lineItems[0]);
        $this->assertInstanceOf(ReceiptLineTax::class, $receipt->lineItems[0]->lineTaxes[0]);
        $this->assertInstanceOf(ReceiptLineDiscount::class, $receipt->lineItems[0]->lineDiscounts[0]);
        $this->assertInstanceOf(ReceiptLineModifier::class, $receipt->lineItems[0]->lineModifiers[0]);
        $this->assertInstanceOf(ReceiptPayment::class, $receipt->payments[0]);
        $this->assertSame(1.5, $receipt->tip);
        $this->assertSame(2.5, $receipt->surcharge);
    }

    public function test_item_hydrates_components(): void
    {
        $item = new Item([
            'id' => 'item-id',
            'components' => [[
                'variant_id' => 'component-variant-id',
                'quantity' => 2.5,
            ]],
        ]);

        $this->assertInstanceOf(ItemComponent::class, $item->components[0]);
        $this->assertSame('component-variant-id', $item->components[0]->variantId);
        $this->assertSame(2.5, $item->components[0]->quantity);
    }
}
