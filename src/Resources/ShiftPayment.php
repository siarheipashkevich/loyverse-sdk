<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

class ShiftPayment extends Resource
{
    /**
     * The payment id.
     */
    public string $paymentTypeId;

    /**
     * The total money amount for the payment type.
     */
    public float $moneyAmount;
}
