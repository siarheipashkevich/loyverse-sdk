<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Receipt
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Receipt extends Resource
{
    /**
     * The internal identifier for the receipt. It is unique.
     *
     * @var string
     */
    public string $receiptNumber;

    /**
     * The receipt's note
     *
     * @var string|null
     */
    public ?string $note;

    /**
     * The type of the receipt.
     *
     * @var string
     */
    public string $receiptType;

    /**
     * The number of a different sales receipt that is associated with this refund (only for refund receipts).
     *
     * @var string|null
     */
    public ?string $refundFor;

    /**
     * The order name or number associated with this receipt.
     *
     * @var string|null
     */
    public ?string $order;

    /**
     * The autogenerated date and time when the receipt was created in Loyverse.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * By default, it matches the created_at value.
     *
     * @var string
     */
    public string $receiptDate;

    /**
     * The date and time when the receipt was updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * The time when this receipt was cancelled.
     *
     * @var string|null
     */
    public ?string $cancelledAt;

    /**
     * The name of the the source this receipt comes from.
     *
     * @var string
     */
    public string $source;

    /**
     * The total money amount paid by customer (or returned to customer in case of refund).
     *
     * @var float
     */
    public float $totalMoney;

    /**
     * The total amount of all taxes (VAT and sales tax) applied in the receipt.
     *
     * @var float
     */
    public float $totalTax;

    /**
     * The total amount of points added to customer's points balance.
     *
     * @var float
     */
    public float $pointsEarned;

    /**
     * The total amount of points deducted from customer's points balance (in case of refund).
     *
     * @var float
     */
    public float $pointsDeducted;

    /**
     * The customer's points balance after transaction.
     *
     * @var float
     */
    public float $pointsBalance;

    /**
     * The customer id associated with the receipt.
     *
     * @var string|null
     */
    public ?string $customerId;

    /**
     * The total amount of all discounts applied in the receipt (including discount by points).
     *
     * @var float
     */
    public float $totalDiscount;

    /**
     * The employee id associated with the receipt.
     *
     * @var string|null
     */
    public ?string $employeeId;

    /**
     * The store id where the receipt was paid.
     *
     * @var string
     */
    public string $storeId;

    /**
     * The POS id where the receipt was paid.
     *
     * @var string|null
     */
    public ?string $posDeviceId;

    /**
     * The dining option selected for the receipt.
     *
     * @var string|null
     */
    public ?string $diningOption;

    /**
     * The list of discounts and it's amounts applied to the receipt.
     *
     * @var array
     */
    public array $totalDiscounts;

    /**
     * An array of tax line objects.
     *
     * @var array
     */
    public array $totalTaxes;

    /**
     * The total tip money amount for the receipt.
     *
     * @var int
     */
    public int $tip;

    /**
     * The total surcharge money amount for the receipt.
     *
     * @var int
     */
    public int $surcharge;

    /**
     * The line items included in the receipt.
     *
     * @var array
     */
    public array $lineItems;

    /**
     * The list of receipt payments.
     *
     * @var array
     */
    public array $payments;

    /**
     * Create a refund for the given receipt.
     *
     * @param array $data
     * @return Receipt
     */
    public function refund(array $data): Receipt
    {
        return $this->loyverse->createReceiptRefund($this->receiptNumber, $data);
    }
}
