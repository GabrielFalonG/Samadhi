<?php

namespace App\Repositories\Contracts;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function getActiveCategories();
    public function getCategoryBySlug(string $slug): ?Category;
    public function getCategoryById(int $id): Category;
}
