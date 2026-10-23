<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse;

use Generator;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Pashkevich\Loyverse\Auth\ArrayTokenStore;
use Pashkevich\Loyverse\Auth\TokenStore;
use Pashkevich\Loyverse\Resources\Resource;

class Loyverse
{
    use Actions\ManagesCategories;
    use Actions\ManagesCustomers;
    use Actions\ManagesDiscounts;
    use Actions\ManagesEmployees;
    use Actions\ManagesInventory;
    use Actions\ManagesItems;
    use Actions\ManagesMerchants;
    use Actions\ManagesModifiers;
    use Actions\ManagesPaymentTypes;
    use Actions\ManagesPosDevices;
    use Actions\ManagesReceipts;
    use Actions\ManagesShifts;
    use Actions\ManagesStores;
    use Actions\ManagesSuppliers;
    use Actions\ManagesTaxes;
    use Actions\ManagesVariants;
    use Actions\ManagesWebhooks;
    use MakesHttpRequests;

    public const string VERSION = '4.2.0';

    public const string DEFAULT_BASE_URI = 'https://api.loyverse.com/v1.0/';

    /**
     * The Loyverse API Key.
     */
    protected string $apiKey;

    /**
     * The Guzzle HTTP Client instance.
     */
    public Client $guzzle;

    /**
     * Number of seconds a request is retried.
     */
    public int $timeout = 30;

    /**
     * The connection timeout in seconds.
     */
    public ?float $connectTimeout = null;

    /**
     * The optional custom base URI.
     */
    protected ?string $baseUri = null;

    /**
     * The default request headers.
     *
     * @var array<string, string>
     */
    protected array $headers = [];

    /**
     * The OAuth client.
     */
    protected ?OAuth $oauth = null;

    /**
     * The OAuth client id.
     */
    protected ?string $oauthClientId = null;

    /**
     * The OAuth client secret.
     */
    protected ?string $oauthClientSecret = null;

    /**
     * The OAuth token store.
     */
    protected ?TokenStore $tokenStore = null;

    /**
     * Loyverse constructor.
     */
    public function __construct(?string $apiKey = null, ?Client $guzzle = null)
    {
        if (! is_null($apiKey)) {
            $this->setApiKey($apiKey, $guzzle);
        }

        if (! is_null($guzzle)) {
            $this->guzzle = $guzzle;
        }
    }

    /**
     * Create a client with mocked responses.
     *
     * @param array<int, mixed> $responses
     */
    public static function fake(array $responses = [], ?string $apiKey = null): self
    {
        $client = new Client([
            'base_uri' => self::DEFAULT_BASE_URI,
            'http_errors' => false,
            'handler' => HandlerStack::create(new MockHandler($responses)),
        ]);

        return new self($apiKey, $client);
    }

    /**
     * Set a custom base URI.
     */
    public function setBaseUri(string $baseUri): static
    {
        if (trim($baseUri) === '') {
            throw new \InvalidArgumentException('The base URI cannot be empty.');
        }

        $this->baseUri = rtrim($baseUri, '/').'/';

        return $this;
    }

    /**
     * Get the custom base URI.
     */
    public function getBaseUri(): ?string
    {
        return $this->baseUri;
    }

    /**
     * Set a default request header.
     */
    public function setHeader(string $name, string $value): static
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Set multiple default request headers.
     *
     * @param array<string, string> $headers
     */
    public function setHeaders(array $headers): static
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * Get the default request headers.
     *
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set the connection timeout in seconds.
     */
    public function setConnectTimeout(float $seconds): static
    {
        $this->connectTimeout = $seconds;

        return $this;
    }

    /**
     * Configure OAuth authentication.
     */
    public function withOAuth(
        OAuth $oauth,
        string $clientId,
        #[\SensitiveParameter] string $clientSecret,
        ?TokenStore $tokenStore = null
    ): static {
        $this->oauth = $oauth;
        $this->oauthClientId = $clientId;
        $this->oauthClientSecret = $clientSecret;

        if ($tokenStore !== null) {
            $this->tokenStore = $tokenStore;
        } elseif ($this->tokenStore === null) {
            $this->tokenStore = new ArrayTokenStore();
        }

        if (! isset($this->guzzle)) {
            $this->guzzle = $this->createClient();
        }

        return $this;
    }

    /**
     * Set the current access token.
     */
    public function setAccessToken(AccessToken $token): static
    {
        if ($this->tokenStore === null) {
            $this->tokenStore = new ArrayTokenStore();
        }

        $this->tokenStore->set($token);

        return $this;
    }

    /**
     * Get the current access token.
     */
    public function getAccessToken(): ?AccessToken
    {
        return $this->tokenStore?->get();
    }

    /**
     * Refresh the current access token.
     */
    public function refreshAccessToken(): bool
    {
        if (
            $this->oauth === null
            || $this->oauthClientId === null
            || $this->oauthClientSecret === null
            || $this->tokenStore === null
        ) {
            return false;
        }

        $token = $this->tokenStore->get();

        if ($token === null || $token->refreshToken === null) {
            return false;
        }

        $newToken = $this->oauth->refreshToken(
            $this->oauthClientId,
            $this->oauthClientSecret,
            $token->refreshToken
        );

        $this->tokenStore->set($newToken);

        return true;
    }

    /**
     * Apply the current access token to the request options.
     *
     * @param array<string, mixed> $options
     */
    protected function applyOAuth(array &$options): void
    {
        $token = $this->getAccessToken();

        if ($token === null) {
            return;
        }

        if ($token->isExpired(60) && $this->refreshAccessToken()) {
            $token = $this->getAccessToken();
        }

        if ($token === null) {
            return;
        }

        $options['headers'] = array_merge(
            $options['headers'] ?? [],
            ['Authorization' => 'Bearer '.$token->accessToken]
        );
    }

    /**
     * Create a new Guzzle client.
     */
    protected function createClient(?string $apiKey = null): Client
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'User-Agent' => 'loyverse-sdk/'.self::VERSION.' (PHP '.PHP_VERSION.')',
        ];

        if ($apiKey !== null) {
            $headers['Authorization'] = 'Bearer '.$apiKey;
        }

        return new Client([
            'base_uri' => self::DEFAULT_BASE_URI,
            'http_errors' => false,
            'headers' => $headers,
        ]);
    }

    /**
     * Transform the items of the collection to the given class.
     *
     * @template T of Resource
     *
     * @param array<int, array<string, mixed>> $collection
     * @param class-string<T> $class
     * @param array<string, mixed> $extraData
     * @return array<int, T>
     */
    protected function transformCollection(array $collection, string $class, array $extraData = []): array
    {
        return array_map(function (array $data) use ($class, $extraData): Resource {
            return new $class($data + $extraData, $this);
        }, $collection);
    }

    /**
     * Transform a page response into a list of resources and a cursor.
     *
     * @template TKey of string
     * @template T of Resource
     *
     * @param array<string, mixed> $response
     * @param TKey $key
     * @param class-string<T> $class
     * @return array<string, mixed>
     */
    protected function transformPage(array $response, string $key, string $class): array
    {
        $resources = $response[$key] ?? [];

        return [
            $key => $this->transformCollection(is_array($resources) ? $resources : [], $class),
            'cursor' => isset($response['cursor']) ? (string) $response['cursor'] : null,
        ];
    }

    /**
     * Create a resource from an API response.
     *
     * @template T of Resource
     *
     * @param class-string<T> $class
     * @return T
     */
    protected function resource(mixed $response, string $class): Resource
    {
        if (! is_array($response)) {
            throw new Exceptions\UnknownException('Unexpected response from the Loyverse API.');
        }

        return new $class($response, $this);
    }

    /**
     * Get a single resource.
     *
     * @template T of Resource
     *
     * @param class-string<T> $class
     * @return T
     */
    protected function getResource(string $uri, string $class): Resource
    {
        return $this->resource($this->get($uri), $class);
    }

    /**
     * Get a page of resources.
     *
     * @template TKey of string
     * @template T of Resource
     *
     * @param array<string, mixed> $parameters
     * @param TKey $key
     * @param class-string<T> $class
     * @return array<string, mixed>
     */
    protected function getPage(string $uri, array $parameters, string $key, string $class): array
    {
        $response = $this->get($uri, $parameters);

        if (! is_array($response)) {
            throw new Exceptions\UnknownException('Unexpected response from the Loyverse API.');
        }

        return $this->transformPage($response, $key, $class);
    }

    /**
     * Delete a resource and return the decoded response.
     *
     * @return array<string, mixed>
     */
    protected function deleteResource(string $uri): array
    {
        $response = $this->delete($uri);

        if (! is_array($response)) {
            throw new Exceptions\UnknownException('Unexpected response from the Loyverse API.');
        }

        return $response;
    }

    /**
     * Iterate over all pages returned by the given callback.
     *
     * The callback receives the current query parameters and must return a page
     * array with a list of resources and a cursor.
     *
     * @param callable(array<string, mixed>): array<string, mixed> $fetch
     * @param array<string, mixed> $parameters
     * @return Generator<int, Resources\Resource>
     */
    public function paginate(callable $fetch, array $parameters = []): Generator
    {
        $cursor = null;
        $seen = [];

        do {
            $pageParameters = $parameters;

            if ($cursor !== null) {
                $pageParameters['cursor'] = $cursor;
            }

            $page = $fetch($pageParameters);

            foreach ($page as $key => $value) {
                if ($key === 'cursor' || ! is_array($value)) {
                    continue;
                }

                foreach ($value as $resource) {
                    yield $resource;
                }
            }

            $cursor = $page['cursor'] ?? null;

            if ($cursor === '') {
                $cursor = null;
            }

            if ($cursor !== null) {
                if (isset($seen[$cursor])) {
                    break;
                }

                $seen[$cursor] = true;
            }
        } while ($cursor !== null);
    }

    /**
     * Set the api key and setup the guzzle request object.
     *
     * @return $this
     */
    public function setApiKey(#[\SensitiveParameter] string $apiKey, ?Client $guzzle = null): static
    {
        $this->apiKey = $apiKey;

        $this->guzzle = $guzzle ?: $this->createClient($this->apiKey);

        return $this;
    }

    /**
     * Set a new timeout.
     *
     * @return $this
     */
    public function setTimeout(int $timeout): static
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Get the timeout.
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }
}
