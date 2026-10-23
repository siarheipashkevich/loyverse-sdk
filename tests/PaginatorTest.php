<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use GuzzleHttp\Psr7\Response;
use Pashkevich\Loyverse\Loyverse;
use Pashkevich\Loyverse\Paginator;
use Pashkevich\Loyverse\Resources\Item;
use PHPUnit\Framework\TestCase;

class PaginatorTest extends TestCase
{
    use FakesHttpRequests;

    public function test_page_returns_paginator_and_fetches_next_page(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $this->expectRequest('GET', 'items', ['query' => ['limit' => '1']], new Response(200, [], json_encode([
            'items' => [['id' => '1', 'item_name' => 'One']],
            'cursor' => 'next',
        ])));

        $page = $loyverse->page('items', ['limit' => 1]);

        $this->assertInstanceOf(Paginator::class, $page);
        $this->assertCount(1, $page);
        $this->assertTrue($page->hasMorePages());
        $this->assertSame('next', $page->cursor());
        $this->assertInstanceOf(Item::class, $page[0]);

        $this->expectRequest('GET', 'items', [
            'query' => ['limit' => '1', 'cursor' => 'next'],
        ], new Response(200, [], json_encode([
            'items' => [['id' => '2', 'item_name' => 'Two']],
            'cursor' => null,
        ])));

        $next = $page->nextPage();

        $this->assertInstanceOf(Paginator::class, $next);
        $this->assertCount(1, $next);
        $this->assertFalse($next->hasMorePages());
        $this->assertSame('Two', $next[0]->itemName);
    }

    public function test_lazy_yields_items_across_pages(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $this->expectRequest('GET', 'items', [], new Response(200, [], json_encode([
            'items' => [['id' => '1', 'item_name' => 'One']],
            'cursor' => 'next',
        ])));

        $this->expectRequest('GET', 'items', ['query' => ['cursor' => 'next']], new Response(200, [], json_encode([
            'items' => [['id' => '2', 'item_name' => 'Two']],
            'cursor' => null,
        ])));

        $items = iterator_to_array($loyverse->page('items')->lazy());

        $this->assertCount(2, $items);
        $this->assertSame(['One', 'Two'], [$items[0]->itemName, $items[1]->itemName]);
    }

    public function test_lazy_pages_yields_each_page(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $this->expectRequest('GET', 'items', [], new Response(200, [], json_encode([
            'items' => [['id' => '1']],
            'cursor' => 'next',
        ])));

        $this->expectRequest('GET', 'items', ['query' => ['cursor' => 'next']], new Response(200, [], json_encode([
            'items' => [['id' => '2']],
            'cursor' => null,
        ])));

        $pages = iterator_to_array($loyverse->page('items')->lazyPages());

        $this->assertCount(2, $pages);
        $this->assertInstanceOf(Paginator::class, $pages[0]);
        $this->assertCount(1, $pages[1]);
    }

    public function test_paginator_serializes_items(): void
    {
        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $this->expectRequest('GET', 'items', [], new Response(200, [], json_encode([
            'items' => [['id' => '1', 'item_name' => 'One']],
            'cursor' => null,
        ])));

        $page = $loyverse->page('items');

        $decoded = json_decode(json_encode($page), true);

        $this->assertIsArray($decoded);
        $this->assertCount(1, $decoded);
        $this->assertSame('1', $decoded[0]['id']);
        $this->assertSame($page->items(), $page->toArray());
    }

    public function test_non_paginated_method_is_rejected(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $loyverse = new Loyverse('123', $this->fakeHttpClient());

        $loyverse->page('merchant');
    }
}
