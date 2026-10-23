<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Data;

final readonly class CreateReceiptData
{
    /**
     * @param array<int, array<string, mixed>> $lineItems
     * @param array<int, array<string, mixed>> $payments
     * @param array<int, array<string, mixed>> $totalDiscounts
     */
    public function __construct(
        public string $storeId,
        public array $lineItems = [],
        public array $payments = [],
        public array $totalDiscounts = [],
        public ?string $employeeId = null,
        public ?string $order = null,
        public ?string $customerId = null,
        public ?string $source = null,
        public ?string $receiptDate = null,
        public ?string $note = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'store_id' => $this->storeId,
            'line_items' => $this->lineItems,
            'payments' => $this->payments,
            'total_discounts' => $this->totalDiscounts,
            'employee_id' => $this->employeeId,
            'order' => $this->order,
            'customer_id' => $this->customerId,
            'source' => $this->source,
            'receipt_date' => $this->receiptDate,
            'note' => $this->note,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
