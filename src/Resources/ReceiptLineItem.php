<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

use Pashkevich\Loyverse\Loyverse;

class ReceiptLineItem extends Resource
{
    /**
     * The unique id that identifies this line item in the receipt.
     */
    public string $id;

    /**
     * The item id for this line item.
     */
    public string $itemId;

    /**
     * The variant id for this line item.
     */
    public string $variantId;

    /**
     * The item name.
     */
    public string $itemName;

    /**
     * The variant name (for example XL / Red).
     */
    public ?string $variantName = null;

    /**
     * The variant sku.
     */
    public ?string $sku = null;

    /**
     * The number of items that were purchased (or refunded in case of refund).
     */
    public float $quantity;

    /**
     * The price of one item.
     */
    public float $price;

    /**
     * The total money amount for this line item including modifiers.
     */
    public float $grossTotalMoney;

    /**
     * The total money amount for this line item after applying discounts and all taxes.
     */
    public float $totalMoney;

    /**
     * The cost of the single item at the moment of transaction.
     */
    public float $cost;

    /**
     * The total cost for this line item at the moment of transaction.
     */
    public float $costTotal;

    /**
     * The line item note.
     */
    public ?string $lineNote = null;

    /**
     * The list of taxes applied to the line item.
     *
     * @var array<int, ReceiptLineTax>
     */
    public array $lineTaxes = [];

    /**
     * The total discount amount applied to the line item.
     */
    public float $totalDiscount;

    /**
     * The list of discounts applied to the line item.
     *
     * @var array<int, ReceiptLineDiscount>
     */
    public array $lineDiscounts = [];

    /**
     * The list of modifiers applied to the line item.
     *
     * @var array<int, ReceiptLineModifier>
     */
    public array $lineModifiers = [];

    /**
     * ReceiptLineItem constructor.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes, ?Loyverse $loyverse = null)
    {
        parent::__construct($attributes, $loyverse);

        $this->lineTaxes = $this->transformNested('line_taxes', ReceiptLineTax::class);
        $this->lineDiscounts = $this->transformNested('line_discounts', ReceiptLineDiscount::class);
        $this->lineModifiers = $this->transformNested('line_modifiers', ReceiptLineModifier::class);
    }
}
