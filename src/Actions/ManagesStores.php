<?php

namespace Esupl\Loyverse\Actions;

use Esupl\Loyverse\Resources\Store;

/**
 * Trait ManagesStores
 *
 * @package Esupl\Loyverse\Actions
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
        return new Store($this->get("stores/$storeId"));
    }
}
