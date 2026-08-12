<?php

namespace App\Services\Category\Contracts;

use App\Models\Category;

interface CategoryServiceInterface
{
    public function getActiveCategories();
    public function getCategoryBySlug(string $slug): ?Category;
    public function getCategoryId(int $id): Category;
}
