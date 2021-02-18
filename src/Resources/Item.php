<?php

namespace Pashkevich\Loyverse\Resources;

use Pashkevich\Loyverse\Loyverse;

/**
 * Class Item
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Item extends Resource
{
    /**
     * The read only internal id of the item.
     *
     * @var string
     */
    public string $id;

    /**
     * The handle of the item.
     *
     * @var string
     */
    public string $handle;

    /**
     * The item name.
     *
     * @var string
     */
    public string $itemName;

    /**
     * External reference id for the item.
     *
     * @var string|null
     */
    public ?string $referenceId;

    /**
     * The category id of the item.
     *
     * @var string|null
     */
    public ?string $categoryId;

    /**
     * If true, the system tracks inventory for this item at all stores.
     *
     * @var bool
     */
    public bool $trackStock;

    /**
     * If true, a fractional quantity for this item can be specified at the time of a sale (for example 1.5).
     *
     * @var bool
     */
    public bool $soldByWeight;

    /**
     * If true, the item contains a specified quantity of other items.
     *
     * @var bool
     */
    public bool $isComposite;

    /**
     * If true, the system tracks stock not only for its components but also for this item.
     *
     * @var bool
     */
    public bool $useProduction;

    /**
     * The list of components for the item.
     *
     * @var array
     */
    public array $components;

    /**
     * The primary supplier id.
     *
     * @var string|null
     */
    public ?string $primarySupplierId;

    /**
     * The list of tax ids applied to this item.
     *
     * @var array
     */
    public array $taxIds;

    /**
     * The list of modifiers ids applied to this item.
     *
     * @var array
     */
    public array $modifiersIds;

    /**
     * The visual form of the item that is displayed on the POS.
     *
     * @var string
     */
    public string $form;

    /**
     * One of the predefined colors for the item that is displayed on the POS.
     *
     * @var string
     */
    public string $color;

    /**
     * The image url.
     *
     * @var string|null
     */
    public ?string $imageUrl;

    /**
     * The name of the first option (for example "Size").
     *
     * @var string|null
     */
    public ?string $option1Name;

    /**
     * The name of the first option (for example "Color").
     *
     * @var string|null
     */
    public ?string $option2Name;

    /**
     * The name of the first option (for example "Material").
     *
     * @var string|null
     */
    public ?string $option3Name;

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
     * The list of variants applied to this item.
     *
     * @var array
     */
    public array $variants;

    /**
     * Item constructor.
     *
     * @param array $attributes
     * @param Loyverse|null $loyverse
     */
    public function __construct(array $attributes, Loyverse $loyverse = null)
    {
        parent::__construct($attributes, $loyverse);

        $this->variants = $this->transformCollection($this->variants ?: [], Variant::class);
    }

    /**
     * Update the given item.
     *
     * @param array $data
     * @return Item
     */
    public function update(array $data): Item
    {
        return $this->loyverse->createItem(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given item.
     *
     * @return array
     */
    public function delete(): array
    {
        return $this->loyverse->deleteItem($this->id);
    }
}
