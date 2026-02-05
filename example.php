<?php

require_once __DIR__ . '/vendor/autoload.php';

use Pashkevich\Loyverse\Loyverse;

/**
 * Example usage of the Loyverse SDK
 * 
 * Before running this example:
 * 1. Get your API token from https://loyverse.com
 * 2. Replace 'YOUR_API_TOKEN_HERE' with your actual token
 */

// Initialize the SDK with your API token
$apiToken = 'a9be1042162e4466b3f47ea86ed2ca2a'; // 'YOUR_API_TOKEN_HERE';
$loyverse = new Loyverse($apiToken);

// Example 1: Get all categories
try {
    echo "Fetching categories...\n";
    $categories = $loyverse->categories();
    echo "Found " . count($categories) . " categories\n\n";
    
    foreach ($categories as $category) {
        $color = $category->color ?? 'N/A';
        echo "- {$category->name} (ID: {$category->id}, Color: {$color})\n";
    }
} catch (Exception $e) {
    echo "Error fetching categories: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("-", 50) . "\n\n";

// Example 2: Get all items
try {
    echo "Fetching items...\n";
    $response = $loyverse->items();
    $items = $response['items'];
    echo "Found " . count($items) . " items\n\n";
    
    foreach ($items as $item) {
        $name = $item->itemName ?? 'Unnamed Item';
        echo "- {$name} (ID: {$item->id})\n";
    }
} catch (Exception $e) {
    echo "Error fetching items: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("-", 50) . "\n\n";

// Example 3: Get merchant information
try {
    echo "Fetching merchant info...\n";
    $merchant = $loyverse->merchant();
    echo "Merchant: {$merchant->businessName}\n";
    echo "Email: {$merchant->email}\n";
} catch (Exception $e) {
    echo "Error fetching merchant: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("-", 50) . "\n\n";

// Example 4: Create a new category (commented out to prevent accidental creation)
/*
try {
    echo "Creating a new category...\n";
    $newCategory = $loyverse->createCategory([
        'name' => 'Test Category',
        'color' => 'BLUE',
    ]);
    echo "Created category: {$newCategory->name} (ID: {$newCategory->id})\n";
} catch (Exception $e) {
    echo "Error creating category: " . $e->getMessage() . "\n";
}
*/

// Example 5: Get all stores
try {
    echo "Fetching stores...\n";
    $stores = $loyverse->stores();
    echo "Found " . count($stores) . " stores\n\n";
    
    foreach ($stores as $store) {
        echo "- {$store->name} (ID: {$store->id})\n";
        $address = $store->address ?? 'No address';
        echo "  Address: {$address}\n";
    }
} catch (Exception $e) {
    echo "Error fetching stores: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("-", 50) . "\n\n";
echo "Example completed!\n";
