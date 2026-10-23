<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ItemComponent
 *
 * @package Pashkevich\Loyverse\Resources
 */
class ItemComponent extends Resource
{
    /**
     * The variant id of the component.
     *
     * @var string
     */
    public string $variantId;

    /**
     * The quantity of the component.
     *
     * @var float
     */
    public float $quantity;
}
