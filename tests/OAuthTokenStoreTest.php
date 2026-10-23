<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use GuzzleHttp\Psr7\Response;
use Pashkevich\Loyverse\{AccessToken, Loyverse, OAuth};
use Pashkevich\Loyverse\Auth\ArrayTokenStore;
use PHPUnit\Framework\TestCase;

class OAuthTokenStoreTest extends TestCase
{
    use FakesHttpRequests;

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
        $loyverse = new Loyverse('123', $this->fakeHttpClient());
        $token = $this->token('access-token');

        $loyverse->setAccessToken($token);

        $this->assertSame($token, $loyverse->getAccessToken());
    }

    public function test_expired_token_is_refreshed_before_request()
    {
        $client = $this->fakeHttpClient();
        $loyverse = new Loyverse('123', $client);
        $oauth = new OAuth($client);

        $loyverse->setAccessToken($this->token('old-token', time() - 100, 10));
        $loyverse->withOAuth($oauth, 'client-id', 'client-secret');

        $this->expectRequest('POST', OAuth::TOKEN_URL, [
            'form_params' => [
                'client_id' => 'client-id',
                'client_secret' => 'client-secret',
                'refresh_token' => 'refresh-token',
                'grant_type' => 'refresh_token',
            ],
        ], $this->tokenResponse('new-token'));

        $this->expectRequest('GET', 'employees', [], new Response(200, [], json_encode([
            'employees' => [],
            'cursor' => null,
        ])));

        $loyverse->employees();

        $this->assertSame('new-token', $loyverse->getAccessToken()?->accessToken);
    }

    public function test_token_is_refreshed_and_request_is_retried_after_401()
    {
        $client = $this->fakeHttpClient();
        $loyverse = new Loyverse('123', $client);
        $oauth = new OAuth($client);

        $loyverse->setAccessToken($this->token('old-token'));
        $loyverse->withOAuth($oauth, 'client-id', 'client-secret');

        $this->expectRequest('GET', 'employees', [], new Response(401, [], json_encode([
            'errors' => [['code' => 'UNAUTHORIZED']],
        ])));

        $this->expectRequest('POST', OAuth::TOKEN_URL, [
            'form_params' => [
                'client_id' => 'client-id',
                'client_secret' => 'client-secret',
                'refresh_token' => 'refresh-token',
                'grant_type' => 'refresh_token',
            ],
        ], $this->tokenResponse('new-token'));

        $this->expectRequest('GET', 'employees', [], new Response(200, [], json_encode([
            'employees' => [],
            'cursor' => null,
        ])));

        $loyverse->employees();

        $this->assertSame('new-token', $loyverse->getAccessToken()?->accessToken);
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

    private function tokenResponse(string $accessToken): Response
    {
        return new Response(200, [], json_encode([
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'expires_in' => 3600,
            'refresh_token' => 'refresh-token',
        ]));
    }
}
