<?php

declare(strict_types=1);

use Pashkevich\Loyverse\Loyverse;

require __DIR__.'/../vendor/autoload.php';

$token = getenv('LOYVERSE_API_TOKEN');

if ($token === false || $token === '') {
    fwrite(STDERR, "Set LOYVERSE_API_TOKEN before running examples.\n");
    exit(1);
}

return new Loyverse($token);
