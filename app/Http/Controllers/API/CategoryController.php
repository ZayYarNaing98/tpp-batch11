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
use OpenApi\Attributes as OA;

class CategoryController extends BaseController
{
    protected $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    #[OA\Get(
        path: '/api/categories',
        tags: ['Categories'],
        summary: 'List all categories',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Categories retrieved successfully'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index()
    {
        $categories = $this->categoryRepository->index();

        $data = CategoryResource::collection($categories);

        return $this->success($data, "Category Retrieved Scucessfully.", 200);
    }

    #[OA\Post(
        path: '/api/categories',
        tags: ['Categories'],
        summary: 'Create a new category',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Web Development'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Category created successfully'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
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

    #[OA\Get(
        path: '/api/categories/{id}',
        tags: ['Categories'],
        summary: 'Get a single category',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Category retrieved successfully'),
            new OA\Response(response: 404, description: 'Category not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function show($id)
    {
        $category = $this->categoryRepository->show($id);

        if(!$category){
            return $this->error(null, "Cateogry Not Found", 404);
        }

        $data = new CategoryResource($category);

        return $this->success($data, "Category Show Successfully", 200);
    }

    #[OA\Put(
        path: '/api/categories/{id}',
        tags: ['Categories'],
        summary: 'Update a category',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Mobile Development'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Category updated successfully'),
            new OA\Response(response: 404, description: 'Category not found'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryRepository->show($id);

        if(!$category){
            return $this->error(null, "Cateogry Not Found", 404);
        }

        $category->update($request->all());

        return $this->success($category, "Category Updated Successfully", 200);

    }

    #[OA\Delete(
        path: '/api/categories/{id}',
        tags: ['Categories'],
        summary: 'Delete a category',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Category deleted successfully'),
            new OA\Response(response: 404, description: 'Category not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
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
