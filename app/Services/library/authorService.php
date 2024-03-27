<?php

namespace App\Services\library;

use App\Models\library\Author;
use App\Services\serviceResult;
use App\Services\serviceWrapper;

class authorService
{
    public function storeAuthor(mixed $inputs): serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs) {
            $validated = $inputs->except('categories');
            $author = Author::create($validated);

            if ($inputs->has('categories')) {
                foreach($inputs->categories as $category){
                    $author->categories()->attach($category);
                }
            }
            return $author;
        });
    }
    public function updateAuthor(mixed $inputs, Author $author): serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs, $author) {
            if ($inputs->has('name')) {
                $author->update($inputs->except('categories'));
            }

            if ($inputs->has('categories')) {
                $author->categories()->sync($inputs->categories);
            }
            return $author;
        });
    }
    public function deleteAuthor(Author $author): serviceResult {
        return app(serviceWrapper::class)(function () use($author) {
            return $author->delete();
        });
    }
}
