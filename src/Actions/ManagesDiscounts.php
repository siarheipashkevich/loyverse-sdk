<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Discount;

/**
 * Trait ManagesDiscounts
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesDiscounts
{
    /**
     * Get a list of discounts.
     *
     * @param array $data
     * @return Discount[]
     */
    public function discounts(array $data = []): array
    {
        return $this->transformCollection($this->get('discounts')['discounts'], Discount::class, $data);
    }

    /**
     * Get a single discount.
     *
     * @param string $discountId
     * @return Discount
     */
    public function discount(string $discountId): Discount
    {
        return new Discount($this->get("discounts/$discountId"), $this);
    }

    /**
     * Create or update a single discount.
     *
     * @param array $data
     * @return Discount
     */
    public function createDiscount(array $data): Discount
    {
        $item = $this->post('discounts', $data);

        return new Discount($item, $this);
    }

    /**
     * Delete a single resource.
     *
     * @param string $discountId
     * @return void
     */
    public function deleteDiscount(string $discountId): void
    {
        $this->delete("discounts/$discountId");
    }
}
