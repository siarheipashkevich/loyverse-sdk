<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ReceiptTotalDiscount
 *
 * @package Pashkevich\Loyverse\Resources
 */
class ReceiptTotalDiscount extends Resource
{
    /**
     * The discount id.
     *
     * @var string
     */
    public string $id;

    /**
     * The type of the applied discount.
     *
     * @var string
     */
    public string $type;

    /**
     * The discount name.
     *
     * @var string
     */
    public string $name;

    /**
     * The percentage of the discount.
     *
     * @var float|null
     */
    public ?float $percentage = null;

    /**
     * The total money amount of this discount for the receipt.
     *
     * @var float
     */
    public float $moneyAmount;
}
