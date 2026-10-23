<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ReceiptTotalDiscount
 */
class ReceiptTotalDiscount extends Resource
{
    /**
     * The discount id.
     */
    public string $id;

    /**
     * The type of the applied discount.
     */
    public string $type;

    /**
     * The discount name.
     */
    public string $name;

    /**
     * The percentage of the discount.
     */
    public ?float $percentage = null;

    /**
     * The total money amount of this discount for the receipt.
     */
    public float $moneyAmount;
}
