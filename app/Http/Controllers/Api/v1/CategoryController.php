<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CategoryController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:api', ['except' => []]);
    }
    /**
     * Response all data
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $categories = Category::all();
        return response()->json([
            'message' => 'success',
            'categories' => $categories
        ], 200);
    }

    /**
     * Response one data by id
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getById(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);
        return response()->json([
            'message' => 'success',
            'category' => $category
        ], 200);
    }

    /**
     * Create new data
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:1,100',
            'description' => 'required|string|max:1000',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $category = Category::create(array_merge(
            $validator->validated(),
        ));
        return response()->json([
            'message' => 'Category successfully registered',
            'category' => $category
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Update Category
        $request->validate([
            'name' => 'required|string|between:1,100',
            'description' => 'required|string|max:1000',
        ]);
        $category = Category::find($request->id);
        $category -> update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json([
            'message' => 'Category successfully updated',
            'category' => $category
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $categoryId)
    {
        //delete Category
        $category = Category::find($categoryId);
        $category -> delete();
        $categories = Category::all();
        return response()->json([
            'message' => 'successfully deleted',
            'categories' => $categories
        ], 200);
    }
}
