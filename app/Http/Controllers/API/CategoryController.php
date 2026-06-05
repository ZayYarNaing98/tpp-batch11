<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    protected $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->index();

        $data = CategoryResource::collection($categories);

        return $this->success($data, "Category Retrieved Scucessfully.", 200);
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

        $category = $this->categoryRepository->store([
            'name' => $request->name
        ]);

        return $this->success($category, "Category Created Successfully", 201);
    }

    public function show($id)
    {
        $category = $this->categoryRepository->show($id);

        if(!$category){
            return $this->error(null, "Cateogry Not Found", 404);
        }

        $data = new CategoryResource($category);

        return $this->success($data, "Category Show Successfully", 200);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryRepository->show($id);

        if(!$category){
            return $this->error(null, "Cateogry Not Found", 404);
        }

        $category->update($request->all());

        return $this->success($category, "Category Updated Successfully", 200);

    }

    public function delete($id)
    {
        $category = $this->categoryRepository->show($id);

        if(!$category)
        {
            return $this->error(null, "Cateogry Not Found", 404);
        }

        $category->delete();

        return $this->success($category, "Category Deleted Successfully", 200);
    }
}
