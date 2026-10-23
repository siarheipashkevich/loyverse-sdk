<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ReceiptLineModifier
 */
class ReceiptLineModifier extends Resource
{
    /**
     * The modifier id.
     */
    public string $id;

    /**
     * The modifier option id applied to the line item.
     */
    public string $modifierOptionId;

    /**
     * The modifier name.
     */
    public string $name;

    /**
     * The name of the modifier option applied to the line item.
     */
    public string $option;

    /**
     * The base price of a single modifier option.
     */
    public float $price;

    /**
     * The total money amount of the modifier applied to the line item.
     */
    public float $moneyAmount;
}
