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
     * @return array{items: Item[], cursor: string|null}
     */
    public function items(array $parameters = []): array
    {
        return $this->transformPage($this->get('items', $parameters), 'items', Item::class);
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
     * Upload a single item image.
     *
     * @param string $itemId
     * @param string $contents
     * @param string $contentType
     * @return void
     */
    public function uploadItemImage(string $itemId, string $contents, string $contentType = 'image/png'): void
    {
        $this->postRaw("items/$itemId/image", $contents, [
            'Content-Type' => $contentType,
        ]);
    }

    /**
     * Delete a single item image.
     *
     * @param string $itemId
     * @return array
     */
    public function deleteItemImage(string $itemId): array
    {
        return $this->delete("items/$itemId/image");
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
