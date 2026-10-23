<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Data;

final readonly class CreateItemData
{
    /**
     * @param array<int, array<string, mixed>> $variants
     * @param array<int, array{variant_id: string, quantity: float|int}> $components
     * @param array<int, string> $taxIds
     * @param array<int, string> $modifiersIds
     */
    public function __construct(
        public string $itemName,
        public array $variants = [],
        public ?string $description = null,
        public ?string $referenceId = null,
        public ?string $categoryId = null,
        public ?bool $trackStock = null,
        public ?bool $soldByWeight = null,
        public ?bool $isComposite = null,
        public ?bool $useProduction = null,
        public array $components = [],
        public ?string $primarySupplierId = null,
        public array $taxIds = [],
        public array $modifiersIds = [],
        public ?string $form = null,
        public ?string $color = null,
        public ?string $option1Name = null,
        public ?string $option2Name = null,
        public ?string $option3Name = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'item_name' => $this->itemName,
            'variants' => $this->variants,
            'description' => $this->description,
            'reference_id' => $this->referenceId,
            'category_id' => $this->categoryId,
            'track_stock' => $this->trackStock,
            'sold_by_weight' => $this->soldByWeight,
            'is_composite' => $this->isComposite,
            'use_production' => $this->useProduction,
            'components' => $this->components,
            'primary_supplier_id' => $this->primarySupplierId,
            'tax_ids' => $this->taxIds,
            'modifiers_ids' => $this->modifiersIds,
            'form' => $this->form,
            'color' => $this->color,
            'option1_name' => $this->option1Name,
            'option2_name' => $this->option2Name,
            'option3_name' => $this->option3Name,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
