<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Mockery;
use Pashkevich\Loyverse\Exceptions;
use Pashkevich\Loyverse\Loyverse;
use Pashkevich\Loyverse\Resources\Category;
use Pashkevich\Loyverse\Resources\Customer;
use Pashkevich\Loyverse\Resources\Discount;
use Pashkevich\Loyverse\Resources\Employee;
use Pashkevich\Loyverse\Resources\Inventory;
use Pashkevich\Loyverse\Resources\InventoryLevel;
use Pashkevich\Loyverse\Resources\Item;
use Pashkevich\Loyverse\Resources\ItemComponent;
use Pashkevich\Loyverse\Resources\Modifier;
use Pashkevich\Loyverse\Resources\ModifierOption;
use Pashkevich\Loyverse\Resources\PaymentType;
use Pashkevich\Loyverse\Resources\PosDevice;
use Pashkevich\Loyverse\Resources\Receipt;
use Pashkevich\Loyverse\Resources\ReceiptLineDiscount;
use Pashkevich\Loyverse\Resources\ReceiptLineItem;
use Pashkevich\Loyverse\Resources\ReceiptLineModifier;
use Pashkevich\Loyverse\Resources\ReceiptLineTax;
use Pashkevich\Loyverse\Resources\ReceiptPayment;
use Pashkevich\Loyverse\Resources\ReceiptTotalDiscount;
use Pashkevich\Loyverse\Resources\ReceiptTotalTax;
use Pashkevich\Loyverse\Resources\Shift;
use Pashkevich\Loyverse\Resources\Store;
use Pashkevich\Loyverse\Resources\Supplier;
use Pashkevich\Loyverse\Resources\Tax;
use Pashkevich\Loyverse\Resources\Variant;
use Pashkevich\Loyverse\Resources\Webhook;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LoyverseSDKTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_making_basic_requests()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"employees": [{"key": "value"}], "cursor": "value"}'));

        $response = $loyverse->employees();

        $this->assertCount(1, $response['employees']);
        $this->assertIsString($response['cursor']);
    }

    public function test_handling_unknown_exception()
    {
        $this->expectException(Exceptions\UnknownException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(500);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor());

        $loyverse->employees();
    }

    public function test_handling_internal_server_exception()
    {
        $this->expectException(Exceptions\InternalServerException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(500);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "INTERNAL_SERVER_ERROR"}]}'));

        $loyverse->employees();
    }

    public function test_handling_bad_request_exception()
    {
        $this->expectException(Exceptions\BadRequestException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(400);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "BAD_REQUEST"}]}'));

        $loyverse->employees();
    }

    public function test_handling_incorrect_value_type_exception()
    {
        $this->expectException(Exceptions\IncorrectValueTypeException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(400);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "INCORRECT_VALUE_TYPE"}]}'));

        $loyverse->employees();
    }

    public function test_handling_missing_required_parameter_exception()
    {
        $this->expectException(Exceptions\MissingRequiredParameterException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(400);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "MISSING_REQUIRED_PARAMETER"}]}'));

        $loyverse->employees();
    }

    public function test_handling_invalid_value_exception()
    {
        $this->expectException(Exceptions\InvalidValueException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(400);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "INVALID_VALUE"}]}'));

        $loyverse->employees();
    }

    public function test_handling_invalid_range_exception()
    {
        $this->expectException(Exceptions\InvalidRangeException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(400);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "INVALID_RANGE"}]}'));

        $loyverse->employees();
    }

    public function test_handling_invalid_cursor_exception()
    {
        $this->expectException(Exceptions\InvalidCursorException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(400);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "INVALID_CURSOR"}]}'));

        $loyverse->employees();
    }

    public function test_handling_conflicting_parameters_exception()
    {
        $this->expectException(Exceptions\ConflictingParametersException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(400);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "CONFLICTING_PARAMETERS"}]}'));

        $loyverse->employees();
    }

    public function test_handling_unauthorized_exception()
    {
        $this->expectException(Exceptions\UnauthorizedException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(401);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "UNAUTHORIZED"}]}'));

        $loyverse->employees();
    }

    public function test_handling_payment_required_exception()
    {
        $this->expectException(Exceptions\PaymentRequiredException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(402);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "PAYMENT_REQUIRED"}]}'));

        $loyverse->employees();
    }

    public function test_handling_forbidden_exception()
    {
        $this->expectException(Exceptions\ForbiddenException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(403);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "FORBIDDEN"}]}'));

        $loyverse->employees();
    }

    public function test_handling_not_found_exception()
    {
        $this->expectException(Exceptions\NotFoundException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(404);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "NOT_FOUND"}]}'));

        $loyverse->employees();
    }

    public function test_handling_unsupported_media_type_exception()
    {
        $this->expectException(Exceptions\UnsupportedMediaTypeException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(415);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "UNSUPPORTED_MEDIA_TYPE"}]}'));

        $loyverse->employees();
    }

    public function test_handling_rate_limited_exception()
    {
        $this->expectException(Exceptions\RateLimitedException::class);

        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', ['timeout' => 30])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(429);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "RATE_LIMITED"}]}'));
        $response->shouldReceive('getHeaderLine')->once()->with('Retry-After')->andReturn('120');

        $loyverse->employees();
    }

    public function test_uploads_item_image_with_raw_body()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'items/item-id/image', [
            'body' => 'image-bytes',
            'headers' => ['Content-Type' => 'image/png'],
            'timeout' => 30,
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(201);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(''));

        $loyverse->uploadItemImage('item-id', 'image-bytes');

        $this->addToAssertionCount(1);
    }

    public function test_deletes_item_image_and_decodes_empty_json_object()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('DELETE', 'items/item-id/image', [
            'timeout' => 30,
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor('{}'));

        $this->assertSame([], $loyverse->deleteItemImage('item-id'));
    }

    public function test_set_timeout_is_passed_to_request()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));
        $loyverse->setTimeout(120);

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 120,
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"employees": [], "cursor": "value"}'));

        $loyverse->employees();

        $this->assertSame(120, $loyverse->getTimeout());
    }

    public function test_item_resource_delegates_image_methods()
    {
        $loyverse = Mockery::mock(Loyverse::class);

        $item = new Item([
            'id' => 'item-id',
            'variants' => [],
        ], $loyverse);

        $loyverse->shouldReceive('uploadItemImage')->once()->with('item-id', 'image-bytes', 'image/png');
        $loyverse->shouldReceive('deleteItemImage')->once()->with('item-id')->andReturn([]);

        $item->uploadImage('image-bytes');

        $this->assertSame([], $item->deleteImage());
    }

    public function test_variant_update_uses_variant_id()
    {
        $loyverse = Mockery::mock(Loyverse::class);

        $variant = new Variant([
            'variant_id' => 'variant-id',
            'stores' => [],
        ], $loyverse);

        $loyverse->shouldReceive('createVariant')->once()->with([
            'sku' => 'NEW-SKU',
            'variant_id' => 'variant-id',
        ])->andReturn($variant);

        $this->assertSame($variant, $variant->update(['sku' => 'NEW-SKU']));
    }

    public function test_modifier_option_exposes_timestamps()
    {
        $option = new ModifierOption([
            'id' => 'option-id',
            'name' => 'Large',
            'price' => 1.5,
            'position' => 1,
            'created_at' => '2020-01-01T00:00:00.000Z',
            'updated_at' => '2020-01-02T00:00:00.000Z',
            'deleted_at' => null,
        ]);

        $this->assertSame('2020-01-01T00:00:00.000Z', $option->createdAt);
        $this->assertSame('2020-01-02T00:00:00.000Z', $option->updatedAt);
        $this->assertNull($option->deletedAt);
    }

    public function test_inventory_exposes_cursor()
    {
        $inventory = new Inventory([
            'inventory_levels' => [],
            'cursor' => 'next-cursor',
        ]);

        $this->assertSame('next-cursor', $inventory->cursor);
        $this->assertSame([], $inventory->inventoryLevels);
    }

    public function test_exception_exposes_error_context()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 30,
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->andReturn(404);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(
            '{"errors": [{"code": "NOT_FOUND", "details": "The resource was not found", "field": "category_id"}]}'
        ));

        try {
            $loyverse->employees();
            $this->fail('Expected NotFoundException to be thrown.');
        } catch (Exceptions\NotFoundException $exception) {
            $this->assertSame(404, $exception->getStatus());
            $this->assertSame('NOT_FOUND', $exception->getErrorCode());
            $this->assertSame('The resource was not found', $exception->getDetails());
            $this->assertSame('category_id', $exception->getField());
            $this->assertCount(1, $exception->getErrors());
        }
    }

    public function test_rate_limited_exception_exposes_retry_after()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 30,
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->andReturn(429);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(
            '{"errors": [{"code": "RATE_LIMITED"}]}'
        ));
        $response->shouldReceive('getHeaderLine')->once()->with('Retry-After')->andReturn('120');

        try {
            $loyverse->employees();
            $this->fail('Expected RateLimitedException to be thrown.');
        } catch (Exceptions\RateLimitedException $exception) {
            $this->assertSame(120, $exception->getRetryAfter());
        }
    }

    #[DataProvider('listMethodsProvider')]
    public function test_list_methods_return_pages_with_cursor(
        string $method,
        string $path,
        string $key,
        string $class
    ) {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', $path, [
            'timeout' => 30,
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(json_encode([
            $key => [['id' => 'resource-id']],
            'cursor' => 'next-cursor',
        ])));

        $page = $loyverse->{$method}();

        $this->assertArrayHasKey($key, $page);
        $this->assertArrayHasKey('cursor', $page);
        $this->assertSame('next-cursor', $page['cursor']);
        $this->assertCount(1, $page[$key]);
        $this->assertInstanceOf($class, $page[$key][0]);
    }

    public static function listMethodsProvider(): array
    {
        return [
            'categories' => ['categories', 'categories', 'categories', Category::class],
            'customers' => ['customers', 'customers', 'customers', Customer::class],
            'discounts' => ['discounts', 'discounts', 'discounts', Discount::class],
            'employees' => ['employees', 'employees', 'employees', Employee::class],
            'inventory' => ['inventory', 'inventory', 'inventory_levels', InventoryLevel::class],
            'items' => ['items', 'items', 'items', Item::class],
            'modifiers' => ['modifiers', 'modifiers', 'modifiers', Modifier::class],
            'payment types' => ['paymentTypes', 'payment_types', 'payment_types', PaymentType::class],
            'pos devices' => ['posDevices', 'pos_devices', 'pos_devices', PosDevice::class],
            'receipts' => ['receipts', 'receipts', 'receipts', Receipt::class],
            'shifts' => ['shifts', 'shifts', 'shifts', Shift::class],
            'stores' => ['stores', 'stores', 'stores', Store::class],
            'suppliers' => ['suppliers', 'suppliers', 'suppliers', Supplier::class],
            'taxes' => ['taxes', 'taxes', 'taxes', Tax::class],
            'variants' => ['variants', 'variants', 'variants', Variant::class],
            'webhooks' => ['webhooks', 'webhooks', 'webhooks', Webhook::class],
        ];
    }

    public function test_list_methods_return_null_cursor_when_missing()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'discounts', [
            'timeout' => 30,
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(
            '{"discounts": [{"id": "discount-id"}]}'
        ));

        $page = $loyverse->discounts();

        $this->assertNull($page['cursor']);
        $this->assertCount(1, $page['discounts']);
    }

    public function test_receipt_hydrates_nested_models()
    {
        $receipt = new Receipt([
            'receipt_number' => '1-1',
            'tip' => 1.5,
            'surcharge' => 2.5,
            'total_discounts' => [[
                'id' => 'discount-id',
                'type' => 'FIXED_PERCENT',
                'name' => 'Discount',
                'percentage' => 10.5,
                'money_amount' => 1.25,
            ]],
            'total_taxes' => [[
                'id' => 'tax-id',
                'type' => 'INCLUDED',
                'name' => 'Tax',
                'rate' => 5.5,
                'money_amount' => 0.75,
            ]],
            'line_items' => [[
                'id' => 'line-id',
                'item_id' => 'item-id',
                'variant_id' => 'variant-id',
                'item_name' => 'Item',
                'variant_name' => 'Large',
                'sku' => 'SKU',
                'quantity' => 2.0,
                'price' => 10.0,
                'gross_total_money' => 20.0,
                'total_money' => 19.0,
                'cost' => 5.0,
                'cost_total' => 10.0,
                'line_note' => null,
                'line_taxes' => [[
                    'money_amount' => 0.5,
                    'id' => 'line-tax-id',
                    'type' => 'INCLUDED',
                    'name' => 'Tax',
                    'rate' => 5.0,
                ]],
                'total_discount' => 1.0,
                'line_discounts' => [[
                    'id' => 'line-discount-id',
                    'type' => 'FIXED_AMOUNT',
                    'name' => 'Line discount',
                    'percentage' => null,
                    'money_amount' => 1.0,
                ]],
                'line_modifiers' => [[
                    'id' => 'modifier-id',
                    'modifier_option_id' => 'option-id',
                    'name' => 'Modifier',
                    'option' => 'Option',
                    'price' => 0.5,
                    'money_amount' => 1.0,
                ]],
            ]],
            'payments' => [[
                'payment_type_id' => 'payment-type-id',
                'name' => 'Cash',
                'type' => 'CASH',
                'money_amount' => 19.0,
                'paid_at' => '2020-01-01T00:00:00.000Z',
                'payment_details' => null,
            ]],
        ]);

        $this->assertInstanceOf(ReceiptTotalDiscount::class, $receipt->totalDiscounts[0]);
        $this->assertInstanceOf(ReceiptTotalTax::class, $receipt->totalTaxes[0]);
        $this->assertInstanceOf(ReceiptLineItem::class, $receipt->lineItems[0]);
        $this->assertInstanceOf(ReceiptLineTax::class, $receipt->lineItems[0]->lineTaxes[0]);
        $this->assertInstanceOf(ReceiptLineDiscount::class, $receipt->lineItems[0]->lineDiscounts[0]);
        $this->assertInstanceOf(ReceiptLineModifier::class, $receipt->lineItems[0]->lineModifiers[0]);
        $this->assertInstanceOf(ReceiptPayment::class, $receipt->payments[0]);
        $this->assertSame(1.5, $receipt->tip);
        $this->assertSame(2.5, $receipt->surcharge);
    }

    public function test_item_hydrates_components()
    {
        $item = new Item([
            'id' => 'item-id',
            'components' => [[
                'variant_id' => 'component-variant-id',
                'quantity' => 2.5,
            ]],
        ]);

        $this->assertInstanceOf(ItemComponent::class, $item->components[0]);
        $this->assertSame('component-variant-id', $item->components[0]->variantId);
        $this->assertSame(2.5, $item->components[0]->quantity);
    }

    public function test_single_resource_is_returned_from_get_resource()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'categories/category-id', [
            'timeout' => 30,
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(
            '{"id": "category-id", "name": "Fruits", "color": "GREEN"}'
        ));

        $category = $loyverse->category('category-id');

        $this->assertInstanceOf(Category::class, $category);
        $this->assertSame('Fruits', $category->name);
    }

    public function test_resource_is_created_from_post()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('POST', 'categories', [
            'json' => ['name' => 'Fruits'],
            'timeout' => 30,
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(
            '{"id": "category-id", "name": "Fruits", "color": "GREEN"}'
        ));

        $category = $loyverse->createCategory(['name' => 'Fruits']);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertSame('Fruits', $category->name);
    }

    public function test_delete_resource_returns_decoded_response()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('DELETE', 'categories/category-id', [
            'timeout' => 30,
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(
            '{"deleted_object_ids": ["category-id"]}'
        ));

        $this->assertSame(
            ['deleted_object_ids' => ['category-id']],
            $loyverse->deleteCategory('category-id')
        );
    }

    public function test_paginate_iterates_all_pages()
    {
        $loyverse = new Loyverse('123', Mockery::mock(Client::class));

        $calls = [];

        $pages = [
            ['items' => ['first', 'second'], 'cursor' => 'next'],
            ['items' => ['third'], 'cursor' => null],
        ];

        $resources = iterator_to_array($loyverse->paginate(
            function (array $parameters) use (&$calls, &$pages) {
                $calls[] = $parameters;

                return array_shift($pages);
            },
            ['limit' => 250]
        ));

        $this->assertSame(['first', 'second', 'third'], $resources);
        $this->assertSame([
            ['limit' => 250],
            ['limit' => 250, 'cursor' => 'next'],
        ], $calls);
    }

    public function test_paginate_stops_when_cursor_repeats()
    {
        $loyverse = new Loyverse('123', Mockery::mock(Client::class));

        $pages = [
            ['items' => ['first'], 'cursor' => 'same'],
            ['items' => ['second'], 'cursor' => 'same'],
        ];

        $resources = iterator_to_array($loyverse->paginate(
            function () use (&$pages) {
                return array_shift($pages);
            }
        ));

        $this->assertSame(['first', 'second'], $resources);
    }

    public function test_retry_on_rate_limit_uses_retry_after()
    {
        $loyverse = new Loyverse('123', Mockery::mock(Client::class));

        $attempts = 0;
        $delays = [];

        $result = $loyverse->retryOnRateLimit(
            function () use (&$attempts) {
                $attempts++;

                if ($attempts === 1) {
                    throw (new Exceptions\RateLimitedException)
                        ->setContext(429, [], 'RATE_LIMITED', '2');
                }

                return 'ok';
            },
            3,
            1,
            function (int $delay) use (&$delays) {
                $delays[] = $delay;
            }
        );

        $this->assertSame('ok', $result);
        $this->assertSame(2, $attempts);
        $this->assertSame([2], $delays);
    }

    public function test_retry_on_rate_limit_throws_after_max_attempts()
    {
        $this->expectException(Exceptions\RateLimitedException::class);

        $loyverse = new Loyverse('123', Mockery::mock(Client::class));

        $loyverse->retryOnRateLimit(
            function () {
                throw (new Exceptions\RateLimitedException)
                    ->setContext(429, [], 'RATE_LIMITED', '1');
            },
            2,
            1,
            function () {}
        );
    }
}
