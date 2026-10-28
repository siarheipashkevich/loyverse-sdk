<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum CashMovementType: string
{
    use HasValues;

    case PayIn = 'PAY_IN';
    case PayOut = 'PAY_OUT';
}
