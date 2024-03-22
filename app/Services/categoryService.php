<?php

namespace App\Services;

use App\Models\Category;

class categoryService
{
    public function storeCategory(array $inputs): serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs) {
            return Category::create($inputs);
        });
    }
    public function updateCategory(array $inputs, mixed $category): serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs,$category) {
            return $category->update($inputs);
        });
    }
    public function deleteCategory(mixed $category): serviceResult
    {
        return app(serviceWrapper::class)(function () use($category) {
            return $category->delete();
        });
    }
}