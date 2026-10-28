<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum DiscountType: string
{
    use HasValues;

    case FixedPercent = 'FIXED_PERCENT';
    case FixedAmount = 'FIXED_AMOUNT';
    case VariablePercent = 'VARIABLE_PERCENT';
    case VariableAmount = 'VARIABLE_AMOUNT';
    case DiscountByPoints = 'DISCOUNT_BY_POINTS';
}
