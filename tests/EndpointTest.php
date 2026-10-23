<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use GuzzleHttp\Psr7\Response;
use Pashkevich\Loyverse\Loyverse;
use Pashkevich\Loyverse\Resources\Resource;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EndpointTest extends TestCase
{
    /**
     * @param array<int, mixed> $arguments
     */
    #[DataProvider('endpointProvider')]
    public function test_endpoint_method(string $method, array $arguments, string $body, bool $returnsVoid = false): void
    {
        $loyverse = Loyverse::fake([
            new Response(200, [], $body),
        ]);

        if ($returnsVoid) {
            $loyverse->{$method}(...$arguments);

            $this->addToAssertionCount(1);

            return;
        }

        $result = $loyverse->{$method}(...$arguments);

        $this->assertNotNull($result);

        if (! is_array($result)) {
            $this->assertInstanceOf(Resource::class, $result);
        }
    }

    /**
     * @return array<string, array{0: string, 1: array<int, mixed>, 2: string, 3?: bool}>
     */
    public static function endpointProvider(): array
    {
        return [
            'categories' => ['categories', [], '{"categories": [], "cursor": null}'],
            'category' => ['category', ['category-id'], '{}'],
            'createCategory' => ['createCategory', [[]], '{}'],
            'deleteCategory' => ['deleteCategory', ['category-id'], '{}'],
            'customers' => ['customers', [], '{"customers": [], "cursor": null}'],
            'customer' => ['customer', ['customer-id'], '{}'],
            'createCustomer' => ['createCustomer', [[]], '{}'],
            'deleteCustomer' => ['deleteCustomer', ['customer-id'], '{}'],
            'discounts' => ['discounts', [], '{"discounts": [], "cursor": null}'],
            'discount' => ['discount', ['discount-id'], '{}'],
            'createDiscount' => ['createDiscount', [[]], '{}'],
            'deleteDiscount' => ['deleteDiscount', ['discount-id'], '{}'],
            'employees' => ['employees', [], '{"employees": [], "cursor": null}'],
            'employee' => ['employee', ['employee-id'], '{}'],
            'inventory' => ['inventory', [], '{"inventory_levels": [], "cursor": null}'],
            'updateInventory' => ['updateInventory', [[]], '{}'],
            'items' => ['items', [], '{"items": [], "cursor": null}'],
            'item' => ['item', ['item-id'], '{}'],
            'createItem' => ['createItem', [[]], '{}'],
            'deleteItem' => ['deleteItem', ['item-id'], '{}'],
            'uploadItemImage' => ['uploadItemImage', ['item-id', 'image-bytes'], '', true],
            'deleteItemImage' => ['deleteItemImage', ['item-id'], '{}'],
            'modifiers' => ['modifiers', [], '{"modifiers": [], "cursor": null}'],
            'modifier' => ['modifier', ['modifier-id'], '{}'],
            'createModifier' => ['createModifier', [[]], '{}'],
            'deleteModifier' => ['deleteModifier', ['modifier-id'], '{}'],
            'paymentTypes' => ['paymentTypes', [], '{"payment_types": [], "cursor": null}'],
            'paymentType' => ['paymentType', ['payment-type-id'], '{}'],
            'posDevices' => ['posDevices', [], '{"pos_devices": [], "cursor": null}'],
            'posDevice' => ['posDevice', ['pos-device-id'], '{}'],
            'createPosDevice' => ['createPosDevice', [[]], '{}'],
            'deletePosDevice' => ['deletePosDevice', ['pos-device-id'], '{}'],
            'receipts' => ['receipts', [], '{"receipts": [], "cursor": null}'],
            'receipt' => ['receipt', ['1-1'], '{}'],
            'createReceipt' => ['createReceipt', [[]], '{}'],
            'createReceiptRefund' => ['createReceiptRefund', ['1-1', []], '{}'],
            'shifts' => ['shifts', [], '{"shifts": [], "cursor": null}'],
            'shift' => ['shift', ['shift-id'], '{}'],
            'stores' => ['stores', [], '{"stores": [], "cursor": null}'],
            'store' => ['store', ['store-id'], '{}'],
            'suppliers' => ['suppliers', [], '{"suppliers": [], "cursor": null}'],
            'supplier' => ['supplier', ['supplier-id'], '{}'],
            'createSupplier' => ['createSupplier', [[]], '{}'],
            'deleteSupplier' => ['deleteSupplier', ['supplier-id'], '{}'],
            'taxes' => ['taxes', [], '{"taxes": [], "cursor": null}'],
            'tax' => ['tax', ['tax-id'], '{}'],
            'createTax' => ['createTax', [[]], '{}'],
            'deleteTax' => ['deleteTax', ['tax-id'], '{}'],
            'variants' => ['variants', [], '{"variants": [], "cursor": null}'],
            'variant' => ['variant', ['variant-id'], '{}'],
            'createVariant' => ['createVariant', [[]], '{}'],
            'deleteVariant' => ['deleteVariant', ['variant-id'], '{}'],
            'webhooks' => ['webhooks', [], '{"webhooks": [], "cursor": null}'],
            'webhook' => ['webhook', ['webhook-id'], '{}'],
            'createWebhook' => ['createWebhook', [[]], '{}'],
            'deleteWebhook' => ['deleteWebhook', ['webhook-id'], '{}'],
            'merchant' => ['merchant', [], '{}'],
        ];
    }
}
