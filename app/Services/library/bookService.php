<?php

namespace App\Services\library;

use App\Models\library\Book;
use App\Services\serviceResult;
use App\Services\serviceWrapper;
use Illuminate\Support\Facades\Gate;

class bookService
{

    public function indexBook(): serviceResult
    {
        return app(serviceWrapper::class)(function (){
            if (! Gate::allows('exhibite')){
                return [
                    'status' => 403,
                    'message' => 'access denied'
                ];
            }
            $books = Book::paginate(5);
            return $books;
        });
    }
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
    public function showBook(mixed $book): serviceResult
    {
        return app(serviceWrapper::class)(function () use($book) {
            return $book;
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
            if (! Gate::allows('delete')){
                return [
                    'status' => 403,
                    'message' => 'access denied'
                ];
            }
            return $book->delete();
        });
    }
}
