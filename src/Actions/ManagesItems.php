<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Data\CreateItemData;
use Pashkevich\Loyverse\Resources\Item;

trait ManagesItems
{
    /**
     * Get a list of items.
     *
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public function items(array $parameters = []): array
    {
        return $this->getPage('items', $parameters, 'items', Item::class);
    }

    /**
     * Get a single item.
     */
    public function item(string $itemId): Item
    {
        return $this->getResource("items/$itemId", Item::class);
    }

    /**
     * Upload a single item image.
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
     * @return array<string, mixed>
     */
    public function deleteItemImage(string $itemId): array
    {
        return $this->deleteResource("items/$itemId/image");
    }

    /**
     * Create or update a single item.
     *
     * @param array<string, mixed>|CreateItemData $data
     */
    public function createItem(array|CreateItemData $data): Item
    {
        if ($data instanceof CreateItemData) {
            $data = $data->toArray();
        }

        return $this->resource($this->post('items', $data), Item::class);
    }

    /**
     * Delete a single resource.
     *
     * @return array<string, mixed>
     */
    public function deleteItem(string $itemId): array
    {
        return $this->deleteResource("items/$itemId");
    }
}
