<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Supplier;

trait ManagesSuppliers
{
    /**
     * Get a list of suppliers.
     *
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public function suppliers(array $parameters = []): array
    {
        return $this->getPage('suppliers', $parameters, 'suppliers', Supplier::class);
    }

    /**
     * Get a single supplier.
     */
    public function supplier(string $supplierId): Supplier
    {
        return $this->getResource("suppliers/$supplierId", Supplier::class);
    }

    /**
     * Create or update a single supplier.
     *
     * @param array<string, mixed> $data
     */
    public function createSupplier(array $data): Supplier
    {
        return $this->resource($this->post('suppliers', $data), Supplier::class);
    }

    /**
     * Delete a single resource.
     *
     * @return array<string, mixed>
     */
    public function deleteSupplier(string $supplierId): array
    {
        return $this->deleteResource("suppliers/$supplierId");
    }
}
