<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

use Pashkevich\Loyverse\Loyverse;

/**
 * Class Item
 */
class Item extends Resource
{
    /**
     * The read only internal id of the item.
     */
    public string $id;

    /**
     * The handle of the item.
     */
    public string $handle;

    /**
     * The item name.
     */
    public string $itemName;

    /**
     * The item description.
     */
    public string $description;

    /**
     * External reference id for the item.
     */
    public ?string $referenceId;

    /**
     * The category id of the item.
     */
    public ?string $categoryId;

    /**
     * If true, the system tracks inventory for this item at all stores.
     */
    public bool $trackStock;

    /**
     * If true, a fractional quantity for this item can be specified at the time of a sale (for example 1.5).
     */
    public bool $soldByWeight;

    /**
     * If true, the item contains a specified quantity of other items.
     */
    public bool $isComposite;

    /**
     * If true, the system tracks stock not only for its components but also for this item.
     */
    public bool $useProduction;

    /**
     * The list of components for the item.
     *
     * @var array<int, ItemComponent>
     */
    public array $components = [];

    /**
     * The primary supplier id.
     */
    public ?string $primarySupplierId;

    /**
     * The list of tax ids applied to this item.
     *
     * @var array<int, string>
     */
    public array $taxIds;

    /**
     * The list of modifiers ids applied to this item.
     *
     * @var array<int, string>
     */
    public array $modifiersIds;

    /**
     * The visual form of the item that is displayed on the POS.
     */
    public string $form;

    /**
     * One of the predefined colors for the item that is displayed on the POS.
     */
    public string $color;

    /**
     * The image url.
     */
    public ?string $imageUrl;

    /**
     * The name of the first option (for example "Size").
     */
    public ?string $option1Name;

    /**
     * The name of the first option (for example "Color").
     */
    public ?string $option2Name;

    /**
     * The name of the first option (for example "Material").
     */
    public ?string $option3Name;

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
     * The list of variants applied to this item.
     *
     * @var array<int, Variant>
     */
    public array $variants = [];

    /**
     * Item constructor.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes, ?Loyverse $loyverse = null)
    {
        parent::__construct($attributes, $loyverse);

        $this->components = $this->transformNested('components', ItemComponent::class);

        $this->variants = $this->transformNested('variants', Variant::class);
    }

    /**
     * Upload the image for the given item.
     */
    public function uploadImage(string $contents, string $contentType = 'image/png'): void
    {
        $this->client()->uploadItemImage($this->id, $contents, $contentType);
    }

    /**
     * Delete the image for the given item.
     *
     * @return array<string, mixed>
     */
    public function deleteImage(): array
    {
        return $this->client()->deleteItemImage($this->id);
    }

    /**
     * Update the given item.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(array $data): Item
    {
        return $this->client()->createItem(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given item.
     *
     * @return array<string, mixed>
     */
    public function delete(): array
    {
        return $this->client()->deleteItem($this->id);
    }
}
