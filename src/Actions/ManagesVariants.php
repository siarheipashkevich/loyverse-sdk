<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Variant;

trait ManagesVariants
{
    /**
     * Get a list of item variants.
     *
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public function variants(array $parameters = []): array
    {
        return $this->getPage('variants', $parameters, 'variants', Variant::class);
    }

    /**
     * Get a single item variant.
     */
    public function variant(string $variantId): Variant
    {
        return $this->getResource("variants/$variantId", Variant::class);
    }

    /**
     * Create or update a single variant.
     *
     * @param array<string, mixed> $data
     */
    public function createVariant(array $data): Variant
    {
        return $this->resource($this->post('variants', $data), Variant::class);
    }

    /**
     * Delete a single resource.
     *
     * @return array<string, mixed>
     */
    public function deleteVariant(string $variantId): array
    {
        return $this->deleteResource("variants/$variantId");
    }
}
