<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\UpdateStudentRequest;
use App\Repositories\Student\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class StudentController extends BaseController
{
    protected $studentRepository;
    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    #[OA\Get(
        path: '/api/students',
        tags: ['Students'],
        summary: 'List all students',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Students retrieved successfully'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index()
    {
        $students = $this->studentRepository->index();

        return $this->success($students, "Student Retrieved Successfully.", 200);
    }

    #[OA\Post(
        path: '/api/students',
        tags: ['Students'],
        summary: 'Create a new student',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'phone', 'status'],
                properties: [
                    new OA\Property(property: 'batch_id', type: 'integer', example: 1),
                    new OA\Property(property: 'name', type: 'string', example: 'Jane Doe'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'jane@example.com'),
                    new OA\Property(property: 'phone', type: 'string', example: '+959123456789'),
                    new OA\Property(property: 'address', type: 'string', example: 'Yangon, Myanmar'),
                    new OA\Property(property: 'enrolled_at', type: 'string', format: 'date', example: '2026-01-01'),
                    new OA\Property(property: 'status', type: 'string', enum: ['active', 'inactive', 'graduated'], example: 'active'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Student created successfully'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'batch_id'    => 'nullable|exists:batches,id',
            'name'        => 'required|string',
            'email'       => 'required|email',
            'phone'       => 'required|string',
            'address'     => 'nullable|string',
            'enrolled_at' => 'nullable|date',
            'status'      => 'required|in:active,inactive,graduated',
        ]);

        if($validator->fails())
        {
            return $this->error("Validation Error", $validator->errors(), 422);
        }

        $student = $this->studentRepository->store($request->all());

        return $this->success($student, "Student Created Successfully", 201);
    }

    #[OA\Get(
        path: '/api/students/{id}',
        tags: ['Students'],
        summary: 'Get a single student',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Student retrieved successfully'),
            new OA\Response(response: 404, description: 'Student not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function show($id)
    {
        $student = $this->studentRepository->show($id);

        if(!$student){
            return $this->error(null, "Student Not Found", 404);
        }

        return $this->success($student, "Student Show Successfully", 200);
    }

    #[OA\Put(
        path: '/api/students/{id}',
        tags: ['Students'],
        summary: 'Update a student',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'batch_id', type: 'integer', example: 1),
                    new OA\Property(property: 'name', type: 'string', example: 'Jane Doe'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'jane@example.com'),
                    new OA\Property(property: 'phone', type: 'string', example: '+959123456789'),
                    new OA\Property(property: 'address', type: 'string', example: 'Yangon, Myanmar'),
                    new OA\Property(property: 'enrolled_at', type: 'string', format: 'date', example: '2026-01-01'),
                    new OA\Property(property: 'status', type: 'string', enum: ['active', 'inactive', 'graduated'], example: 'active'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Student updated successfully'),
            new OA\Response(response: 404, description: 'Student not found'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function update(UpdateStudentRequest $request, $id)
    {
        $student = $this->studentRepository->show($id);

        if(!$student){
            return $this->error(null, "Student Not Found", 404);
        }

        $student = $this->studentRepository->update($id, $request->validated());

        return $this->success($student, "Student Updated Successfully", 200);
    }

    #[OA\Delete(
        path: '/api/students/{id}',
        tags: ['Students'],
        summary: 'Delete a student',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Student deleted successfully'),
            new OA\Response(response: 404, description: 'Student not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function delete($id)
    {
        $student = $this->studentRepository->show($id);

        if(!$student)
        {
            return $this->error(null, "Student Not Found", 404);
        }

        $this->studentRepository->delete($id);

        return $this->success($student, "Student Deleted Successfully", 200);
    }
}
