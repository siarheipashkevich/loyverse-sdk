<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Data\CreateReceiptData;
use Pashkevich\Loyverse\Data\RefundReceiptData;
use Pashkevich\Loyverse\Resources\Receipt;

trait ManagesReceipts
{
    /**
     * Get a list of receipts.
     *
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public function receipts(array $parameters = []): array
    {
        return $this->getPage('receipts', $parameters, 'receipts', Receipt::class);
    }

    /**
     * Get a single receipt.
     */
    public function receipt(string $receiptNumber): Receipt
    {
        return $this->getResource("receipts/$receiptNumber", Receipt::class);
    }

    /**
     * Create a sales receipt.
     *
     * @param array<string, mixed>|CreateReceiptData $data
     */
    public function createReceipt(array|CreateReceiptData $data): Receipt
    {
        if ($data instanceof CreateReceiptData) {
            $data = $data->toArray();
        }

        return $this->resource($this->post('receipts', $data), Receipt::class);
    }

    /**
     * Create a refund receipt.
     *
     * @param array<string, mixed>|RefundReceiptData $data
     */
    public function createReceiptRefund(string $receiptNumber, array|RefundReceiptData $data): Receipt
    {
        if ($data instanceof RefundReceiptData) {
            $data = $data->toArray();
        }

        return $this->resource($this->post("receipts/$receiptNumber/refund", $data), Receipt::class);
    }
}
