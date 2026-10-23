<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

use Pashkevich\Loyverse\Loyverse;

class Variant extends Resource
{
    /**
     * The read only internal id of the variant.
     */
    public string $variantId;

    /**
     * The item id this variant is attached to.
     */
    public string $itemId;

    /**
     * The variant sku.
     */
    public string $sku;

    /**
     * External reference id for the variant.
     */
    public ?string $referenceVariantId;

    /**
     * The value of the first option for this variant.
     */
    public ?string $option1Value;

    /**
     * The value of the second option for this variant.
     */
    public ?string $option2Value;

    /**
     * The value of the third option for this variant.
     */
    public ?string $option3Value;

    /**
     * The variant barcode.
     */
    public ?string $barcode;

    /**
     * The variant cost.
     */
    public float $cost;

    /**
     * The variant purchase cost.
     */
    public ?float $purchaseCost;

    /**
     * The default variant pricing type.
     */
    public string $defaultPricingType;

    /**
     * The default variant price (only for pricing_type: FIXED).
     */
    public ?float $defaultPrice;

    /**
     * The list of values that are unique for each store.
     *
     * @var array<int, VariantStore>
     */
    public array $stores = [];

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
     * Variant constructor.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes, ?Loyverse $loyverse = null)
    {
        parent::__construct($attributes, $loyverse);

        $this->stores = $this->transformNested('stores', VariantStore::class);
    }

    /**
     * Update the given variant.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(array $data): Variant
    {
        return $this->client()->createVariant(array_merge($data, ['variant_id' => $this->variantId]));
    }

    /**
     * Delete the given variant.
     *
     * @return array<string, mixed>
     */
    public function delete(): array
    {
        return $this->client()->deleteVariant($this->variantId);
    }
}
