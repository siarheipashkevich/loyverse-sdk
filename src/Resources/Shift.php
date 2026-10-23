<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

use Pashkevich\Loyverse\Loyverse;

class Shift extends Resource
{
    /**
     * The shift id.
     */
    public string $id;

    /**
     * The store id associated with the shift.
     */
    public string $storeId;

    /**
     * The pos device id associated with the shift.
     */
    public string $posDeviceId;

    /**
     * The time when the shift was opened.
     */
    public string $openedAt;

    /**
     * The time when the shift was closed.
     */
    public ?string $closedAt = null;

    /**
     * The employee id who opened the shift.
     */
    public string $openedByEmployee;

    /**
     * The employee id who closed the shift.
     */
    public ?string $closedByEmployee = null;

    /**
     * The initial money amount at the start of the shift.
     */
    public float $startingCash;

    /**
     * The total money amount of cash payments for the shift.
     */
    public float $cashPayments;

    /**
     * The total money amount of cash refunds for the shift.
     */
    public float $cashRefunds;

    /**
     * The money amount added to the cash drawer.
     */
    public float $paidIn;

    /**
     * The money amount removed from the cash drawer. The value is always positive.
     */
    public float $paidOut;

    /**
     * The expected money amount at the end of the shift.
     */
    public float $expectedCash;

    /**
     * The actual money amount at the end of the shift.
     */
    public ?float $actualCash = null;

    /**
     * The gross money amount for the shift.
     * It calculates as sum of all payments before discounts but after taxes with type INCLUDED.
     */
    public float $grossSales;

    /**
     * The total money amount of refunds for the shift.
     */
    public float $refunds;

    /**
     * The total money amount of discounts for the shift. The value is always positive.
     */
    public float $discounts;

    /**
     * The net money amount for the shift. It calculates as gross sales minus discounts and refunds.
     */
    public float $netSales;

    /**
     * The total money amount of tips for the shift. Tips are available only for some payment types.
     */
    public float $tip;

    /**
     * The total money amount of surcharge for the shift. Surcharge is available only for some payment types.
     */
    public float $surcharge;

    /**
     * The list of taxes and it's totals for the shift.
     *
     * @var array<int, ShiftTax>
     */
    public array $taxes = [];

    /**
     * The list of total money amounts for every payment type in the shift.
     *
     * @var array<int, ShiftPayment>
     */
    public array $payments = [];

    /**
     * The list of shift cash movements.
     *
     * @var array<int, ShiftCashMovement>
     */
    public array $cashMovements = [];

    /**
     * Shift constructor.
     *
     * @param array<string, mixed> $attributes
     */
    public function __construct(array $attributes, ?Loyverse $loyverse = null)
    {
        parent::__construct($attributes, $loyverse);

        $this->taxes = $this->transformNested('taxes', ShiftTax::class);

        $this->payments = $this->transformNested('payments', ShiftPayment::class);

        $this->cashMovements = $this->transformNested('cash_movements', ShiftCashMovement::class);
    }
}
