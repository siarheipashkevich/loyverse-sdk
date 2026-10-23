<?php

declare(strict_types=1);

use Pashkevich\Loyverse\Data\CreateReceiptData;

/** @var \Pashkevich\Loyverse\Loyverse $loyverse */
$loyverse = require __DIR__.'/bootstrap.php';

$storeId = getenv('STORE_ID');
$variantId = getenv('VARIANT_ID');
$paymentTypeId = getenv('PAYMENT_TYPE_ID');
$amount = getenv('AMOUNT');

if ($storeId === false || $variantId === false || $paymentTypeId === false || $amount === false) {
    fwrite(STDERR, "Set STORE_ID, VARIANT_ID, PAYMENT_TYPE_ID and AMOUNT.\n");
    exit(1);
}

$data = new CreateReceiptData(
    storeId: $storeId,
    lineItems: [[
        'variant_id' => $variantId,
        'quantity' => 1,
    ]],
    payments: [[
        'payment_type_id' => $paymentTypeId,
        'money_amount' => (float) $amount,
    ]],
);

$receipt = $loyverse->createReceipt($data);

echo 'Receipt: '.$receipt->receiptNumber.PHP_EOL;
