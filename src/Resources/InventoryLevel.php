<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

/**
 * Class InventoryLevel
 */
class InventoryLevel extends Resource
{
    /**
     * The item variant id.
     */
    public string $variantId;

    /**
     * The store id.
     */
    public string $storeId;

    /**
     * The current stock at the specified store.
     */
    public float $inStock;

    /**
     * The time when specified stock was calculated.
     */
    public string $updatedAt;
}
