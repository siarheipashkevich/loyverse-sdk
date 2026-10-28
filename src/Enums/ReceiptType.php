<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum ReceiptType: string
{
    use HasValues;

    case Sale = 'SALE';
    case Refund = 'REFUND';
}
