<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Inventory;
use Pashkevich\Loyverse\Resources\InventoryLevel;

/**
 * Trait ManagesInventory
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesInventory
{
    /**
     * Inventory levels for item variants.
     *
     * @param array $parameters
     * @return array{inventory_levels: InventoryLevel[], cursor: string|null}
     */
    public function inventory(array $parameters = []): array
    {
        return $this->transformPage(
            $this->get('inventory', $parameters),
            'inventory_levels',
            InventoryLevel::class,
        );
    }

    /**
     * Batch update inventory levels for item variants.
     *
     * @param array $data
     * @return Inventory
     */
    public function updateInventory(array $data): Inventory
    {
        $item = $this->post('inventory', $data);

        return new Inventory($item, $this);
    }
}
