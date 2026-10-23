<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse;

final readonly class AccessToken
{
    /**
     * AccessToken constructor.
     */
    public function __construct(
        public string $accessToken,
        public string $tokenType,
        public int $expiresIn,
        public ?string $refreshToken,
        public ?string $scope,
        public ?string $idToken,
        public int $createdAt,
    ) {
    }

    /**
     * Create a token from an API response.
     *
     * @param  array<string, mixed>  $attributes
     */
    public static function fromArray(array $attributes): self
    {
        return new self(
            (string) ($attributes['access_token'] ?? ''),
            (string) ($attributes['token_type'] ?? 'Bearer'),
            (int) ($attributes['expires_in'] ?? 0),
            isset($attributes['refresh_token']) ? (string) $attributes['refresh_token'] : null,
            isset($attributes['scope']) ? (string) $attributes['scope'] : null,
            isset($attributes['id_token']) ? (string) $attributes['id_token'] : null,
            (int) ($attributes['created_at'] ?? time()),
        );
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
     * @return array<string, mixed>|null
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
     * @return array<string, mixed>
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
