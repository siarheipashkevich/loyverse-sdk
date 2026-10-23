<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum TaxType: string
{
    use HasValues;

    case INCLUDED = 'INCLUDED';
    case ADDED = 'ADDED';
}
