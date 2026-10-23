<?php

namespace Pashkevich\Loyverse\Tests;

use Mockery;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\{Utils, Response};
use Pashkevich\Loyverse\{Loyverse, Exceptions};
use Pashkevich\Loyverse\Resources\{Inventory, Item, ModifierOption, Variant};

/**
 * Class LoyverseSDKTest
 *
 * @package Pashkevich\Loyverse\Tests
 */
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
}
