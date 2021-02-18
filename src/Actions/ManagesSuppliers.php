<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Supplier;

/**
 * Trait ManagesSuppliers
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesSuppliers
{
    /**
     * Get a list of suppliers.
     *
     * @param array $parameters
     * @return Supplier[]
     */
    public function suppliers(array $parameters = []): array
    {
        return $this->transformCollection($this->get('suppliers', $parameters)['suppliers'], Supplier::class);
    }

    /**
     * Get a single supplier.
     *
     * @param string $supplierId
     * @return Supplier
     */
    public function supplier(string $supplierId): Supplier
    {
        return new Supplier($this->get("suppliers/$supplierId"), $this);
    }

    /**
     * Create or update a single supplier.
     *
     * @param array $data
     * @return Supplier
     */
    public function createSupplier(array $data): Supplier
    {
        $item = $this->post('suppliers', $data);

        return new Supplier($item, $this);
    }

    /**
     * Delete a single resource.
     *
     * @param string $supplierId
     * @return array
     */
    public function deleteSupplier(string $supplierId): array
    {
        return $this->delete("suppliers/$supplierId");
    }
}
