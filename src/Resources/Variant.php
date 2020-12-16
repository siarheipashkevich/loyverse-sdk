<?php

namespace Pashkevich\Loyverse\Resources;

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
     * The variant sku. It should be unique.
     *
     * @var string
     */
    public string $sku;

    /**
     * External reference id for the variant.
     *
     * @var string
     */
    public string $referenceVariantId;

    /**
     * The value of the first option for this variant.
     * Required if option1_name is set for the item this variant is attached to.
     *
     * @var string
     */
    public string $option1Value;

    /**
     * The value of the second option for this variant.
     * Required if option2_name is set for the item this variant is attached to.
     *
     * @var string
     */
    public string $option2Value;

    /**
     * The value of the third option for this variant.
     * Required if option3_name is set for the item this variant is attached to.
     *
     * @var string
     */
    public string $option3Value;

    /**
     * The variant barcode.
     *
     * @var string
     */
    public string $barcode;

    /**
     * The variant cost.
     *
     * @var float
     */
    public float $cost = 0;

    /**
     * The variant purchase cost.
     *
     * @var float
     */
    public float $purchaseCost = 0;

    /**
     * The default variant pricing type. If the value is VARIABLE than the price is specified at the time of a sale.
     * If there are several stores in the account than the price of the variant in each store is equal to this value
     * by default unless different value is specified in the stores array for a particular store.
     *
     * Enum: "FIXED", "VARIABLE".
     *
     * @var string
     */
    public string $defaultPricingType = 'VARIABLE';

    /**
     * The default variant price (only for pricing_type: FIXED) If there are several stores in the account than
     * the price of the variant in each store is equal to this value by default unless different value is specified
     * in the stores array for a particular store.
     *
     * @var float|null
     */
    public ?float $defaultPrice = null;

    /**
     * The list of values that are unique for each store.
     *
     * @var array
     */
    public array $stores = [];

    /**
     * The date/time the resource was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The date/time the resource was updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * The date/time the resource was deleted.
     *
     * @var string
     */
    public string $deletedAt;

    /**
     * Delete the given variant.
     *
     * @return void
     */
    public function delete(): void
    {
        $this->loyverse->deleteVariant($this->variantId);
    }
}
