<?php

namespace Pashkevich\Loyverse;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Pashkevich\Loyverse\Exceptions\ApiException;

/**
 * Class OAuth
 *
 * @package Pashkevich\Loyverse
 */
class OAuth
{
    public const AUTHORIZE_URL = 'https://api.loyverse.com/oauth/authorize';
    public const TOKEN_URL = 'https://api.loyverse.com/oauth/token';

    /**
     * The Guzzle HTTP Client instance.
     *
     * @var Client
     */
    protected Client $guzzle;

    /**
     * OAuth constructor.
     *
     * @param Client|null $guzzle
     */
    public function __construct(?Client $guzzle = null)
    {
        $this->guzzle = $guzzle ?: new Client([
            'http_errors' => false,
        ]);
    }

    /**
     * Generate a random state value for the authorization request.
     *
     * @return string
     */
    public static function generateState(): string
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * Build the URL the merchant should be redirected to.
     *
     * @param string $clientId
     * @param string $redirectUri
     * @param string $state
     * @param array $scopes
     * @return string
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

        if (!empty($scopes)) {
            $query['scope'] = implode(' ', $scopes);
        }

        return self::AUTHORIZE_URL . '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986);
    }

    /**
     * Exchange an authorization code for an access token.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string $code
     * @param string $redirectUri
     * @return AccessToken
     */
    public function exchangeCode(
        string $clientId,
        string $clientSecret,
        string $code,
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
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string $refreshToken
     * @return AccessToken
     */
    public function refreshToken(
        string $clientId,
        string $clientSecret,
        string $refreshToken
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
     * @param array $payload
     * @return AccessToken
     */
    public function requestToken(array $payload): AccessToken
    {
        try {
            $response = $this->guzzle->request('POST', self::TOKEN_URL, [
                'form_params' => $payload,
            ]);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();

            if ($response === null) {
                throw new ApiException($exception->getMessage(), 0, $exception);
            }
        } catch (GuzzleException $exception) {
            throw new ApiException($exception->getMessage(), 0, $exception);
        }

        $status = $response->getStatusCode();

        $body = (string)$response->getBody();

        $data = json_decode($body, true);

        if ($status < 200 || $status >= 300) {
            $error = is_array($data) ? $data : [];

            $message = $error['error_description'] ?? $error['error'] ?? 'OAuth token request failed.';

            $code = isset($error['error']) ? (string)$error['error'] : null;

            throw (new ApiException((string)$message))->setContext($status, [], $code);
        }

        if (!is_array($data) || !isset($data['access_token'])) {
            throw new ApiException('Invalid OAuth token response.');
        }

        return new AccessToken($data);
    }
}
