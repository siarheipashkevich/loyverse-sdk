<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Store;

trait ManagesStores
{
    /**
     * Get a list of stores.
     *
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public function stores(array $parameters = []): array
    {
        return $this->getPage('stores', $parameters, 'stores', Store::class);
    }

    /**
     * Get a single store.
     */
    public function store(string $storeId): Store
    {
        return $this->getResource("stores/$storeId", Store::class);
    }
}
