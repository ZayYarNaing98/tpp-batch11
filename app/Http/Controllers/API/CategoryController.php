<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    public function index()
    {
        $categories = Category::get();

        return $this->success($categories, "Category Retrieved Scucessfully.", 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if($validator->fails())
        {
            return $this->error("Validation Error", $validator->errors(), 422);
        }

        $category = Category::create([
            'name' => $request->name
        ]);

        return $this->success($category, "Category Created Successfully", 201);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if(!$category){
            return $this->error(null, "Cateogry Not Found", 404);
        }

        return $this->success($category, "Category Show Successfully", 200);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if(!$category){
            return $this->error(null, "Cateogry Not Found", 404);
        }

        $category->update($request->all());

        return $this->success($category, "Category Updated Successfully", 200);

    }

    public function delete($id)
    {
        $category = Category::find($id);

        if(!$category)
        {
            return $this->error(null, "Cateogry Not Found", 404);
        }

        $category->delete();

        return $this->success($category, "Category Deleted Successfully", 200);
    }
}
