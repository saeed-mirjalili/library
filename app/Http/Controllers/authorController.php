<?php

namespace App\Http\Controllers;

use App\Http\Resources\authorResource;
use App\Models\Author;
use App\saeed\Facades\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class authorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $author = Author::paginate(4);
        return ApiResponse::withData(authorResource::collection($author))
        ->withAppends([
            'links' => authorResource::collection($author)->response()->getData()->links,
            'meta' => authorResource::collection($author)->response()->getData()->meta,
        ])->build()->apiResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'categories.*' => 'numeric'
        ]);
        if ($validator->fails()) {
            return ApiResponse::withData($validator->messages())->withStatus(500)->build()->apiResponse();
        }

        $validated = $request->except('categories');
        $author = Author::create($validated);

        if ($request->has('categories')) {
            foreach($request->categories as $category){
                $author->categories()->attach($category);
            }
        }

        return ApiResponse::withData(new authorResource($author))->build()->apiResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return ApiResponse::withData(new authorResource($author->load('books')))->build()->apiResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'string',
            'categories.*' => 'numeric'
        ]);
        if ($validator->fails()) {
            return ApiResponse::withData($validator->messages())->withStatus(500)->build()->apiResponse();
        }

        if ($request->has('name')) {
            $author->update($request->except('categories'));
        }

        if ($request->has('categories')) {
            $author->categories()->sync($request->categories);
        }
        return ApiResponse::withData(new authorResource($author))->build()->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author = $author->delete();
        return ApiResponse::withMessage('The deletion was successful')->build()->apiResponse();
    }

}

