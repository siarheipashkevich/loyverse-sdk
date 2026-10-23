<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use GuzzleHttp\Psr7\Response;
use Pashkevich\Loyverse\Loyverse;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    use FakesHttpRequests;

    public function test_list_request(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $this->expectRequest('GET', 'categories', [], new Response(200, [], json_encode([
            'categories' => [],
            'cursor' => null,
        ])));

        $page = $loyverse->categories();

        $this->assertSame([], $page['categories']);
        $this->assertNull($page['cursor']);
    }

    public function test_query_parameters_are_sent(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $this->expectRequest('GET', 'items', ['query' => ['limit' => '1']], new Response(200, [], json_encode([
            'items' => [],
            'cursor' => null,
        ])));

        $loyverse->items(['limit' => 1]);

        $this->addToAssertionCount(1);
    }

    public function test_create_request(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $this->expectRequest('POST', 'categories', ['json' => ['name' => 'Fruits']], new Response(200, [], json_encode([
            'id' => 'category-id',
            'name' => 'Fruits',
        ])));

        $category = $loyverse->createCategory(['name' => 'Fruits']);

        $this->assertSame('Fruits', $category->name);
    }

    public function test_raw_image_request(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $this->expectRequest('POST', 'items/item-id/image', ['body' => 'image-bytes'], new Response(201));

        $loyverse->uploadItemImage('item-id', 'image-bytes');

        $this->addToAssertionCount(1);
    }

    public function test_delete_request(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $this->expectRequest('DELETE', 'categories/category-id', [], new Response(200, [], '{}'));

        $this->assertSame([], $loyverse->deleteCategory('category-id'));
    }
}
