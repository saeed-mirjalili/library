<?php

namespace App\Http\Controllers;

use App\Http\Resources\bookResource;
use App\Http\Resources\userResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class panelController extends mainController
{
    public function addBook(Book $book) {
        $user = auth()->user();
        $book->users()->attach($user);
        return $this->Response('add book', 'success', new bookResource($book), 200);
    }
    public function addBooks(Request $request) {
        $validator = Validator::make($request->all(),[
            'books' => 'required|array|min:1',
            'books.*' => 'numeric'
        ]);
        if ($validator->fails()) {
            return $this->Response('Error',$validator->messages(),null,500);
        }
        $user = auth()->user();
        $book = Book::find($request->books);
        $result = $user->books()->attach($book);
        
        return $this->Response('add books', 'success', $result, 200);
    }

    public function showBook() {
        $user = auth()->user();
        return $this->Response('show books', 'success', new userResource($user->load('books')), 200);
    }

    public function removebooks(Request $request) {
        $validator = Validator::make($request->all(),[
            'books' => 'required|array|min:1',
            'books.*' => 'numeric'
        ]);
        if ($validator->fails()) {
            return $this->Response('Error',$validator->messages(),null,500);
        }
        $user = auth()->user();
        $book = Book::find($request->books);
        $result = $user->books()->detach($book);
        
        return $this->Response('remove books', 'success', $result, 200);
    }
}
