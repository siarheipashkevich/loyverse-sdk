<?php

namespace Pashkevich\Loyverse\Tests;

use Mockery;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\{Utils, Response};
use Pashkevich\Loyverse\{AccessToken, OAuth, Scopes};
use Pashkevich\Loyverse\Exceptions\ApiException;

/**
 * Class OAuthTest
 *
 * @package Pashkevich\Loyverse\Tests
 */
class OAuthTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_builds_authorization_url()
    {
        $oauth = new OAuth(Mockery::mock(Client::class));

        $url = $oauth->authorizationUrl(
            'client-id',
            'https://example.com/callback',
            'state-value',
            [Scopes::ITEMS_READ, Scopes::RECEIPTS_READ]
        );

        $this->assertStringStartsWith(OAuth::AUTHORIZE_URL, $url);

        parse_str(parse_url($url, PHP_URL_QUERY), $query);

        $this->assertSame('client-id', $query['client_id']);
        $this->assertSame('code', $query['response_type']);
        $this->assertSame('https://example.com/callback', $query['redirect_uri']);
        $this->assertSame('state-value', $query['state']);
        $this->assertSame('ITEMS_READ RECEIPTS_READ', $query['scope']);
    }

    public function test_exchanges_code_for_access_token()
    {
        $client = Mockery::mock(Client::class);

        $client->shouldReceive('request')->once()->with('POST', OAuth::TOKEN_URL, [
            'form_params' => [
                'client_id' => 'client-id',
                'client_secret' => 'client-secret',
                'redirect_uri' => 'https://example.com/callback',
                'code' => 'authorization-code',
                'grant_type' => 'authorization_code',
            ],
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(json_encode([
            'access_token' => 'access-token',
            'token_type' => 'Bearer',
            'expires_in' => 43200,
            'refresh_token' => 'refresh-token',
            'scope' => 'ITEMS_READ RECEIPTS_READ',
        ])));

        $token = (new OAuth($client))->exchangeCode(
            'client-id',
            'client-secret',
            'authorization-code',
            'https://example.com/callback'
        );

        $this->assertSame('access-token', $token->accessToken);
        $this->assertSame('Bearer', $token->tokenType);
        $this->assertSame(43200, $token->expiresIn);
        $this->assertSame('refresh-token', $token->refreshToken);
        $this->assertSame(['ITEMS_READ', 'RECEIPTS_READ'], $token->getScopes());
        $this->assertFalse($token->isExpired());
    }

    public function test_refreshes_access_token()
    {
        $client = Mockery::mock(Client::class);

        $client->shouldReceive('request')->once()->with('POST', OAuth::TOKEN_URL, [
            'form_params' => [
                'client_id' => 'client-id',
                'client_secret' => 'client-secret',
                'refresh_token' => 'refresh-token',
                'grant_type' => 'refresh_token',
            ],
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(json_encode([
            'access_token' => 'new-access-token',
            'token_type' => 'Bearer',
            'expires_in' => 43200,
        ])));

        $token = (new OAuth($client))->refreshToken('client-id', 'client-secret', 'refresh-token');

        $this->assertSame('new-access-token', $token->accessToken);
        $this->assertNull($token->refreshToken);
    }

    public function test_throws_exception_on_failed_token_request()
    {
        $client = Mockery::mock(Client::class);

        $client->shouldReceive('request')->once()->with('POST', OAuth::TOKEN_URL, [
            'form_params' => [
                'client_id' => 'client-id',
                'client_secret' => 'client-secret',
                'refresh_token' => 'invalid-refresh-token',
                'grant_type' => 'refresh_token',
            ],
        ])->andReturn($response = Mockery::mock(Response::class));

        $response->shouldReceive('getStatusCode')->once()->andReturn(400);
        $response->shouldReceive('getBody')->once()->andReturn(Utils::streamFor(json_encode([
            'error' => 'invalid_grant',
            'error_description' => 'The refresh token is invalid.',
        ])));

        try {
            (new OAuth($client))->refreshToken('client-id', 'client-secret', 'invalid-refresh-token');
            $this->fail('Expected ApiException to be thrown.');
        } catch (ApiException $exception) {
            $this->assertSame(400, $exception->getStatus());
            $this->assertSame('invalid_grant', $exception->getErrorCode());
            $this->assertSame('The refresh token is invalid.', $exception->getMessage());
        }
    }

    public function test_access_token_exposes_scopes_expiration_and_id_token_claims()
    {
        $payload = rtrim(strtr(base64_encode(json_encode([
            'sub' => 'user-id',
            'iss' => 'https://api.loyverse.com',
        ])), '+/', '-_'), '=');

        $token = new AccessToken([
            'access_token' => 'access-token',
            'expires_in' => 10,
            'scope' => 'OPENID ITEMS_READ',
            'id_token' => 'header.' . $payload . '.signature',
            'created_at' => time() - 20,
        ]);

        $this->assertTrue($token->isExpired());
        $this->assertSame(['OPENID', 'ITEMS_READ'], $token->getScopes());
        $this->assertSame('user-id', $token->getIdTokenClaims()['sub']);
    }
}
