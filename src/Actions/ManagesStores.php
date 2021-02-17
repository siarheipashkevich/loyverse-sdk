<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Store;

/**
 * Trait ManagesStores
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesStores
{
    /**
     * Get a list of stores.
     *
     * @param array $parameters
     * @return Store[]
     */
    public function stores(array $parameters = []): array
    {
        return $this->transformCollection($this->get('stores', $parameters)['stores'], Store::class);
    }

    /**
     * Get a single store.
     *
     * @param string $storeId
     * @return Store
     */
    public function store(string $storeId): Store
    {
        return new Store($this->get("stores/$storeId"), $this);
    }
}
