<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum ItemForm: string
{
    use HasValues;

    case Square = 'SQUARE';
    case Circle = 'CIRCLE';
    case Sun = 'SUN';
    case Octagon = 'OCTAGON';
}
