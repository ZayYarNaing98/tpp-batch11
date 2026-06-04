<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
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
}
