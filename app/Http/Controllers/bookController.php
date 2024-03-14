<?php

namespace App\Http\Controllers;

use App\Http\Resources\bookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class bookController extends mainController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::paginate(5);
        return $this->Response('books', 'success', [
            'data' => bookResource::collection($books),
            'links' => bookResource::collection($books)->response()->getData()->links,
            'meta' => bookResource::collection($books)->response()->getData()->meta,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'summary' => 'required|string',
            'edition' => 'required|date_format:Y',
            'author_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'book_url' => 'required|image'
        ]);

        if ($validator->fails()) {
            return $this->Response('Error', $validator->messages(), null, 500);
        }

        $bookName = md5(uniqid(rand(),true)).'.'. $request->book_url->extension();
        $request->book_url->storeAs('/books',$bookName,'public');

        $book = Book::create([
            'name' => $request->name,
            'summary' => $request->summary,
            'edition' => $request->edition,
            'author_id' => $request->author_id,
            'category_id' => $request->category_id,
            'book_url' => $bookName
        ]);
        return $this->Response('create', 'success', new bookResource($book), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return $this->Response('show', 'success', new bookResource($book->load('author')
                                                                        ->load('category')), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'string',
            'summary' => 'string',
            'edition' => 'date_format:Y',
            'author_id' => 'numeric',
            'category_id' => 'numeric',
            'book_url' => 'image'
        ]);
        if ($validator->fails()) {
            return $this->Response('Error', $validator->messages(), null, 500);
        }

        if ($request->has('book_url')) {
            $bookName = md5(uniqid(rand(),true)).'.'. $request->book_url->extension();
            $request->book_url->storeAs('/books',$bookName,'public');
        }

        $book->update([
            'name' => $request->name,
            'summary' => $request->summary,
            'edition' => $request->edition,
            'author_id' => $request->author_id,
            'category_id' => $request->category_id,
            'book_url' => $request->has('book_url') ? $bookName : $book->book_url
        ]);
        return $this->Response('create', 'success', new bookResource($book->load('author')
                                                                          ->load('category')), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $delete = $book->delete();
        return $this->Response('delete', 'success', $delete, 200);
    }

    public function usersBook(Book $book) {
        $user = auth()->user();
        $book->users()->attach($user);
        return $this->Response('add book', 'success', new bookResource($book), 200);
    }

    public function usersBooks(Request $request) {

        $validator = Validator::make($request->all(),[
            'books' => 'numeric'
        ]);
        if ($validator->fails()) {
            return $this->Response('Error', $validator->messages(), null, 500);
        }
        $user = auth()->user();
        dd($request->books);
        foreach ($request->books_id as $book) {
            $books = Book::findOrFail($book);
            $books->users()->attach($user);
        }
        return $this->Response('add books', 'success', null, 200);

    }

}
