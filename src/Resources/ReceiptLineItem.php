<?php

namespace Pashkevich\Loyverse\Resources;

use Pashkevich\Loyverse\Loyverse;

/**
 * Class ReceiptLineItem
 *
 * @package Pashkevich\Loyverse\Resources
 */
class ReceiptLineItem extends Resource
{
    /**
     * The unique id that identifies this line item in the receipt.
     *
     * @var string
     */
    public string $id;

    /**
     * The item id for this line item.
     *
     * @var string
     */
    public string $itemId;

    /**
     * The variant id for this line item.
     *
     * @var string
     */
    public string $variantId;

    /**
     * The item name.
     *
     * @var string
     */
    public string $itemName;

    /**
     * The variant name (for example XL / Red).
     *
     * @var string|null
     */
    public ?string $variantName = null;

    /**
     * The variant sku.
     *
     * @var string|null
     */
    public ?string $sku = null;

    /**
     * The number of items that were purchased (or refunded in case of refund).
     *
     * @var float
     */
    public float $quantity;

    /**
     * The price of one item.
     *
     * @var float
     */
    public float $price;

    /**
     * The total money amount for this line item including modifiers.
     *
     * @var float
     */
    public float $grossTotalMoney;

    /**
     * The total money amount for this line item after applying discounts and all taxes.
     *
     * @var float
     */
    public float $totalMoney;

    /**
     * The cost of the single item at the moment of transaction.
     *
     * @var float
     */
    public float $cost;

    /**
     * The total cost for this line item at the moment of transaction.
     *
     * @var float
     */
    public float $costTotal;

    /**
     * The line item note.
     *
     * @var string|null
     */
    public ?string $lineNote = null;

    /**
     * The list of taxes applied to the line item.
     *
     * @var array
     */
    public array $lineTaxes = [];

    /**
     * The total discount amount applied to the line item.
     *
     * @var float
     */
    public float $totalDiscount;

    /**
     * The list of discounts applied to the line item.
     *
     * @var array
     */
    public array $lineDiscounts = [];

    /**
     * The list of modifiers applied to the line item.
     *
     * @var array
     */
    public array $lineModifiers = [];

    /**
     * ReceiptLineItem constructor.
     *
     * @param array $attributes
     * @param Loyverse|null $loyverse
     */
    public function __construct(array $attributes, ?Loyverse $loyverse = null)
    {
        parent::__construct($attributes, $loyverse);

        $this->lineTaxes = $this->transformCollection($this->lineTaxes ?: [], ReceiptLineTax::class);
        $this->lineDiscounts = $this->transformCollection($this->lineDiscounts ?: [], ReceiptLineDiscount::class);
        $this->lineModifiers = $this->transformCollection($this->lineModifiers ?: [], ReceiptLineModifier::class);
    }
}
