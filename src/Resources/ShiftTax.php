<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ShiftTax
 *
 * @package Pashkevich\Loyverse\Resources
 */
class ShiftTax extends Resource
{
    /**
     * The tax id.
     *
     * @var string
     */
    public string $taxId;

    /**
     * The total money amount for the tax in the shift.
     *
     * @var float
     */
    public float $moneyAmount;
}
