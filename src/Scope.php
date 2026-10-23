<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse;

/**
 * Enum Scope
 */
enum Scope: string
{
    case CUSTOMERS_READ = 'CUSTOMERS_READ';
    case CUSTOMERS_WRITE = 'CUSTOMERS_WRITE';
    case EMPLOYEES_READ = 'EMPLOYEES_READ';
    case ITEMS_READ = 'ITEMS_READ';
    case INVENTORY_READ = 'INVENTORY_READ';
    case INVENTORY_WRITE = 'INVENTORY_WRITE';
    case ITEMS_WRITE = 'ITEMS_WRITE';
    case MERCHANT_READ = 'MERCHANT_READ';
    case PAYMENT_TYPES_READ = 'PAYMENT_TYPES_READ';
    case POS_DEVICES_READ = 'POS_DEVICES_READ';
    case POS_DEVICES_WRITE = 'POS_DEVICES_WRITE';
    case RECEIPTS_READ = 'RECEIPTS_READ';
    case RECEIPTS_WRITE = 'RECEIPTS_WRITE';
    case SHIFTS_READ = 'SHIFTS_READ';
    case STORES_READ = 'STORES_READ';
    case SUPPLIERS_READ = 'SUPPLIERS_READ';
    case SUPPLIERS_WRITE = 'SUPPLIERS_WRITE';
    case TAXES_READ = 'TAXES_READ';
    case TAXES_WRITE = 'TAXES_WRITE';
    case OPENID = 'OPENID';

    /**
     * Get all scope values.
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_map(static fn (self $scope): string => $scope->value, self::cases());
    }
}
