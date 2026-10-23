<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Customer;

/**
 * Trait ManagesCustomers
 */
trait ManagesCustomers
{
    /**
     * Get a list of customers.
     *
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    public function customers(array $parameters = []): array
    {
        return $this->getPage('customers', $parameters, 'customers', Customer::class);
    }

    /**
     * Get a single customer.
     */
    public function customer(string $customerId): Customer
    {
        return $this->getResource("customers/$customerId", Customer::class);
    }

    /**
     * Create or update a single customer.
     *
     * @param  array<string, mixed>  $data
     */
    public function createCustomer(array $data): Customer
    {
        return $this->resource($this->post('customers', $data), Customer::class);
    }

    /**
     * Delete a single resource.
     *
     * @return array<string, mixed>
     */
    public function deleteCustomer(string $customerId): array
    {
        return $this->deleteResource("customers/$customerId");
    }
}
