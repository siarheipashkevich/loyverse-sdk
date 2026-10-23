<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ReceiptPayment
 *
 * @package Pashkevich\Loyverse\Resources
 */
class ReceiptPayment extends Resource
{
    /**
     * The payment type id.
     *
     * @var string
     */
    public string $paymentTypeId;

    /**
     * The name of the payment type.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * The payment type.
     *
     * @var string|null
     */
    public ?string $type = null;

    /**
     * The total money amount of this payment (including tips and surcharge).
     *
     * @var float
     */
    public float $moneyAmount;

    /**
     * The time when this payment was created.
     *
     * @var string|null
     */
    public ?string $paidAt = null;

    /**
     * The payment details for integrated payment types.
     *
     * @var array|null
     */
    public ?array $paymentDetails = null;
}
