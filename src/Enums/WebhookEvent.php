<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum WebhookEvent: string
{
    use HasValues;

    case INVENTORY_LEVELS_UPDATE = 'inventory_levels.update';
    case ITEMS_UPDATE = 'items.update';
    case CUSTOMERS_UPDATE = 'customers.update';
    case RECEIPTS_UPDATE = 'receipts.update';
    case SHIFTS_CREATE = 'shifts.create';
}
