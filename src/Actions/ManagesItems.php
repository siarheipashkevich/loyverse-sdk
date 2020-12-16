<?php

namespace Esupl\Loyverse\Actions;

use Esupl\Loyverse\Resources\Item;

/**
 * Trait ManagesItems
 *
 * @package Esupl\Loyverse\Actions
 */
trait ManagesItems
{
    /**
     * Get a list of items.
     *
     * @param array $payload
     * @return Item[]
     */
    public function items(array $payload = []): array
    {
        return $this->transformCollection($this->get('items')['items'], Item::class, $payload);
    }

    /**
     * Get a single item.
     *
     * @param string $itemId
     * @return Item
     */
    public function item(string $itemId): Item
    {
        return new Item($this->get("items/$itemId"));
    }
}
