<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Category;

trait ManagesCategories
{
    /**
     * Get a list of categories.
     *
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public function categories(array $parameters = []): array
    {
        return $this->getPage('categories', $parameters, 'categories', Category::class);
    }

    /**
     * Get a single category.
     */
    public function category(string $categoryId): Category
    {
        return $this->getResource("categories/$categoryId", Category::class);
    }

    /**
     * Create or update a single category.
     *
     * @param array<string, mixed> $data
     */
    public function createCategory(array $data): Category
    {
        return $this->resource($this->post('categories', $data), Category::class);
    }

    /**
     * Delete a single resource.
     *
     * @return array<string, mixed>
     */
    public function deleteCategory(string $categoryId): array
    {
        return $this->deleteResource("categories/$categoryId");
    }
}
