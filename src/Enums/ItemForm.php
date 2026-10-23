<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum ItemForm: string
{
    use HasValues;

    case SQUARE = 'SQUARE';
    case CIRCLE = 'CIRCLE';
    case SUN = 'SUN';
    case OCTAGON = 'OCTAGON';
}
