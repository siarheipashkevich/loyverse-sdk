<?php

namespace Esupl\Loyverse\Actions;

use Esupl\Loyverse\Resources\Receipt;

/**
 * Trait ManagesReceipts
 *
 * @package Esupl\Loyverse\Actions
 */
trait ManagesReceipts
{
    /**
     * Get a list of receipts.
     *
     * @param array $payload
     * @return Receipt[]
     */
    public function receipts(array $payload = []): array
    {
        return $this->transformCollection($this->get('receipts')['receipts'], Receipt::class, $payload);
    }

    /**
     * Get a single receipt.
     *
     * @param string $receiptId
     * @return Receipt
     */
    public function receipt(string $receiptId): Receipt
    {
        return new Receipt($this->get("receipts/$receiptId"));
    }
}
