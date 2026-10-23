<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use Pashkevich\Loyverse\Resources\{Category, InventoryLevel, Item};
use PHPUnit\Framework\TestCase;

class HydrationTest extends TestCase
{
    public function test_unknown_fields_are_still_available(): void
    {
        $category = new Category([
            'id' => 'category-id',
            'name' => 'Fruits',
            'unknown_field' => 'value',
        ]);

        $this->assertSame('value', get_object_vars($category)['unknownField']);
    }

    public function test_null_is_skipped_for_non_nullable_properties(): void
    {
        $category = new Category([
            'id' => 'category-id',
            'name' => null,
        ]);

        $this->assertFalse(isset($category->name));
    }

    public function test_null_is_assigned_to_nullable_properties(): void
    {
        $category = new Category([
            'id' => 'category-id',
            'deleted_at' => null,
        ]);

        $this->assertNull($category->deletedAt);
    }

    public function test_scalar_values_are_coerced(): void
    {
        $level = new InventoryLevel([
            'variant_id' => 'variant-id',
            'store_id' => 'store-id',
            'in_stock' => '5',
            'updated_at' => '2020-01-01T00:00:00.000Z',
        ]);

        $this->assertSame(5.0, $level->inStock);
        $this->assertSame('variant-id', $level->variantId);
    }

    public function test_booleans_are_coerced(): void
    {
        $item = new Item([
            'id' => 'item-id',
            'track_stock' => 1,
        ]);

        $this->assertTrue($item->trackStock);
    }
}
