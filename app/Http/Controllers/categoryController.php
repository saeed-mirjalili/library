<?php

namespace App\Http\Controllers;

use App\Http\Resources\categoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class categoryController extends mainController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::paginate(4);
        return $this->Response('list', 'success' ,[
            'data' => categoryResource::collection($category),
            'links' => categoryResource::collection($category)->response()->getData()->links,
            'meta' => categoryResource::collection($category)->response()->getData()->meta,
        ] ,200);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'description' => 'string'
        ]);
        if ($validator->fails()) {
            return $this->Response('Error',$validator->messages(),null,500);
        }
        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return $this->Response('create' , 'success' , new categoryResource($category), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->Response('show', 'success', new categoryResource($category->load('authors')
                                                                                ->load('books')), 200);
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
            return $this->Response('Error',$validator->messages(),null,500);
        }
        $category->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return $this->Response('update' , 'success' , new categoryResource($category), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category = $category->delete();
        return $this->Response('delete', 'success', $category,200);
    }
}
