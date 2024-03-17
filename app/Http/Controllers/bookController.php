<?php

namespace App\Http\Controllers;

use App\Http\Resources\bookResource;
use App\Models\Book;
use App\saeed\Facades\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class bookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::paginate(5);
        return ApiResponse::withData(bookResource::collection($books))
        ->withAppends([
            'links' => bookResource::collection($books)->response()->getData()->links,
            'meta' => bookResource::collection($books)->response()->getData()->meta,
        ])->build()->apiResponse();
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
            return ApiResponse::withData($validator->messages())->withStatus(500)->build()->apiResponse();
        }

        // create name $ save image
        $bookName = md5(uniqid(rand(),true)).'.'. $request->book_url->extension();
        $request->book_url->storeAs('/books',$bookName,'public');
        // fix book path
        $input = $validator->validated();
        $input['book_url'] = $bookName;
        // create book
        $book = Book::create($input);

        return ApiResponse::withData(new bookResource($book))->build()->apiResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return ApiResponse::withData(new bookResource($book->load('author')->load('category')))->build()->apiResponse();
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
            return ApiResponse::withData($validator->messages())->withStatus(500)->build()->apiResponse();
        }

        $input = $validator->validated();

        if ($request->has('book_url')) {
            $bookName = md5(uniqid(rand(),true)).'.'. $request->book_url->extension();
            $request->book_url->storeAs('/books',$bookName,'public');
            $input['book_url'] = $bookName;
        }

        $book->update($input);

        return ApiResponse::withData(new bookResource($book->load('author')->load('category')))->build()->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $delete = $book->delete();
        return ApiResponse::withMessage('The deletion was successful')->build()->apiResponse();
    }
}
