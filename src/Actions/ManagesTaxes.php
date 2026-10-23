<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Tax;

trait ManagesTaxes
{
    /**
     * Get a list of taxes.
     *
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    public function taxes(array $parameters = []): array
    {
        return $this->getPage('taxes', $parameters, 'taxes', Tax::class);
    }

    /**
     * Get a single tax.
     */
    public function tax(string $taxId): Tax
    {
        return $this->getResource("taxes/$taxId", Tax::class);
    }

    /**
     * Create or update a single tax.
     *
     * @param  array<string, mixed>  $data
     */
    public function createTax(array $data): Tax
    {
        return $this->resource($this->post('taxes', $data), Tax::class);
    }

    /**
     * Delete a single resource.
     *
     * @return array<string, mixed>
     */
    public function deleteTax(string $taxId): array
    {
        return $this->deleteResource("taxes/$taxId");
    }
}
