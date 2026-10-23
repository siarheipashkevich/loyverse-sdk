<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ReceiptLineTax
 */
class ReceiptLineTax extends Resource
{
    /**
     * The money amount of this tax for the line item.
     */
    public float $moneyAmount;

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
}
