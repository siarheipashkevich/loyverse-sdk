<?php

declare(strict_types=1);

/** @var \Pashkevich\Loyverse\Loyverse $loyverse */
$loyverse = require __DIR__.'/bootstrap.php';

$receiptNumber = getenv('RECEIPT_NUMBER');
$lineItemId = getenv('LINE_ITEM_ID');

if ($receiptNumber === false || $lineItemId === false) {
    fwrite(STDERR, "Set RECEIPT_NUMBER and LINE_ITEM_ID.\n");
    exit(1);
}

$receipt = $loyverse->createReceiptRefund($receiptNumber, [
    'line_items' => [[
        'id' => $lineItemId,
        'quantity' => 1,
    ]],
]);

echo 'Refund: '.$receipt->receiptNumber.PHP_EOL;
