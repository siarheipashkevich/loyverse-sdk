<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\{Request, Response, Utils};
use Mockery;
use Mockery\MockInterface;
use Pashkevich\Loyverse\Exceptions\{ConnectionException, HttpTimeoutException, TlsException};
use Pashkevich\Loyverse\Loyverse;
use PHPUnit\Framework\TestCase;

class TransportTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @return Client&MockInterface
     */
    private function mockHttpClient(): Client
    {
        /** @var Client&MockInterface $client */
        $client = Mockery::mock(Client::class);

        return $client;
    }

    public function test_connection_exception_is_wrapped(): void
    {
        $loyverse = new Loyverse('123', $http = $this->mockHttpClient());

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 30,
        ])->andThrow(new ConnectException('Connection refused', new Request('GET', 'employees')));

        $this->expectException(ConnectionException::class);

        $loyverse->employees();
    }

    public function test_timeout_is_wrapped(): void
    {
        $loyverse = new Loyverse('123', $http = $this->mockHttpClient());

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 30,
        ])->andThrow(new ConnectException('cURL error 28: Operation timed out', new Request('GET', 'employees')));

        $this->expectException(HttpTimeoutException::class);

        $loyverse->employees();
    }

    public function test_tls_error_is_wrapped(): void
    {
        $loyverse = new Loyverse('123', $http = $this->mockHttpClient());

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 30,
        ])->andThrow(new ConnectException('SSL certificate problem', new Request('GET', 'employees')));

        $this->expectException(TlsException::class);

        $loyverse->employees();
    }

    public function test_custom_base_uri_is_used(): void
    {
        $loyverse = new Loyverse('123', $http = $this->mockHttpClient());
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

    public function test_custom_headers_and_connect_timeout_are_applied(): void
    {
        $loyverse = new Loyverse('123', $http = $this->mockHttpClient());
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

    public function test_set_timeout_is_passed_to_request(): void
    {
        $loyverse = new Loyverse('123', $http = $this->mockHttpClient());
        $loyverse->setTimeout(120);

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 120,
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(
            '{"employees": [], "cursor": null}'
        ));

        $loyverse->employees();

        $this->assertSame(120, $loyverse->getTimeout());
    }

    public function test_empty_base_uri_is_rejected(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Loyverse('123', $this->mockHttpClient())->setBaseUri(' ');
    }

    public function test_user_agent_is_set_on_the_client(): void
    {
        $loyverse = new Loyverse('123');

        $headers = $loyverse->guzzle->getConfig('headers');

        $this->assertStringStartsWith('loyverse-sdk/'.Loyverse::VERSION, $headers['User-Agent']);
    }

    public function test_fake_client_returns_queued_responses(): void
    {
        $loyverse = Loyverse::fake([
            new Response(200, [], '{"categories": [], "cursor": null}'),
        ]);

        $page = $loyverse->categories();

        $this->assertSame([], $page['categories']);
        $this->assertNull($page['cursor']);
    }
}
