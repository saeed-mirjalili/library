<?php

namespace App\Http\Controllers\library;

use App\Http\ApiRequests\library\book\bookDeleteRequest;
use App\Http\ApiRequests\library\book\bookIndexRequest;
use App\Http\ApiRequests\library\book\bookShowRequest;
use App\Http\ApiRequests\library\book\bookStoreRequest;
use App\Http\ApiRequests\library\book\bookUpdateRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\library\bookResource;
use App\Models\library\Book;
use App\saeed\Facades\ApiResponse;
use App\Services\library\bookService;

class bookController extends Controller
{
    public function __construct(private bookService $bookService){}
    /**
     * Display a listing of the resource.
     */
    public function index(bookIndexRequest $authorize)
    {
        $result = $this->bookService->indexBook();

        if (isset($result->data['status'])) {
            return ApiResponse::withMessage($result->data['message'])->withStatus($result->data['status'])->build()->apiResponse();
        }

        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withData(bookResource::collection($result->data)->resource)->build()->apiResponse();
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
    public function show(Book $book, bookShowRequest $authorize)
    {
        $result = $this->bookService->showBook($book);

        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withData(new bookResource($result->data->load('author')->load('category')))->build()->apiResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Book $book, bookUpdateRequest $request)
    {

        $result = $this->bookService->updateBook($request->validated(), $book);

        if(!$result->ok)
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();

        return ApiResponse::withMessage('success')->withData(new bookResource(($result->data)->load('author')->load('category')))->build()->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book, bookDeleteRequest $authorize)
    {
        $result = $this->bookService->deleteBook($book);
        if (isset($result->data['status'])) {
            return ApiResponse::withMessage($result->data['message'])->withStatus($result->data['status'])->build()->apiResponse();
        }
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withMessage('The deletion was successful')->build()->apiResponse();
    }
}
