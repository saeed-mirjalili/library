<?php

namespace App\Http\Controllers\library;

use App\Http\ApiRequests\library\category\categoryDeleteRequest;
use App\Http\ApiRequests\library\category\categoryIndexRequest;
use App\Http\ApiRequests\library\category\categoryShowRequest;
use App\Http\ApiRequests\library\category\categoryStoreRequest;
use App\Http\ApiRequests\library\category\categoryUpdateRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\library\categoryResource;
use App\Models\library\Category;
use App\saeed\Facades\ApiResponse;
use App\Services\library\categoryService;

class categoryController extends Controller
{
    public function __construct(private categoryService $categoryService){}
    /**
     * Display a listing of the resource.
     */
    public function index(categoryIndexRequest $authorize)
    {
        $result = $this->categoryService->indexCategory();
        return ApiResponse::withMessage('list')->withData(categoryResource::collection($result->data)->resource)->build()->apiResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(categoryStoreRequest $request)
    {

        $result = $this->categoryService->storeCategory($request->validated());

        if(!$result->ok)
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();

        return ApiResponse::withMessage('success')->withData(new categoryResource($result->data))->build()->apiResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, categoryShowRequest $authorize)
    {
        $result = $this->categoryService->showCategory($category);
        return  ApiResponse::withMessage('show')->withData(new categoryResource($result->data->load('authors')->load('books')))->build()->apiResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Category $category, categoryUpdateRequest $request)
    {
        $result = $this->categoryService->updateCategory($request->validated(), $category);

        if(!$result->ok)
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();

        return  ApiResponse::withMessage('update')->withData(new categoryResource($category))->build()->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, categoryDeleteRequest $authorize)
    {
        $result = $this->categoryService->deleteCategory($category);
        if(!$result->ok)
            return ApiResponse::withMessage('delete')->withData($result->data)->build()->apiResponse();
        return ApiResponse::withMessage('delete')->withData($result->data)->build()->apiResponse();
    }
}
