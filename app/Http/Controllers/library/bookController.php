<?php

namespace App\Http\Controllers\library;

use App\Http\ApiRequests\library\bookStoreRequest;
use App\Http\ApiRequests\library\bookUpdateRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\library\bookResource;
use App\Models\library\Book;
use App\saeed\Facades\ApiResponse;
use App\Services\library\bookService;
use Illuminate\Support\Facades\Gate;

class bookController extends Controller
{
    public function __construct(private bookService $bookService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Gate::allows('exhibit'))
            abort(403);

        $books = Book::paginate(5);
        return ApiResponse::withData(bookResource::collection($books)->resource)->build()->apiResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(bookStoreRequest $request)
    {
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
    public function update(bookUpdateRequest $request, Book $book)
    {

        $result = $this->bookService->updateBook($request->validated(), $book);

        if(!$result->ok)
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();

        return ApiResponse::withMessage('success')->withData(new bookResource(($result->data)->load('author')->load('category')))->build()->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if (! Gate::allows('delete'))
            abort(403);

        $result = $this->bookService->deleteBook($book);
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withMessage('The deletion was successful')->build()->apiResponse();
    }
}
