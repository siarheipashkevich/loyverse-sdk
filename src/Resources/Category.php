<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Category
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Category extends Resource
{
    /**
     * The category id.
     *
     * @var string
     */
    public string $id;

    /**
     * The category name.
     *
     * @var string
     */
    public string $name;

    /**
     * The category color.
     *
     * @var string
     */
    public string $color;

    /**
     * The time when this resource was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The time when this resource was deleted.
     *
     * @var string|null
     */
    public ?string $deletedAt;

    /**
     * Update the given category.
     *
     * @param array $data
     * @return Category
     */
    public function update(array $data): Category
    {
        return $this->loyverse->createCategory(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given category.
     *
     * @return array
     */
    public function delete(): array
    {
        return $this->loyverse->deleteCategory($this->id);
    }
}
