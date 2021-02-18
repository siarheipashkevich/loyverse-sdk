<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class VariantStore
 *
 * @package Pashkevich\Loyverse\Resources
 */
class VariantStore extends Resource
{
    /**
     * The id of the variant store.
     *
     * @var string
     */
    public string $storeId;

    /**
     * The variant pricing type.
     *
     * @var string
     */
    public string $pricingType;

    /**
     * The variant price in this store (only if pricing_type in this store is FIXED).
     *
     * @var float|null
     */
    public ?float $price;

    /**
     * If true, variant is available for sale at this store.
     *
     * @var bool
     */
    public bool $availableForSale;

    /**
     * The variant optimal stock.
     *
     * @var float|null
     */
    public ?float $optimalStock;

    /**
     * The low stock threshold for the variant.
     *
     * @var float|null
     */
    public ?float $lowStock;
}
