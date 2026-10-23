<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Discount;

/**
 * Trait ManagesDiscounts
 */
trait ManagesDiscounts
{
    /**
     * Get a list of discounts.
     *
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    public function discounts(array $parameters = []): array
    {
        return $this->getPage('discounts', $parameters, 'discounts', Discount::class);
    }

    /**
     * Get a single discount.
     */
    public function discount(string $discountId): Discount
    {
        return $this->getResource("discounts/$discountId", Discount::class);
    }

    /**
     * Create or update a single discount.
     *
     * @param  array<string, mixed>  $data
     */
    public function createDiscount(array $data): Discount
    {
        return $this->resource($this->post('discounts', $data), Discount::class);
    }

    /**
     * Delete a single resource.
     *
     * @return array<string, mixed>
     */
    public function deleteDiscount(string $discountId): array
    {
        return $this->deleteResource("discounts/$discountId");
    }
}
