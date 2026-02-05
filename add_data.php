<?php

require_once __DIR__ . '/vendor/autoload.php';
use Pashkevich\Loyverse\Loyverse;

$apiToken = 'a9be1042162e4466b3f47ea86ed2ca2a';
$loyverse = new Loyverse($apiToken);

echo "--- ADDING DATA ---\n";

try {
    $cat = $loyverse->createCategory(['name' => 'Cat ' . rand(100, 999)]);
    echo "CATEGORY_OK: " . $cat->id . "\n";
    
    $item = $loyverse->createItem([
        'item_name' => 'Item ' . rand(100, 999),
        'category_id' => $cat->id,
        'variants' => [['default_pricing_type' => 'FIXED', 'default_price' => 10.0]]
    ]);
    echo "ITEM_OK: " . $item->id . "\n";
    
    $cust = $loyverse->createCustomer(['name' => 'Cust ' . rand(100, 999)]);
    echo "CUSTOMER_OK: " . $cust->id . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "--- FINISHED ---\n";
