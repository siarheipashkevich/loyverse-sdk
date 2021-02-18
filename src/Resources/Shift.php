<?php

namespace Pashkevich\Loyverse\Resources;

use Pashkevich\Loyverse\Loyverse;

/**
 * Class Shift
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Shift extends Resource
{
    /**
     * The shift id.
     *
     * @var string
     */
    public string $id;

    /**
     * The store id associated with the shift.
     *
     * @var string
     */
    public string $storeId;

    /**
     * The pos device id associated with the shift.
     *
     * @var string
     */
    public string $posDeviceId;

    /**
     * The time when the shift was opened.
     *
     * @var string
     */
    public string $openedAt;

    /**
     * The time when the shift was closed.
     *
     * @var string
     */
    public string $closedAt;

    /**
     * The employee id who opened the shift.
     *
     * @var string
     */
    public string $openedByEmployee;

    /**
     * The employee id who closed the shift.
     *
     * @var string
     */
    public string $closedByEmployee;

    /**
     * The initial money amount at the start of the shift.
     *
     * @var float
     */
    public float $startingCash;

    /**
     * The total money amount of cash payments for the shift.
     *
     * @var float
     */
    public float $cashPayments;

    /**
     * The total money amount of cash refunds for the shift.
     *
     * @var float
     */
    public float $cashRefunds;

    /**
     * The money amount added to the cash drawer.
     *
     * @var float
     */
    public float $paidIn;

    /**
     * The money amount removed from the cash drawer. The value is always positive.
     *
     * @var float
     */
    public float $paidOut;

    /**
     * The expected money amount at the end of the shift.
     *
     * @var float
     */
    public float $expectedCash;

    /**
     * The actual money amount at the end of the shift.
     *
     * @var float
     */
    public float $actualCash;

    /**
     * The gross money amount for the shift.
     * It calculates as sum of all payments before discounts but after taxes with type INCLUDED.
     *
     * @var float
     */
    public float $grossSales;

    /**
     * The total money amount of refunds for the shift.
     *
     * @var float
     */
    public float $refunds;

    /**
     * The total money amount of discounts for the shift. The value is always positive.
     *
     * @var float
     */
    public float $discounts;

    /**
     * The net money amount for the shift. It calculates as gross sales minus discounts and refunds.
     *
     * @var float
     */
    public float $netSales;

    /**
     * The total money amount of tips for the shift. Tips are available only for some payment types.
     *
     * @var float
     */
    public float $tip;

    /**
     * The total money amount of surcharge for the shift. Surcharge is available only for some payment types.
     *
     * @var float
     */
    public float $surcharge;

    /**
     * The list of taxes and it's totals for the shift.
     *
     * @var array
     */
    public array $taxes;

    /**
     * The list of total money amounts for every payment type in the shift.
     *
     * @var array
     */
    public array $payments;

    /**
     * The list of shift cash movements.
     *
     * @var array
     */
    public array $cashMovements;

    /**
     * Shift constructor.
     *
     * @param array $attributes
     * @param Loyverse|null $loyverse
     */
    public function __construct(array $attributes, Loyverse $loyverse = null)
    {
        parent::__construct($attributes, $loyverse);

        $this->taxes = $this->transformCollection($this->taxes ?: [], ShiftTax::class);

        $this->payments = $this->transformCollection($this->payments ?: [], ShiftPayment::class);

        $this->cashMovements = $this->transformCollection($this->cashMovements ?: [], ShiftCashMovement::class);
    }
}
