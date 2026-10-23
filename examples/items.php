<?php

declare(strict_types=1);

/** @var \Pashkevich\Loyverse\Loyverse $loyverse */
$loyverse = require __DIR__.'/bootstrap.php';

foreach ($loyverse->paginate([$loyverse, 'items'], ['limit' => 250]) as $item) {
    echo $item->itemName.' ('.$item->id.')'.PHP_EOL;
}
