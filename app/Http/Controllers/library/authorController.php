<?php

namespace App\Http\Controllers\library;

use App\Http\ApiRequests\library\author\authorDeleteRequest;
use App\Http\ApiRequests\library\author\authorIndexRequest;
use App\Http\ApiRequests\library\author\authorShowRequest;
use App\Http\ApiRequests\library\author\authorStoreRequest;
use App\Http\ApiRequests\library\author\authorUpdateRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\library\authorResource;
use App\Models\library\Author;
use App\saeed\Facades\ApiResponse;
use App\Services\library\authorService;

class authorController extends Controller
{
    public function __construct(private authorService $authorService){}
    /**
     * Display a listing of the resource.
     */
    public function index(authorIndexRequest $authorize)
    {
        $result = $this->authorService->indexAuthor();
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withData(authorResource::collection($result->data)->resource)->build()->apiResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(authorStoreRequest $request)
    {

        $result = $this->authorService->storeAuthor($request);

        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }

        return ApiResponse::withMessage('success')->withData(new authorResource($result->data))->build()->apiResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author, authorShowRequest $authorize)
    {
        $result = $this->authorService->showAuthor($author);

        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withData(new authorResource($result->data->load('books')))->build()->apiResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Author $author, authorUpdateRequest $request)
    {

        $result = $this->authorService->updateAuthor($request, $author);

        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withMessage('update')->withData(new authorResource($author))->build()->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author, authorDeleteRequest $authorize)
    {
        $result = $this->authorService->deleteAuthor($author);

        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withMessage('The deletion was successful')->build()->apiResponse();
    }

}

