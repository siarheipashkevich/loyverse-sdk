<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums;

use Pashkevich\Loyverse\Enums\Concerns\HasValues;

enum WebhookEvent: string
{
    use HasValues;

    case InventoryLevelsUpdate = 'inventory_levels.update';
    case ItemsUpdate = 'items.update';
    case CustomersUpdate = 'customers.update';
    case ReceiptsUpdate = 'receipts.update';
    case ShiftsCreate = 'shifts.create';
}
