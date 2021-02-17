<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Discount
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Discount extends Resource
{
    /**
     * The discount id.
     *
     * @var string
     */
    public string $id;

    /**
     * The type of the discount.
     *
     * Enum: "FIXED_PERCENT", "FIXED_AMOUNT", "VARIABLE_PERCENT", "VARIABLE_AMOUNT", "DISCOUNT_BY_POINTS".
     *
     * @var string
     */
    public string $type;

    /**
     * The discount name.
     *
     * @var string
     */
    public string $name;

    /**
     * The discount value in money representation (only for discounts with type FIXED_AMOUNT).
     *
     * @var float
     */
    public float $discountAmount;

    /**
     * This is discount value in percentage (only for discounts with type FIXED_PERCENT).
     *
     * @var float
     */
    public float $discountPercent;

    /**
     * The list of store ids where this discount is available. By default discount is available at all stores.
     *
     * @var array
     */
    public array $stores = [];

    /**
     * If true, the password verification is necessary in order to apply this discount on POS.
     *
     * @var bool
     */
    public bool $restrictedAccess = false;

    /**
     * The date/time the resource was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The date/time the resource was updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * The date/time the resource was deleted.
     *
     * @var string
     */
    public string $deletedAt;

    /**
     * Delete the given discount.
     *
     * @return void
     */
    public function delete(): void
    {
        $this->loyverse->deleteDiscount($this->id);
    }
}
