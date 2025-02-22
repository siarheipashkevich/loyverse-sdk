<?php

namespace Pashkevich\Loyverse\Tests;

use Mockery;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\{Utils, Response};
use Pashkevich\Loyverse\{Loyverse, Exceptions};

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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
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

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->andReturn(429);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn(Utils::streamFor('{"errors": [{"code": "RATE_LIMITED"}]}'));

        $loyverse->employees();
    }
}
