<?php

namespace App\Services\library;

use App\Models\library\Book;
use App\Services\serviceResult;
use App\Services\serviceWrapper;

class bookService
{
    public function storeBook(array $inputs): serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs) {
            // create name $ save image
            $bookName = md5(uniqid(rand(),true)).'.'. $inputs['book_url']->extension();
            $inputs['book_url']->storeAs('/books',$bookName,'public');
            // fix book path
            $inputs['book_url'] = $bookName;
            // create book
            return Book::create($inputs);
        });
    }
    public function updateBook(array $inputs, Book $book) : serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs,$book) {
            if (isset($inputs['book_url'])) {
                $bookName = md5(uniqid(rand(),true)).'.'. $inputs['book_url']->extension();
                $inputs['book_url']->storeAs('/books',$bookName,'public');
                $inputs['book_url'] = $bookName;
            }
            $book->update($inputs);
            return $book;
        });
    }
    public function deleteBook(Book $book) : serviceResult {
        return app(serviceWrapper::class)(function () use($book) {
            return $book->delete();
        });
    }
}
