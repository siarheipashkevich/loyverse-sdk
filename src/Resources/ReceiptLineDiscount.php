<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

class ReceiptLineDiscount extends Resource
{
    /**
     * The discount id.
     */
    public string $id;

    /**
     * The discount type.
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
     * The money amount of this discount for the line item.
     */
    public float $moneyAmount;
}
