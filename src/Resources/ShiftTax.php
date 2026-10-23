<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ShiftTax
 */
class ShiftTax extends Resource
{
    /**
     * The tax id.
     */
    public string $taxId;

    /**
     * The total money amount for the tax in the shift.
     */
    public float $moneyAmount;
}
