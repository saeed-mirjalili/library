<?php

namespace App\Services\library;

use App\Models\library\Category;
use App\Services\serviceResult;
use App\Services\serviceWrapper;

class categoryService
{
    public function indexCategory(): serviceResult
    {
        return app(serviceWrapper::class)(function () {
            $category = Category::paginate(4);
            return $category;
        });
    }
    public function storeCategory(array $inputs): serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs) {
            return Category::create($inputs);
        });
    }
    public function showCategory(mixed $category): serviceResult
    {
        return app(serviceWrapper::class)(function () use($category) {
            return $category;
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
