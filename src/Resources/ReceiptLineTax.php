<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ReceiptLineTax
 *
 * @package Pashkevich\Loyverse\Resources
 */
class ReceiptLineTax extends Resource
{
    /**
     * The money amount of this tax for the line item.
     *
     * @var float
     */
    public float $moneyAmount;

    /**
     * The tax id.
     *
     * @var string
     */
    public string $id;

    /**
     * The tax type.
     *
     * @var string
     */
    public string $type;

    /**
     * The tax name.
     *
     * @var string
     */
    public string $name;

    /**
     * The tax rate.
     *
     * @var float
     */
    public float $rate;
}
