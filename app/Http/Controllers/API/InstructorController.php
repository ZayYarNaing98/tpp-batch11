<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\UpdateInstructorRequest;
use App\Repositories\Instructor\InstructorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class InstructorController extends BaseController
{
    protected $instructorRepository;
    public function __construct(InstructorRepositoryInterface $instructorRepository)
    {
        $this->instructorRepository = $instructorRepository;
    }

    #[OA\Get(
        path: '/api/instructors',
        tags: ['Instructors'],
        summary: 'List all instructors',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Instructors retrieved successfully'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index()
    {
        $instructors = $this->instructorRepository->index();

        return $this->success($instructors, "Instructor Retrieved Successfully.", 200);
    }

    #[OA\Post(
        path: '/api/instructors',
        tags: ['Instructors'],
        summary: 'Create a new instructor',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'phone'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'john@example.com'),
                    new OA\Property(property: 'phone', type: 'string', example: '+959123456789'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Instructor created successfully'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string',
            'email' => 'required|email|unique:instructors,email',
            'phone' => 'required|string',
        ]);

        if($validator->fails())
        {
            return $this->error("Validation Error", $validator->errors(), 422);
        }

        $instructor = $this->instructorRepository->store($request->all());

        return $this->success($instructor, "Instructor Created Successfully", 201);
    }

    #[OA\Get(
        path: '/api/instructors/{id}',
        tags: ['Instructors'],
        summary: 'Get a single instructor',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Instructor retrieved successfully'),
            new OA\Response(response: 404, description: 'Instructor not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function show($id)
    {
        $instructor = $this->instructorRepository->show($id);

        if(!$instructor){
            return $this->error(null, "Instructor Not Found", 404);
        }

        return $this->success($instructor, "Instructor Show Successfully", 200);
    }

    #[OA\Put(
        path: '/api/instructors/{id}',
        tags: ['Instructors'],
        summary: 'Update an instructor',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'john@example.com'),
                    new OA\Property(property: 'phone', type: 'string', example: '+959123456789'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Instructor updated successfully'),
            new OA\Response(response: 404, description: 'Instructor not found'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function update(UpdateInstructorRequest $request, $id)
    {
        $instructor = $this->instructorRepository->show($id);

        if(!$instructor){
            return $this->error(null, "Instructor Not Found", 404);
        }

        $instructor = $this->instructorRepository->update($id, $request->validated());

        return $this->success($instructor, "Instructor Updated Successfully", 200);
    }

    #[OA\Delete(
        path: '/api/instructors/{id}',
        tags: ['Instructors'],
        summary: 'Delete an instructor',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Instructor deleted successfully'),
            new OA\Response(response: 404, description: 'Instructor not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function delete($id)
    {
        $instructor = $this->instructorRepository->show($id);

        if(!$instructor)
        {
            return $this->error(null, "Instructor Not Found", 404);
        }

        $this->instructorRepository->delete($id);

        return $this->success($instructor, "Instructor Deleted Successfully", 200);
    }
}
