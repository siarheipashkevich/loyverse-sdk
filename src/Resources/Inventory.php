<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

use Pashkevich\Loyverse\Loyverse;

/**
 * Class Inventory
 */
class Inventory extends Resource
{
    /**
     * The inventory levels.
     *
     * @var array<int, InventoryLevel>
     */
    public array $inventoryLevels = [];

    /**
     * The cursor for the next page of inventory levels.
     */
    public ?string $cursor = null;

    /**
     * Inventory constructor.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes, ?Loyverse $loyverse = null)
    {
        parent::__construct($attributes, $loyverse);

        $this->inventoryLevels = $this->transformNested('inventory_levels', InventoryLevel::class);
    }
}
