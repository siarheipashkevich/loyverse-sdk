<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Item;

/**
 * Trait ManagesItems
 *
 * @package Pashkevich\Loyverse\Actions
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
        return new Item($this->get("items/$itemId"), $this);
    }

    /**
     * Create or update a single item.
     *
     * @param array $data
     * @return Item
     */
    public function createItem(array $data): Item
    {
        $item = $this->post('items', $data);

        return new Item($item, $this);
    }

    /**
     * Delete a single resource.
     *
     * @param string $itemId
     * @return void
     */
    public function deleteItem(string $itemId): void
    {
        $this->delete("items/$itemId");
    }
}
