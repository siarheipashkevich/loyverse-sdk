<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ReceiptLineModifier
 *
 * @package Pashkevich\Loyverse\Resources
 */
class ReceiptLineModifier extends Resource
{
    /**
     * The modifier id.
     *
     * @var string
     */
    public string $id;

    /**
     * The modifier option id applied to the line item.
     *
     * @var string
     */
    public string $modifierOptionId;

    /**
     * The modifier name.
     *
     * @var string
     */
    public string $name;

    /**
     * The name of the modifier option applied to the line item.
     *
     * @var string
     */
    public string $option;

    /**
     * The base price of a single modifier option.
     *
     * @var float
     */
    public float $price;

    /**
     * The total money amount of the modifier applied to the line item.
     *
     * @var float
     */
    public float $moneyAmount;
}
