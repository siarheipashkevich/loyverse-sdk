<?php

declare(strict_types=1);

/** @var \Pashkevich\Loyverse\Loyverse $loyverse */
$loyverse = require __DIR__.'/bootstrap.php';

$page = $loyverse->inventory(['limit' => 250]);

foreach ($page['inventory_levels'] as $level) {
    echo $level->variantId.' @ '.$level->storeId.': '.$level->inStock.PHP_EOL;
}

$variantId = getenv('VARIANT_ID');
$storeId = getenv('STORE_ID');
$stockAfter = getenv('STOCK_AFTER');

if ($variantId !== false && $storeId !== false && $stockAfter !== false) {
    $inventory = $loyverse->updateInventory([
        'inventory_levels' => [[
            'variant_id' => $variantId,
            'store_id' => $storeId,
            'stock_after' => (float) $stockAfter,
        ]],
    ]);

    echo 'Updated stock: '.$inventory->inventoryLevels[0]->inStock.PHP_EOL;
}
