<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

class ReceiptTotalTax extends Resource
{
    /**
     * The tax id.
     */
    public string $id;

    /**
     * The tax type.
     */
    public string $type;

    /**
     * The tax name.
     */
    public string $name;

    /**
     * The tax rate.
     */
    public float $rate;

    /**
     * The total tax amount applied for the receipt.
     */
    public float $moneyAmount;
}
