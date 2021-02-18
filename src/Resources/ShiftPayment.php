<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ShiftPayment
 *
 * @package Pashkevich\Loyverse\Resources
 */
class ShiftPayment extends Resource
{
    /**
     * The payment id.
     *
     * @var string
     */
    public string $paymentTypeId;

    /**
     * The total money amount for the payment type.
     *
     * @var float
     */
    public float $moneyAmount;
}
