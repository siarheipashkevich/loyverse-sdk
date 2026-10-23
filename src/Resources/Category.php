<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Category
 */
class Category extends Resource
{
    /**
     * The category id.
     */
    public string $id;

    /**
     * The category name.
     */
    public string $name;

    /**
     * The category color.
     */
    public string $color;

    /**
     * The time when this resource was created.
     */
    public string $createdAt;

    /**
     * The time when this resource was deleted.
     */
    public ?string $deletedAt;

    /**
     * Update the given category.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(array $data): Category
    {
        return $this->client()->createCategory(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given category.
     *
     * @return array<string, mixed>
     */
    public function delete(): array
    {
        return $this->client()->deleteCategory($this->id);
    }
}
