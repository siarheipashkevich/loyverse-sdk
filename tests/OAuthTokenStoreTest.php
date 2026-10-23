<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\{Response, Utils};
use Mockery;
use Pashkevich\Loyverse\{AccessToken, Loyverse, OAuth};
use Pashkevich\Loyverse\Auth\ArrayTokenStore;
use PHPUnit\Framework\TestCase;

class OAuthTokenStoreTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_array_token_store()
    {
        $store = new ArrayTokenStore();
        $token = $this->token('access-token');

        $this->assertNull($store->get());

        $store->set($token);
        $this->assertSame($token, $store->get());

        $store->clear();
        $this->assertNull($store->get());
    }

    public function test_access_token_can_be_set_on_the_client()
    {
        $loyverse = new Loyverse('123', Mockery::mock(Client::class));
        $token = $this->token('access-token');

        $loyverse->setAccessToken($token);

        $this->assertSame($token, $loyverse->getAccessToken());
    }

    public function test_expired_token_is_refreshed_before_request()
    {
        $http = Mockery::mock(Client::class);

        $loyverse = new Loyverse('123', $http);

        $oldToken = $this->token('old-token', time() - 100, 10);
        $newToken = $this->token('new-token');

        $oauth = Mockery::mock(OAuth::class);
        $oauth->shouldReceive('refreshToken')
            ->once()
            ->with('client-id', 'client-secret', 'refresh-token')
            ->andReturn($newToken);

        $loyverse->setAccessToken($oldToken);
        $loyverse->withOAuth($oauth, 'client-id', 'client-secret');

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 30,
            'headers' => ['Authorization' => 'Bearer new-token'],
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(
            '{"employees": [], "cursor": null}'
        ));

        $loyverse->employees();

        $this->assertSame($newToken, $loyverse->getAccessToken());
    }

    public function test_token_is_refreshed_and_request_is_retried_after_401()
    {
        $http = Mockery::mock(Client::class);

        $loyverse = new Loyverse('123', $http);

        $oldToken = $this->token('old-token');
        $newToken = $this->token('new-token');

        $oauth = Mockery::mock(OAuth::class);
        $oauth->shouldReceive('refreshToken')
            ->once()
            ->with('client-id', 'client-secret', 'refresh-token')
            ->andReturn($newToken);

        $loyverse->setAccessToken($oldToken);
        $loyverse->withOAuth($oauth, 'client-id', 'client-secret');

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 30,
            'headers' => ['Authorization' => 'Bearer old-token'],
        ])->andReturn($unauthorized = Mockery::mock(Response::class));

        $unauthorized->shouldReceive('getStatusCode')->once()->andReturn(401);

        $http->shouldReceive('request')->once()->with('GET', 'employees', [
            'timeout' => 30,
            'headers' => ['Authorization' => 'Bearer new-token'],
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(
            '{"employees": [], "cursor": null}'
        ));

        $loyverse->employees();

        $this->assertSame($newToken, $loyverse->getAccessToken());
    }

    private function token(string $accessToken, ?int $createdAt = null, int $expiresIn = 3600): AccessToken
    {
        return new AccessToken(
            $accessToken,
            'Bearer',
            $expiresIn,
            'refresh-token',
            null,
            null,
            $createdAt ?? time(),
        );
    }
}
