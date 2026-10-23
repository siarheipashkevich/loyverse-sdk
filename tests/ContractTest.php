<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use Pashkevich\Loyverse\Loyverse;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ContractTest extends TestCase
{
    /**
     * All operations documented in the Loyverse OpenAPI specification and the
     * SDK method that implements each of them.
     *
     * @var array<string, string>
     */
    private const ENDPOINTS = [
        'GET /categories' => 'categories',
        'POST /categories' => 'createCategory',
        'GET /categories/{category_id}' => 'category',
        'DELETE /categories/{category_id}' => 'deleteCategory',
        'GET /customers' => 'customers',
        'POST /customers' => 'createCustomer',
        'GET /customers/{customer_id}' => 'customer',
        'DELETE /customers/{customer_id}' => 'deleteCustomer',
        'GET /discounts' => 'discounts',
        'POST /discounts' => 'createDiscount',
        'GET /discounts/{discount_id}' => 'discount',
        'DELETE /discounts/{discount_id}' => 'deleteDiscount',
        'GET /employees' => 'employees',
        'GET /employees/{employee_id}' => 'employee',
        'GET /inventory' => 'inventory',
        'POST /inventory' => 'updateInventory',
        'GET /items' => 'items',
        'POST /items' => 'createItem',
        'GET /items/{item_id}' => 'item',
        'DELETE /items/{item_id}' => 'deleteItem',
        'POST /items/{item_id}/image' => 'uploadItemImage',
        'DELETE /items/{item_id}/image' => 'deleteItemImage',
        'GET /merchant' => 'merchant',
        'GET /modifiers' => 'modifiers',
        'POST /modifiers' => 'createModifier',
        'GET /modifiers/{modifier_id}' => 'modifier',
        'DELETE /modifiers/{modifier_id}' => 'deleteModifier',
        'GET /payment_types' => 'paymentTypes',
        'GET /payment_types/{payment_type_id}' => 'paymentType',
        'GET /pos_devices' => 'posDevices',
        'POST /pos_devices' => 'createPosDevice',
        'GET /pos_devices/{pos_device_id}' => 'posDevice',
        'DELETE /pos_devices/{pos_device_id}' => 'deletePosDevice',
        'GET /receipts' => 'receipts',
        'POST /receipts' => 'createReceipt',
        'GET /receipts/{receipt_number}' => 'receipt',
        'POST /receipts/{receipt_number}/refund' => 'createReceiptRefund',
        'GET /shifts' => 'shifts',
        'GET /shifts/{shift_id}' => 'shift',
        'GET /stores' => 'stores',
        'GET /stores/{store_id}' => 'store',
        'GET /suppliers' => 'suppliers',
        'POST /suppliers' => 'createSupplier',
        'GET /suppliers/{supplier_id}' => 'supplier',
        'DELETE /suppliers/{supplier_id}' => 'deleteSupplier',
        'GET /taxes' => 'taxes',
        'POST /taxes' => 'createTax',
        'GET /taxes/{tax_id}' => 'tax',
        'DELETE /taxes/{tax_id}' => 'deleteTax',
        'GET /variants' => 'variants',
        'POST /variants' => 'createVariant',
        'GET /variants/{variant_id}' => 'variant',
        'DELETE /variants/{variant_id}' => 'deleteVariant',
        'GET /webhooks' => 'webhooks',
        'POST /webhooks' => 'createWebhook',
        'GET /webhooks/{webhook_id}' => 'webhook',
        'DELETE /webhooks/{webhook_id}' => 'deleteWebhook',
    ];

    public function test_all_documented_endpoints_are_covered()
    {
        $spec = json_decode(
            file_get_contents(__DIR__.'/Fixtures/openapi.json'),
            true,
            flags: JSON_THROW_ON_ERROR
        );

        $documented = [];

        foreach ($spec['paths'] as $path => $operations) {
            foreach (['get', 'post', 'put', 'delete'] as $method) {
                if (isset($operations[$method])) {
                    $documented[strtoupper($method).' '.rtrim($path, '/')] = true;
                }
            }
        }

        $expected = array_keys(self::ENDPOINTS);
        $documented = array_keys($documented);

        sort($documented);
        sort($expected);

        $this->assertSame($expected, $documented);
    }

    public function test_every_documented_endpoint_has_an_sdk_method()
    {
        $loyverse = new ReflectionClass(Loyverse::class);

        foreach (self::ENDPOINTS as $endpoint => $method) {
            $this->assertTrue(
                $loyverse->hasMethod($method),
                sprintf('SDK method %s for %s is missing.', $method, $endpoint)
            );
        }
    }
}
