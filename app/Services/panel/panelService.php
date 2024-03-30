<?php

namespace App\Services\panel;



use App\Models\library\Book;
use App\Services\serviceResult;
use App\Services\serviceWrapper;

class panelService
{
    public function addBook(mixed $inputs): serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs) {
            $user = auth()->user();
            $inputs->users()->attach($user);
        });
    }
    public function addBooks(mixed $inputs): serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs) {
            $user = auth()->user();
            $book = Book::find($inputs->books);
            $user->books()->attach($book);
            return 'add books successful';
        });
    }
    public function showBook(): serviceResult
    {
        return app(serviceWrapper::class)(function () {
            $user = auth()->user();
            return $user;
        });
    }
    public function removebooks(mixed $inputs): serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs) {
            $user = auth()->user();
            $book = Book::find($inputs->books);
            $result = $user->books()->detach($book);
            return $result.' books successfully removed';
        });
    }
}
