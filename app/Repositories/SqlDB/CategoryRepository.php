<?php

namespace App\Repositories\SqlDB;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Exception;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getActiveCategories()
    {
        try {
            return Category::query()->where('is_active', true)
                                    ->where('is_featured', true)
                                    ->orderBy('id', 'asc')
                                    ->get();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getCategoryBySlug(string $slug): ?Category
    {
        try {
            return Category::query()->where('is_active', true)
                                    ->where('is_featured', true)
                                    ->where('slug', $slug)
                                    ->first();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getCategoryById(int $id): Category
    {
        try {
            return Category::query()->where('id', $id)->first();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
