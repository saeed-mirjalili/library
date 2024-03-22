<?php

namespace App\Http\Controllers;

use App\Http\Resources\categoryResource;
use App\Models\Category;
use App\saeed\Facades\ApiResponse;
use App\Services\categoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class categoryController extends Controller
{
    public function __construct(private categoryService $categoryService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::paginate(4);
        return ApiResponse::withMessage('list')->withData([
            'data' => categoryResource::collection($category),
            'links' => categoryResource::collection($category)->response()->getData()->links,
            'meta' => categoryResource::collection($category)->response()->getData()->meta,
            ])->build()->apiResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'description' => 'required|string'
        ]);
        if ($validator->fails()) {
            return ApiResponse::withData($validator->messages())->withStatus(500)->build()->apiResponse();
        }

        $result = $this->categoryService->storeCategory($validator->validated());

        if(!$result->ok)
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();

        return ApiResponse::withMessage('success')->withData(new categoryResource($result->data))->build()->apiResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return  ApiResponse::withMessage('show')->withData(new categoryResource($category->load('authors')->load('books')))->build()->apiResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'description' => 'string'
        ]);
        if ($validator->fails()) {
            return  ApiResponse::withData($validator->messages())->withStatus(500)->build()->apiResponse();
        }

        $result = $this->categoryService->updateCategory($validator->validated(), $category);

        if(!$result->ok)
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();

        return  ApiResponse::withMessage('update')->withData(new categoryResource($category))->build()->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $result = $this->categoryService->deleteCategory($category);
        if(!$result->ok)
            return ApiResponse::withMessage('delete')->withData($result->data)->build()->apiResponse();
        return ApiResponse::withMessage('delete')->withData($result->data)->build()->apiResponse();
    }
}
