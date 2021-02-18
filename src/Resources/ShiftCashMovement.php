<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ShiftCashMovement
 *
 * @package Pashkevich\Loyverse\Resources
 */
class ShiftCashMovement extends Resource
{
    /**
     * The type of cash movement.
     *
     * @var string
     */
    public string $type;

    /**
     * The money amount. The value is always positive.
     *
     * @var float
     */
    public float $moneyAmount;

    /**
     * The description of the cash movement.
     *
     * @var string
     */
    public string $comment;

    /**
     * The employee id who made the cash movement.
     *
     * @var string
     */
    public string $employeeId;

    /**
     * The time when this cash movement was created.
     *
     * @var string
     */
    public string $createdAt;
}
