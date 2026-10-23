<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

class ShiftCashMovement extends Resource
{
    /**
     * The type of cash movement.
     */
    public string $type;

    /**
     * The money amount. The value is always positive.
     */
    public float $moneyAmount;

    /**
     * The description of the cash movement.
     */
    public string $comment;

    /**
     * The employee id who made the cash movement.
     */
    public string $employeeId;

    /**
     * The time when this cash movement was created.
     */
    public string $createdAt;
}
