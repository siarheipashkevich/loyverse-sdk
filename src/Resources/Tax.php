<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Tax
 */
class Tax extends Resource
{
    /**
     * The tax id.
     */
    public string $id;

    /**
     * The tax type.
     */
    public string $type;

    /**
     * The tax name.
     */
    public string $name;

    /**
     * The tax rate.
     */
    public float $rate;

    /**
     * The list of store ids where this tax is available.
     *
     * @var string[]
     */
    public array $stores;

    /**
     * The time when this resource was created.
     */
    public string $createdAt;

    /**
     * The time when this resource was updated.
     */
    public string $updatedAt;

    /**
     * The time when this resource was deleted.
     */
    public ?string $deletedAt;

    /**
     * Update the given tax.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(array $data): Tax
    {
        return $this->client()->createTax(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given tax.
     *
     * @return array<string, mixed>
     */
    public function delete(): array
    {
        return $this->client()->deleteTax($this->id);
    }
}
