<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

class Discount extends Resource
{
    /**
     * The discount id.
     */
    public string $id;

    /**
     * The type of the discount.
     */
    public string $type;

    /**
     * The discount name.
     */
    public string $name;

    /**
     * The discount value in money representation (only for discounts with type FIXED_AMOUNT).
     */
    public float $discountAmount;

    /**
     * This is discount value in percentage (only for discounts with type FIXED_PERCENT).
     */
    public float $discountPercent;

    /**
     * The list of store ids where this discount is available.
     *
     * @var string[]
     */
    public array $stores;

    /**
     * If true, the password verification is necessary in order to apply this discount on POS.
     */
    public bool $restrictedAccess;

    /**
     * The time when this resource was created.
     */
    public string $createdAt;

    /**
     * The time when this resource was updated.
     */
    public string $updatedAt;

    /**
     * The time when this resource was deleted.
     */
    public ?string $deletedAt;

    /**
     * Update the given discount.
     *
     * @param array<string, mixed> $data
     */
    public function update(array $data): Discount
    {
        return $this->client()->createDiscount(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given discount.
     *
     * @return array<string, mixed>
     */
    public function delete(): array
    {
        return $this->client()->deleteDiscount($this->id);
    }
}
