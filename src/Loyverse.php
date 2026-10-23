<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse;

use Generator;
use GuzzleHttp\Client;
use Pashkevich\Loyverse\Resources\Resource;

/**
 * Class Loyverse
 */
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
     * Transform the items of the collection to the given class.
     *
     * @template T of Resource
     *
     * @param  array<int, array<string, mixed>>  $collection
     * @param  class-string<T>  $class
     * @param  array<string, mixed>  $extraData
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
     * @param  array<string, mixed>  $response
     * @param  TKey  $key
     * @param  class-string<T>  $class
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
     * @param  class-string<T>  $class
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
     * @param  class-string<T>  $class
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
     * @param  array<string, mixed>  $parameters
     * @param  TKey  $key
     * @param  class-string<T>  $class
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
     * @param  callable(array<string, mixed>): array<string, mixed>  $fetch
     * @param  array<string, mixed>  $parameters
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

        $this->guzzle = $guzzle ?: new Client([
            'base_uri' => 'https://api.loyverse.com/v1.0/',
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer '.$this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

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
