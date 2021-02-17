<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Tax
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Tax extends Resource
{
    /**
     * The tax id.
     *
     * @var string
     */
    public string $id;

    /**
     * The tax type.
     *
     * @var string
     */
    public string $type;

    /**
     * The tax name.
     *
     * @var string
     */
    public string $name;

    /**
     * The tax rate.
     *
     * @var float
     */
    public float $rate;

    /**
     * The list of store ids where this tax is available.
     *
     * @var array
     */
    public array $stores;

    /**
     * The date/time the resource was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The date/time the resource was updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * The date/time the resource was deleted.
     *
     * @var string
     */
    public string $deletedAt;

    /**
     * Update the given tax.
     *
     * @param array $data
     * @return Tax
     */
    public function update(array $data): Tax
    {
        return $this->loyverse->createTax(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given tax.
     *
     * @return array
     */
    public function delete(): array
    {
        return $this->loyverse->deleteTax($this->id);
    }
}
