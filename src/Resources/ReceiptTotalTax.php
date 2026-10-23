<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ReceiptTotalTax
 *
 * @package Pashkevich\Loyverse\Resources
 */
class ReceiptTotalTax extends Resource
{
    /**
     * The tax id.
     *
     * @var string
     */
    public string $id;

    /**
     * The tax type.
     *
     * @var string
     */
    public string $type;

    /**
     * The tax name.
     *
     * @var string
     */
    public string $name;

    /**
     * The tax rate.
     *
     * @var float
     */
    public float $rate;

    /**
     * The total tax amount applied for the receipt.
     *
     * @var float
     */
    public float $moneyAmount;
}
