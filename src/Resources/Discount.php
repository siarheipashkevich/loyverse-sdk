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
     * The list of store ids where this discount is available.
     *
     * @var array
     */
    public array $stores;

    /**
     * If true, the password verification is necessary in order to apply this discount on POS.
     *
     * @var bool
     */
    public bool $restrictedAccess;

    /**
     * The time when this resource was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The time when this resource was updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * The time when this resource was deleted.
     *
     * @var string|null
     */
    public ?string $deletedAt;

    /**
     * Update the given discount.
     *
     * @param array $data
     * @return Discount
     */
    public function update(array $data): Discount
    {
        return $this->loyverse->createDiscount(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given discount.
     *
     * @return array
     */
    public function delete(): array
    {
        return $this->loyverse->deleteDiscount($this->id);
    }
}
