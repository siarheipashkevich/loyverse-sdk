<?php

namespace Pashkevich\Loyverse;

use GuzzleHttp\Client;

/**
 * Class Loyverse
 *
 * @package Pashkevich\Loyverse
 */
class Loyverse
{
    use MakesHttpRequests;
    use Actions\ManagesEmployees;
    use Actions\ManagesStores;
    use Actions\ManagesReceipts;
    use Actions\ManagesItems;
    use Actions\ManagesVariants;
    use Actions\ManagesMerchants;
    use Actions\ManagesCategories;
    use Actions\ManagesDiscounts;
    use Actions\ManagesPaymentTypes;
    use Actions\ManagesTaxes;
    use Actions\ManagesModifiers;
    use Actions\ManagesCustomers;
    use Actions\ManagesSuppliers;
    use Actions\ManagesInventory;
    use Actions\ManagesShifts;
    use Actions\ManagesPosDevices;
    use Actions\ManagesWebhooks;

    /**
     * The Loyverse API Key.
     *
     * @var string
     */
    protected string $apiKey;

    /**
     * The Guzzle HTTP Client instance.
     *
     * @var Client
     */
    public Client $guzzle;

    /**
     * Number of seconds a request is retried.
     *
     * @var int
     */
    public int $timeout = 30;

    /**
     * Loyverse constructor.
     *
     * @param null $apiKey
     * @param Client|null $guzzle
     */
    public function __construct($apiKey = null, Client $guzzle = null)
    {
        if (!is_null($apiKey)) {
            $this->setApiKey($apiKey, $guzzle);
        }

        if (!is_null($guzzle)) {
            $this->guzzle = $guzzle;
        }
    }

    /**
     * Transform the items of the collection to the given class.
     *
     * @param array $collection
     * @param string $class
     * @param array $extraData
     * @return array
     */
    protected function transformCollection(array $collection, string $class, array $extraData = []): array
    {
        return array_map(function ($data) use ($class, $extraData) {
            return new $class($data + $extraData, $this);
        }, $collection);
    }

    /**
     * Set the api key and setup the guzzle request object.
     *
     * @param string $apiKey
     * @param Client|null $guzzle
     * @return $this
     */
    public function setApiKey(string $apiKey, $guzzle = null): self
    {
        $this->apiKey = $apiKey;

        $this->guzzle = $guzzle ?: new Client([
            'base_uri' => 'https://api.loyverse.com/v1.0/',
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        return $this;
    }

    /**
     * Set a new timeout.
     *
     * @param int $timeout
     * @return $this
     */
    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Get the timeout.
     *
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }
}
