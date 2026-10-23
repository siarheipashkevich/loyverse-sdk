<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Data;

final readonly class RefundReceiptData
{
    /**
     * @param array<int, array<string, mixed>> $lineItems
     */
    public function __construct(
        public array $lineItems,
        public ?string $receiptDate = null,
        public ?string $source = null,
        public ?string $employeeId = null,
        public ?string $storeId = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'line_items' => $this->lineItems,
            'receipt_date' => $this->receiptDate,
            'source' => $this->source,
            'employee_id' => $this->employeeId,
            'store_id' => $this->storeId,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
