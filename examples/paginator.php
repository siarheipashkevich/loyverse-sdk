<?php

declare(strict_types=1);

/** @var \Pashkevich\Loyverse\Loyverse $loyverse */
$loyverse = require __DIR__.'/bootstrap.php';

$page = $loyverse->page('items', ['limit' => 250]);

echo 'Items on first page: '.count($page).PHP_EOL;

foreach ($page->lazy() as $item) {
    echo $item->itemName.PHP_EOL;
}
