<?php

namespace Pashkevich\Loyverse\Resources;

use Pashkevich\Loyverse\Loyverse;

/**
 * Class Inventory
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Inventory extends Resource
{
    /**
     * The inventory levels.
     *
     * @var array
     */
    public array $inventoryLevels;

    /**
     * Inventory constructor.
     *
     * @param array $attributes
     * @param Loyverse|null $loyverse
     */
    public function __construct(array $attributes, Loyverse $loyverse = null)
    {
        parent::__construct($attributes, $loyverse);

        $this->inventoryLevels = $this->transformCollection($this->inventoryLevels ?: [], InventoryLevel::class);
    }
}
