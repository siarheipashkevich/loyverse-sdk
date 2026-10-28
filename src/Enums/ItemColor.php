<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum ItemColor: string
{
    use HasValues;

    case Grey = 'GREY';
    case Red = 'RED';
    case Pink = 'PINK';
    case Orange = 'ORANGE';
    case Yellow = 'YELLOW';
    case Green = 'GREEN';
    case Blue = 'BLUE';
    case Purple = 'PURPLE';
}
