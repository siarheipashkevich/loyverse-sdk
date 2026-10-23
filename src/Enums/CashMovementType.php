<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum CashMovementType: string
{
    use HasValues;

    case PAY_IN = 'PAY_IN';
    case PAY_OUT = 'PAY_OUT';
}
