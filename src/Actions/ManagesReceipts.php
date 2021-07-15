<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Receipt;

/**
 * Trait ManagesReceipts
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesReceipts
{
    /**
     * Get a list of receipts.
     *
     * @param array $parameters
     * @return Receipt[]
     */
    public function receipts(array $parameters = []): array
    {
        return $this->transformCollection($this->get('receipts', $parameters)['receipts'], Receipt::class);
    }

    /**
     * Get a single receipt.
     *
     * @param string $receiptNumber
     * @return Receipt
     */
    public function receipt(string $receiptNumber): Receipt
    {
        return new Receipt($this->get("receipts/$receiptNumber"), $this);
    }

    /**
     * Create a sales receipt.
     *
     * @param array $data
     * @return Receipt
     */
//    public function createReceipt(array $data): Receipt
//    {
//        $item = $this->post('receipts', $data);
//
//        return new Receipt($item, $this);
//    }

    /**
     * Create a refund receipt.
     *
     * @param string $receiptNumber
     * @param array $data
     * @return Receipt
     */
    public function createReceiptRefund(string $receiptNumber, array $data): Receipt
    {
        return new Receipt($this->post("receipts/$receiptNumber/refund", $data), $this);
    }
}
