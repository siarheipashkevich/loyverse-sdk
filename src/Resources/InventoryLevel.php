<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class InventoryLevel
 *
 * @package Pashkevich\Loyverse\Resources
 */
class InventoryLevel extends Resource
{
    /**
     * The item variant id.
     *
     * @var string
     */
    public string $variantId;

    /**
     * The store id.
     *
     * @var string
     */
    public string $storeId;

    /**
     * The current stock at the specified store.
     *
     * @var float
     */
    public float $inStock;

    /**
     * The time when specified stock was calculated.
     *
     * @var string
     */
    public string $updatedAt;
}
