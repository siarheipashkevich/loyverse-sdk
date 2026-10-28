<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse;

enum Scope: string
{
    case CustomersRead = 'CUSTOMERS_READ';
    case CustomersWrite = 'CUSTOMERS_WRITE';
    case EmployeesRead = 'EMPLOYEES_READ';
    case ItemsRead = 'ITEMS_READ';
    case InventoryRead = 'INVENTORY_READ';
    case InventoryWrite = 'INVENTORY_WRITE';
    case ItemsWrite = 'ITEMS_WRITE';
    case MerchantRead = 'MERCHANT_READ';
    case PaymentTypesRead = 'PAYMENT_TYPES_READ';
    case PosDevicesRead = 'POS_DEVICES_READ';
    case PosDevicesWrite = 'POS_DEVICES_WRITE';
    case ReceiptsRead = 'RECEIPTS_READ';
    case ReceiptsWrite = 'RECEIPTS_WRITE';
    case ShiftsRead = 'SHIFTS_READ';
    case StoresRead = 'STORES_READ';
    case SuppliersRead = 'SUPPLIERS_READ';
    case SuppliersWrite = 'SUPPLIERS_WRITE';
    case TaxesRead = 'TAXES_READ';
    case TaxesWrite = 'TAXES_WRITE';
    case OpenId = 'OPENID';

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
