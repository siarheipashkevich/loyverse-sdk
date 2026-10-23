<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ResponseException;
use Pashkevich\Loyverse\Exceptions\ApiException;

class OAuth
{
    public const string AUTHORIZE_URL = 'https://api.loyverse.com/oauth/authorize';

    public const string TOKEN_URL = 'https://api.loyverse.com/oauth/token';

    /**
     * The Guzzle HTTP Client instance.
     */
    protected readonly Client $guzzle;

    /**
     * OAuth constructor.
     */
    public function __construct(?Client $guzzle = null)
    {
        $this->guzzle = $guzzle ?: new Client([
            'http_errors' => false,
        ]);
    }

    /**
     * Generate a random state value for the authorization request.
     */
    public static function generateState(): string
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * Build the URL the merchant should be redirected to.
     *
     * @param array<Scope|string> $scopes
     */
    public function authorizationUrl(
        string $clientId,
        string $redirectUri,
        string $state,
        array $scopes = []
    ): string {
        $query = [
            'client_id' => $clientId,
            'response_type' => 'code',
            'redirect_uri' => $redirectUri,
            'state' => $state,
        ];

        if (! empty($scopes)) {
            $values = array_map(
                static fn (Scope|string $scope): string => $scope instanceof Scope ? $scope->value : $scope,
                $scopes
            );

            $query['scope'] = implode(' ', $values);
        }

        return self::AUTHORIZE_URL.'?'.http_build_query($query, '', '&', PHP_QUERY_RFC3986);
    }

    /**
     * Exchange an authorization code for an access token.
     */
    public function exchangeCode(
        string $clientId,
        #[\SensitiveParameter] string $clientSecret,
        #[\SensitiveParameter] string $code,
        string $redirectUri
    ): AccessToken {
        return $this->requestToken([
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'code' => $code,
            'grant_type' => 'authorization_code',
        ]);
    }

    /**
     * Refresh an access token.
     */
    public function refreshToken(
        string $clientId,
        #[\SensitiveParameter] string $clientSecret,
        #[\SensitiveParameter] string $refreshToken
    ): AccessToken {
        return $this->requestToken([
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
        ]);
    }

    /**
     * Request a new token from the OAuth server.
     *
     * @param array<string, mixed> $payload
     */
    public function requestToken(#[\SensitiveParameter] array $payload): AccessToken
    {
        try {
            $response = $this->guzzle->request('POST', self::TOKEN_URL, [
                'form_params' => $payload,
            ]);
        } catch (ResponseException $exception) {
            $response = $exception->getResponse();
        } catch (GuzzleException $exception) {
            throw new ApiException($exception->getMessage(), 0, $exception);
        }

        $status = $response->getStatusCode();

        $body = (string) $response->getBody();

        $data = json_decode($body, true);

        if ($status < 200 || $status >= 300) {
            $error = is_array($data) ? $data : [];

            $message = $error['error_description'] ?? $error['error'] ?? 'OAuth token request failed.';

            if (! is_string($message)) {
                $message = 'OAuth token request failed.';
            }

            $code = isset($error['error']) && is_scalar($error['error']) ? (string) $error['error'] : null;

            throw new ApiException($message)->setContext($status, [], $code);
        }

        if (! is_array($data) || ! isset($data['access_token'])) {
            throw new ApiException('Invalid OAuth token response.');
        }

        $attributes = [];

        foreach ($data as $key => $value) {
            if (is_string($key)) {
                $attributes[$key] = $value;
            }
        }

        return AccessToken::fromArray($attributes);
    }
}
