<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Tax;

/**
 * Trait ManagesTaxes
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesTaxes
{
    /**
     * Get a list of taxes.
     *
     * @param array $parameters
     * @return Tax[]
     */
    public function taxes(array $parameters = []): array
    {
        return $this->transformCollection($this->get('taxes', $parameters)['taxes'], Tax::class);
    }

    /**
     * Get a single tax.
     *
     * @param string $taxId
     * @return Tax
     */
    public function tax(string $taxId): Tax
    {
        return new Tax($this->get("taxes/$taxId"), $this);
    }

    /**
     * Create or update a single tax.
     *
     * @param array $data
     * @return Tax
     */
    public function createTax(array $data): Tax
    {
        $item = $this->post('taxes', $data);

        return new Tax($item, $this);
    }

    /**
     * Delete a single resource.
     *
     * @param string $taxId
     * @return array
     */
    public function deleteTax(string $taxId): array
    {
        return $this->delete("taxes/$taxId");
    }
}
