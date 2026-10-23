<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use Pashkevich\Loyverse\Loyverse;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    public function test_paginate_iterates_all_pages()
    {
        $loyverse = Loyverse::fake();

        $calls = [];

        $pages = [
            ['items' => ['first', 'second'], 'cursor' => 'next'],
            ['items' => ['third'], 'cursor' => null],
        ];

        $resources = iterator_to_array($loyverse->paginate(
            function (array $parameters) use (&$calls, &$pages) {
                $calls[] = $parameters;

                return array_shift($pages);
            },
            ['limit' => 250]
        ));

        $this->assertSame(['first', 'second', 'third'], $resources);
        $this->assertSame([
            ['limit' => 250],
            ['limit' => 250, 'cursor' => 'next'],
        ], $calls);
    }

    public function test_paginate_stops_when_cursor_repeats()
    {
        $loyverse = Loyverse::fake();

        $pages = [
            ['items' => ['first'], 'cursor' => 'same'],
            ['items' => ['second'], 'cursor' => 'same'],
        ];

        $resources = iterator_to_array($loyverse->paginate(
            function () use (&$pages) {
                return array_shift($pages);
            }
        ));

        $this->assertSame(['first', 'second'], $resources);
    }
}
