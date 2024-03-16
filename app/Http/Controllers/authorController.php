<?php

namespace App\Http\Controllers;

use App\Http\Resources\authorResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class authorController extends mainController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $author = Author::paginate(4);
        return $this->Response('list', 'success' ,[
            'data' => authorResource::collection($author),
            'links' => authorResource::collection($author)->response()->getData()->links,
            'meta' => authorResource::collection($author)->response()->getData()->meta,
        ] ,200);
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
            return $this->Response('Error',$validator->messages(),null,500);
        }

        $validated = $request->except('categories');
        $author = Author::create($validated);

        if ($request->has('categories')) {
            foreach($request->categories as $category){
                $author->categories()->attach($category);
            }
        }


        return $this->Response('create' , 'success' , new authorResource($author), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return $this->Response('show', 'success', new authorResource($author->load('books')), 200);
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
            return $this->Response('Error',$validator->messages(),null,500);
        }

        if ($request->has('name')) {
            $author->update($request->except('categories'));
        }

        if ($request->has('categories')) {
            $author->categories()->sync($request->categories);
        }
        return $this->Response('update' , 'success' , new authorResource($author), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author = $author->delete();
        return $this->Response('delete', 'success', $author,200);
    }
}
