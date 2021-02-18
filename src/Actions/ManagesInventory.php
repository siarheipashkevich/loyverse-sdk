<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Inventory;

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
     * @return Inventory
     */
    public function inventory(array $parameters = []): Inventory
    {
        return new Inventory($this->get('inventory', $parameters), $this);
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
