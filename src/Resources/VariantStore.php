<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

/**
 * Class VariantStore
 */
class VariantStore extends Resource
{
    /**
     * The id of the variant store.
     */
    public string $storeId;

    /**
     * The variant pricing type.
     */
    public string $pricingType;

    /**
     * The variant price in this store (only if pricing_type in this store is FIXED).
     */
    public ?float $price;

    /**
     * If true, variant is available for sale at this store.
     */
    public bool $availableForSale;

    /**
     * The variant optimal stock.
     */
    public ?float $optimalStock;

    /**
     * The low stock threshold for the variant.
     */
    public ?float $lowStock;
}
