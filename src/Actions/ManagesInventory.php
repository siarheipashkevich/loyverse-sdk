<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Inventory;
use Pashkevich\Loyverse\Resources\InventoryLevel;

trait ManagesInventory
{
    /**
     * Inventory levels for item variants.
     *
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public function inventory(array $parameters = []): array
    {
        return $this->getPage('inventory', $parameters, 'inventory_levels', InventoryLevel::class);
    }

    /**
     * Batch update inventory levels for item variants.
     *
     * @param array<string, mixed> $data
     */
    public function updateInventory(array $data): Inventory
    {
        return $this->resource($this->post('inventory', $data), Inventory::class);
    }
}
