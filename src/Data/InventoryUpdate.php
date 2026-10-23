<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Data;

final readonly class InventoryUpdate
{
    /**
     * @param array<int, array{variant_id: string, store_id: string, stock_after: float|int}> $inventoryLevels
     */
    public function __construct(public array $inventoryLevels) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'inventory_levels' => $this->inventoryLevels,
        ];
    }
}
