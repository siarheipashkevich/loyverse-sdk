<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

class ItemComponent extends Resource
{
    /**
     * The variant id of the component.
     */
    public string $variantId;

    /**
     * The quantity of the component.
     */
    public float $quantity;
}
