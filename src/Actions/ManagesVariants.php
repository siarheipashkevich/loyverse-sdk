<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Variant;

/**
 * Trait ManagesVariants
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesVariants
{
    /**
     * Get a list of item variants.
     *
     * @param array $parameters
     * @return Variant[]
     */
    public function variants(array $parameters = []): array
    {
        return $this->transformCollection($this->get('variants', $parameters)['variants'], Variant::class);
    }

    /**
     * Get a single item variant.
     *
     * @param string $variantId
     * @return Variant
     */
    public function variant(string $variantId): Variant
    {
        return new Variant($this->get("variants/$variantId"), $this);
    }

    /**
     * Create or update a single variant.
     *
     * @param array $data
     * @return Variant
     */
    public function createVariant(array $data): Variant
    {
        $variant = $this->post("variants", $data);

        return new Variant($variant, $this);
    }

    /**
     * Delete a single resource.
     *
     * @param string $variantId
     * @return array
     */
    public function deleteVariant(string $variantId): array
    {
        return $this->delete("variants/$variantId");
    }
}
