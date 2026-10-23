<?php

declare(strict_types=1);

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

$receipt = $loyverse->createReceipt([
    'store_id' => $storeId,
    'line_items' => [[
        'variant_id' => $variantId,
        'quantity' => 1,
    ]],
    'payments' => [[
        'payment_type_id' => $paymentTypeId,
        'money_amount' => (float) $amount,
    ]],
]);

echo 'Receipt: '.$receipt->receiptNumber.PHP_EOL;
