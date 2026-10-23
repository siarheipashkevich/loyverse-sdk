<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum ItemColor: string
{
    use HasValues;

    case GREY = 'GREY';
    case RED = 'RED';
    case PINK = 'PINK';
    case ORANGE = 'ORANGE';
    case YELLOW = 'YELLOW';
    case GREEN = 'GREEN';
    case BLUE = 'BLUE';
    case PURPLE = 'PURPLE';
}
