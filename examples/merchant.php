<?php

declare(strict_types=1);

/** @var \Pashkevich\Loyverse\Loyverse $loyverse */
$loyverse = require __DIR__.'/bootstrap.php';

$merchant = $loyverse->merchant();

echo 'Merchant: '.$merchant->businessName.PHP_EOL;
echo 'Country: '.$merchant->country.PHP_EOL;
