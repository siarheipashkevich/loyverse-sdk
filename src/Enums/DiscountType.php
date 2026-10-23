<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum DiscountType: string
{
    use HasValues;

    case FIXED_PERCENT = 'FIXED_PERCENT';
    case FIXED_AMOUNT = 'FIXED_AMOUNT';
    case VARIABLE_PERCENT = 'VARIABLE_PERCENT';
    case VARIABLE_AMOUNT = 'VARIABLE_AMOUNT';
    case DISCOUNT_BY_POINTS = 'DISCOUNT_BY_POINTS';
}
