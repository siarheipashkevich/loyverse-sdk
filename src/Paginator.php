<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Generator;
use IteratorAggregate;
use JsonSerializable;

/**
 * @implements IteratorAggregate<int, mixed>
 * @implements ArrayAccess<int, mixed>
 */
final class Paginator implements IteratorAggregate, Countable, ArrayAccess, JsonSerializable
{
    /**
     * @param array<int, mixed> $items
     */
    public function __construct(
        protected array $items,
        protected ?string $cursor = null,
        protected ?\Closure $nextPage = null,
    ) {}

    /**
     * @return array<int, mixed>
     */
    public function items(): array
    {
        return $this->items;
    }

    public function cursor(): ?string
    {
        return $this->cursor;
    }

    public function hasMorePages(): bool
    {
        return $this->cursor !== null;
    }

    public function nextPage(): ?self
    {
        if (! $this->hasMorePages() || $this->nextPage === null) {
            return null;
        }

        return ($this->nextPage)($this->cursor);
    }

    /**
     * @return Generator<int, mixed>
     */
    public function lazy(): Generator
    {
        $page = $this;

        while ($page !== null) {
            foreach ($page->items() as $item) {
                yield $item;
            }

            $page = $page->nextPage();
        }
    }

    /**
     * @return Generator<int, self>
     */
    public function lazyPages(): Generator
    {
        $page = $this;

        while ($page !== null) {
            yield $page;

            $page = $page->nextPage();
        }
    }

    /**
     * @return array<int, mixed>
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @return array<int, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->items;
    }

    /**
     * @return ArrayIterator<int, mixed>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }
}
