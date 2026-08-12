<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\Category\Contracts\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
{
    public function __construct(
        private readonly  CategoryRepositoryInterface $category,
    ) {
    }

    public function getActiveCategories()
    {
        return $this->category->getActiveCategories();
    }

    public function getCategoryBySlug(string $slug): ?Category
    {
        return $this->category->getCategoryBySlug($slug);
    }

    public function getCategoryId(int $id): Category
    {
        return $this->category->getCategoryById($id);
    }
}
