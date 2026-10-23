<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\{Request, Response, Utils};
use Mockery;
use Pashkevich\Loyverse\Exceptions\{ConnectionException, HttpTimeoutException, TlsException};
use Pashkevich\Loyverse\Loyverse;
use PHPUnit\Framework\TestCase;

class TransportTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_connection_exception_is_wrapped()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 30,
        ])->andThrow(new ConnectException('Connection refused', new Request('GET', 'employees')));

        $this->expectException(ConnectionException::class);

        $loyverse->employees();
    }

    public function test_timeout_is_wrapped()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 30,
        ])->andThrow(new ConnectException('cURL error 28: Operation timed out', new Request('GET', 'employees')));

        $this->expectException(HttpTimeoutException::class);

        $loyverse->employees();
    }

    public function test_tls_error_is_wrapped()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 30,
        ])->andThrow(new ConnectException('SSL certificate problem', new Request('GET', 'employees')));

        $this->expectException(TlsException::class);

        $loyverse->employees();
    }

    public function test_custom_base_uri_is_used()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));
        $loyverse->setBaseUri('https://example.test/v1.0');

        $http->shouldReceive('request')->once()->with('GET', 'https://example.test/v1.0/employees', [
            'timeout' => 30,
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(
            '{"employees": [], "cursor": null}'
        ));

        $loyverse->employees();

        $this->assertSame('https://example.test/v1.0/', $loyverse->getBaseUri());
    }

    public function test_custom_headers_and_connect_timeout_are_applied()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));
        $loyverse->setHeader('X-Test', 'yes')->setConnectTimeout(5);

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 30,
            'connect_timeout' => 5,
            'headers' => ['X-Test' => 'yes'],
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(
            '{"employees": [], "cursor": null}'
        ));

        $loyverse->employees();

        $this->assertSame(['X-Test' => 'yes'], $loyverse->getHeaders());
    }

    public function test_empty_base_uri_is_rejected()
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Loyverse('123', Mockery::mock(Client::class)))->setBaseUri(' ');
    }

    public function test_user_agent_is_set_on_the_client()
    {
        $loyverse = new Loyverse('123');

        $headers = $loyverse->guzzle->getConfig('headers');

        $this->assertStringStartsWith('loyverse-sdk/'.Loyverse::VERSION, $headers['User-Agent']);
    }

    public function test_fake_client_returns_queued_responses()
    {
        $loyverse = Loyverse::fake([
            new Response(200, [], '{"categories": [], "cursor": null}'),
        ]);

        $page = $loyverse->categories();

        $this->assertSame([], $page['categories']);
        $this->assertNull($page['cursor']);
    }
}
