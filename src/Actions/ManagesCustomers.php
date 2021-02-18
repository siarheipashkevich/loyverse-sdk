<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Customer;

/**
 * Trait ManagesCustomers
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesCustomers
{
    /**
     * Get a list of customers.
     *
     * @param array $parameters
     * @return Customer[]
     */
    public function customers(array $parameters = []): array
    {
        return $this->transformCollection($this->get('customers', $parameters)['customers'], Customer::class);
    }

    /**
     * Get a single customer.
     *
     * @param string $customerId
     * @return Customer
     */
    public function customer(string $customerId): Customer
    {
        return new Customer($this->get("customers/$customerId"), $this);
    }

    /**
     * Create or update a single customer.
     *
     * @param array $data
     * @return Customer
     */
    public function createCustomer(array $data): Customer
    {
        $item = $this->post('customers', $data);

        return new Customer($item, $this);
    }

    /**
     * Delete a single resource.
     *
     * @param string $customerId
     * @return array
     */
    public function deleteCustomer(string $customerId): array
    {
        return $this->delete("customers/$customerId");
    }
}
