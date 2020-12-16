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
     * Get the collection of stores.
     *
     * @return Store[]
     */
    public function stores(): array
    {
        return $this->transformCollection($this->get('stores')['stores'], Store::class);
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
