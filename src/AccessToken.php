<?php

namespace Pashkevich\Loyverse;

/**
 * Class AccessToken
 *
 * @package Pashkevich\Loyverse
 */
class AccessToken
{
    /**
     * The access token.
     *
     * @var string
     */
    public string $accessToken;

    /**
     * The token type.
     *
     * @var string
     */
    public string $tokenType;

    /**
     * The number of seconds until the access token expires.
     *
     * @var int
     */
    public int $expiresIn;

    /**
     * The refresh token.
     *
     * @var string|null
     */
    public ?string $refreshToken;

    /**
     * The space-separated list of granted scopes.
     *
     * @var string|null
     */
    public ?string $scope;

    /**
     * The OpenID Connect ID token.
     *
     * @var string|null
     */
    public ?string $idToken;

    /**
     * The Unix timestamp when the token was received.
     *
     * @var int
     */
    public int $createdAt;

    /**
     * AccessToken constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->accessToken = (string)($attributes['access_token'] ?? '');
        $this->tokenType = (string)($attributes['token_type'] ?? 'Bearer');
        $this->expiresIn = (int)($attributes['expires_in'] ?? 0);
        $this->refreshToken = isset($attributes['refresh_token']) ? (string)$attributes['refresh_token'] : null;
        $this->scope = isset($attributes['scope']) ? (string)$attributes['scope'] : null;
        $this->idToken = isset($attributes['id_token']) ? (string)$attributes['id_token'] : null;
        $this->createdAt = (int)($attributes['created_at'] ?? time());
    }

    /**
     * Create a token from an API response.
     *
     * @param array $attributes
     * @return static
     */
    public static function fromArray(array $attributes): self
    {
        return new static($attributes);
    }

    /**
     * Get the granted scopes.
     *
     * @return string[]
     */
    public function getScopes(): array
    {
        if ($this->scope === null || trim($this->scope) === '') {
            return [];
        }

        return preg_split('/\s+/', trim($this->scope)) ?: [];
    }

    /**
     * Determine if the access token has expired.
     *
     * @param int $leeway
     * @return bool
     */
    public function isExpired(int $leeway = 0): bool
    {
        if ($this->expiresIn <= 0) {
            return false;
        }

        return time() >= ($this->createdAt + $this->expiresIn - $leeway);
    }

    /**
     * Get the claims from the OpenID Connect ID token.
     *
     * The signature is not verified. Use these claims only after validating the
     * token signature against the Loyverse OpenID Connect configuration.
     *
     * @return array|null
     */
    public function getIdTokenClaims(): ?array
    {
        if ($this->idToken === null) {
            return null;
        }

        $parts = explode('.', $this->idToken);

        if (count($parts) !== 3) {
            return null;
        }

        $payload = strtr($parts[1], '-_', '+/');
        $payload .= str_repeat('=', (4 - strlen($payload) % 4) % 4);

        $decoded = base64_decode($payload, true);

        if ($decoded === false) {
            return null;
        }

        $claims = json_decode($decoded, true);

        return is_array($claims) ? $claims : null;
    }

    /**
     * Convert the token back to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'access_token' => $this->accessToken,
            'token_type' => $this->tokenType,
            'expires_in' => $this->expiresIn,
            'refresh_token' => $this->refreshToken,
            'scope' => $this->scope,
            'id_token' => $this->idToken,
            'created_at' => $this->createdAt,
        ];
    }
}
