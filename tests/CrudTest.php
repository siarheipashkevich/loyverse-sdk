<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use GuzzleHttp\Psr7\Response;
use Pashkevich\Loyverse\Loyverse;
use Pashkevich\Loyverse\Resources\{Category, Item, Variant};
use PHPUnit\Framework\TestCase;

class CrudTest extends TestCase
{
    use FakesHttpRequests;

    public function test_single_resource_is_returned(): void
    {
        $loyverse = $this->loyverse();

        $this->expectRequest('GET', 'categories/category-id', [], new Response(200, [], json_encode([
            'id' => 'category-id',
            'name' => 'Fruits',
            'color' => 'GREEN',
        ])));

        $category = $loyverse->category('category-id');

        $this->assertInstanceOf(Category::class, $category);
        $this->assertSame('Fruits', $category->name);
    }

    public function test_resource_is_created(): void
    {
        $loyverse = $this->loyverse();

        $this->expectRequest('POST', 'categories', ['json' => ['name' => 'Fruits']], new Response(200, [], json_encode([
            'id' => 'category-id',
            'name' => 'Fruits',
            'color' => 'GREEN',
        ])));

        $category = $loyverse->createCategory(['name' => 'Fruits']);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertSame('Fruits', $category->name);
    }

    public function test_resource_is_deleted(): void
    {
        $loyverse = $this->loyverse();

        $this->expectRequest('DELETE', 'categories/category-id', [], new Response(200, [], '{}'));

        $this->assertSame([], $loyverse->deleteCategory('category-id'));
    }

    public function test_item_image_is_uploaded(): void
    {
        $loyverse = $this->loyverse();

        $this->expectRequest('POST', 'items/item-id/image', ['body' => 'image-bytes'], new Response(201));

        $loyverse->uploadItemImage('item-id', 'image-bytes');

        $this->addToAssertionCount(1);
    }

    public function test_item_image_is_deleted(): void
    {
        $loyverse = $this->loyverse();

        $this->expectRequest('DELETE', 'items/item-id/image', [], new Response(200, [], '{}'));

        $this->assertSame([], $loyverse->deleteItemImage('item-id'));
    }

    public function test_variant_update_uses_variant_id(): void
    {
        $loyverse = $this->loyverse();

        $this->expectRequest('GET', 'variants/variant-id', [], new Response(200, [], '{"variant_id": "variant-id"}'));
        $this->expectRequest('POST', 'variants', [
            'json' => ['sku' => 'NEW-SKU', 'variant_id' => 'variant-id'],
        ], new Response(200, [], '{}'));

        $variant = $loyverse->variant('variant-id');

        $updated = $variant->update(['sku' => 'NEW-SKU']);

        $this->assertInstanceOf(Variant::class, $updated);
    }

    public function test_item_resource_delegates_image_methods(): void
    {
        $loyverse = $this->loyverse();

        $this->expectRequest('GET', 'items/item-id', [], new Response(200, [], '{"id": "item-id"}'));
        $this->expectRequest('POST', 'items/item-id/image', ['body' => 'image-bytes'], new Response(201));
        $this->expectRequest('DELETE', 'items/item-id/image', [], new Response(200, [], '{}'));

        $item = $loyverse->item('item-id');
        $item->uploadImage('image-bytes');

        $this->assertSame([], $item->deleteImage());
        $this->assertInstanceOf(Item::class, $item);
    }

    private function loyverse(): Loyverse
    {
        return new Loyverse('123', $this->fakeHttpClient());
    }
}
