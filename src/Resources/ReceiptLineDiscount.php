<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ReceiptLineDiscount
 *
 * @package Pashkevich\Loyverse\Resources
 */
class ReceiptLineDiscount extends Resource
{
    /**
     * The discount id.
     *
     * @var string
     */
    public string $id;

    /**
     * The discount type.
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
     * The money amount of this discount for the line item.
     *
     * @var float
     */
    public float $moneyAmount;
}
