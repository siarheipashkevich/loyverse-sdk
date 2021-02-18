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
     * @param array $parameters
     * @return Item[]
     */
    public function items(array $parameters = []): array
    {
        return $this->transformCollection($this->get('items', $parameters)['items'], Item::class);
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
     * @return array
     */
    public function deleteItem(string $itemId): array
    {
        return $this->delete("items/$itemId");
    }
}
