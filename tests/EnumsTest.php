<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use Pashkevich\Loyverse\Enums\{
    CashMovementType,
    DiscountType,
    ItemColor,
    ItemForm,
    PaymentType,
    ReceiptType,
    TaxType,
    WebhookEvent,
    WebhookStatus
};
use Pashkevich\Loyverse\Scope;
use PHPUnit\Framework\TestCase;

class EnumsTest extends TestCase
{
    public function test_webhook_enums(): void
    {
        $this->assertSame([
            'inventory_levels.update',
            'items.update',
            'customers.update',
            'receipts.update',
            'shifts.create',
        ], WebhookEvent::values());

        $this->assertSame(['ENABLED', 'DISABLED'], WebhookStatus::values());
    }

    public function test_api_value_enums(): void
    {
        $this->assertSame(['SALE', 'REFUND'], ReceiptType::values());
        $this->assertSame(['INCLUDED', 'ADDED'], TaxType::values());
        $this->assertSame([
            'FIXED_PERCENT',
            'FIXED_AMOUNT',
            'VARIABLE_PERCENT',
            'VARIABLE_AMOUNT',
            'DISCOUNT_BY_POINTS',
        ], DiscountType::values());
        $this->assertSame(['PAY_IN', 'PAY_OUT'], CashMovementType::values());
        $this->assertSame(['SQUARE', 'CIRCLE', 'SUN', 'OCTAGON'], ItemForm::values());
        $this->assertSame([
            'GREY',
            'RED',
            'PINK',
            'ORANGE',
            'YELLOW',
            'GREEN',
            'BLUE',
            'PURPLE',
        ], ItemColor::values());
        $this->assertContains('CASH', PaymentType::values());
        $this->assertContains('OTHER', PaymentType::values());
    }

    public function test_enum_case_names_use_pascal_case(): void
    {
        $cases = [
            ...CashMovementType::cases(),
            ...DiscountType::cases(),
            ...ItemColor::cases(),
            ...ItemForm::cases(),
            ...PaymentType::cases(),
            ...ReceiptType::cases(),
            ...TaxType::cases(),
            ...WebhookEvent::cases(),
            ...WebhookStatus::cases(),
            ...Scope::cases(),
        ];

        foreach ($cases as $case) {
            $this->assertMatchesRegularExpression(
                '/^[A-Z][A-Za-z0-9]*$/',
                $case->name,
                sprintf('%s::%s is not PascalCase.', $case::class, $case->name),
            );
        }
    }
}
