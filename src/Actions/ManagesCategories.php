<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Category;

/**
 * Trait ManagesCategories
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesCategories
{
    /**
     * Get a list of categories.
     *
     * @param array $parameters
     * @return Category[]
     */
    public function categories(array $parameters = []): array
    {
        return $this->transformCollection($this->get('categories', $parameters)['categories'], Category::class);
    }

    /**
     * Get a single category.
     *
     * @param string $categoryId
     * @return Category
     */
    public function category(string $categoryId): Category
    {
        return new Category($this->get("categories/$categoryId"), $this);
    }

    /**
     * Create or update a single category.
     *
     * @param array $data
     * @return Category
     */
    public function createCategory(array $data): Category
    {
        $item = $this->post('categories', $data);

        return new Category($item, $this);
    }

    /**
     * Delete a single resource.
     *
     * @param string $categoryId
     * @return array
     */
    public function deleteCategory(string $categoryId): array
    {
        return $this->delete("categories/$categoryId");
    }
}
