<?php

namespace App\Http\Controllers;

use App\Http\Resources\bookResource;
use App\Http\Resources\userResource;
use App\Models\Book;
use App\saeed\Facades\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class panelController extends Controller
{
    public function addBook(Book $book) {
        $user = auth()->user();
        $book->users()->attach($user);
        return ApiResponse::withData(new bookResource($book))->build()->apiResponse();
    }
    
    public function addBooks(Request $request) {
        $validator = Validator::make($request->all(),[
            'books' => 'required|array|min:1',
            'books.*' => 'numeric'
        ]);
        if ($validator->fails()) {
            return ApiResponse::withData($validator->messages())->withStatus(500)->build()->apiResponse();
        }
        $user = auth()->user();
        $book = Book::find($request->books);
        $result = $user->books()->attach($book);
        
        return ApiResponse::withMessage('add books successful')->withData($result)->build()->apiResponse();
    }

    public function showBook() {
        $user = auth()->user();
        return ApiResponse::withMessage('show books successful')->withData(new userResource($user->load('books')))->build()->apiResponse();
    }

    public function removebooks(Request $request) {
        $validator = Validator::make($request->all(),[
            'books' => 'required|array|min:1',
            'books.*' => 'numeric'
        ]);
        if ($validator->fails()) {
            return ApiResponse::withData($validator->messages())->withStatus(500)->build()->apiResponse();
        }
        $user = auth()->user();
        $book = Book::find($request->books);
        $result = $user->books()->detach($book);
        
        return ApiResponse::withMessage('remove books successful')->build()->apiResponse();
    }
}
