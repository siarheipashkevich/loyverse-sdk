<?php

namespace Pashkevich\Loyverse\Resources;

use Pashkevich\Loyverse\Loyverse;

/**
 * Class Variant
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Variant extends Resource
{
    /**
     * The read only internal id of the variant.
     *
     * @var string
     */
    public string $variantId;

    /**
     * The item id this variant is attached to.
     *
     * @var string
     */
    public string $itemId;

    /**
     * The variant sku.
     *
     * @var string
     */
    public string $sku;

    /**
     * External reference id for the variant.
     *
     * @var string|null
     */
    public ?string $referenceVariantId;

    /**
     * The value of the first option for this variant.
     *
     * @var string|null
     */
    public ?string $option1Value;

    /**
     * The value of the second option for this variant.
     *
     * @var string|null
     */
    public ?string $option2Value;

    /**
     * The value of the third option for this variant.
     *
     * @var string|null
     */
    public ?string $option3Value;

    /**
     * The variant barcode.
     *
     * @var string|null
     */
    public ?string $barcode;

    /**
     * The variant cost.
     *
     * @var float
     */
    public float $cost;

    /**
     * The variant purchase cost.
     *
     * @var float|null
     */
    public ?float $purchaseCost;

    /**
     * The default variant pricing type.
     *
     * @var string
     */
    public string $defaultPricingType;

    /**
     * The default variant price (only for pricing_type: FIXED).
     *
     * @var float|null
     */
    public ?float $defaultPrice;

    /**
     * The list of values that are unique for each store.
     *
     * @var array
     */
    public array $stores;

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
     * Variant constructor.
     *
     * @param array $attributes
     * @param Loyverse|null $loyverse
     */
    public function __construct(array $attributes, Loyverse $loyverse = null)
    {
        parent::__construct($attributes, $loyverse);

        $this->stores = $this->transformCollection($this->stores ?: [], VariantStore::class);
    }

    /**
     * Update the given variant.
     *
     * @param array $data
     * @return Variant
     */
    public function update(array $data): Variant
    {
        return $this->loyverse->createVariant(array_merge($data, ['id' => $this->variantId]));
    }

    /**
     * Delete the given variant.
     *
     * @return array
     */
    public function delete(): array
    {
        return $this->loyverse->deleteVariant($this->variantId);
    }
}
