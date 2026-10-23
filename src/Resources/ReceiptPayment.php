<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

class ReceiptPayment extends Resource
{
    /**
     * The payment type id.
     */
    public string $paymentTypeId;

    /**
     * The name of the payment type.
     */
    public ?string $name = null;

    /**
     * The payment type.
     */
    public ?string $type = null;

    /**
     * The total money amount of this payment (including tips and surcharge).
     */
    public float $moneyAmount;

    /**
     * The time when this payment was created.
     */
    public ?string $paidAt = null;

    /**
     * The payment details for integrated payment types.
     *
     * @var array<string, mixed>|null
     */
    public ?array $paymentDetails = null;
}
