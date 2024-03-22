<?php

namespace App\Http\Controllers;

use App\Http\Resources\bookResource;
use App\Models\Book;
use App\saeed\Facades\ApiResponse;
use App\Services\bookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class bookController extends Controller
{
    public function __construct(private bookService $bookService){}
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

        $result = $this->bookService->storeBook($request->all());

        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }

        return ApiResponse::withMessage('success')->withData(new bookResource($result->data))->build()->apiResponse();
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

        $result = $this->bookService->updateBook($validator->validated(), $book);

        if(!$result->ok)
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();

        return ApiResponse::withMessage('error')->withData(new bookResource(($result->data)->load('author')->load('category')))->build()->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $result = $this->bookService->deleteBook($book);
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withMessage('The deletion was successful')->build()->apiResponse();
    }
}
