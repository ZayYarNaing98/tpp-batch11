<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\UpdateBatchRequest;
use App\Repositories\Batch\BatchRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class BatchController extends BaseController
{
    protected $batchRepository;
    public function __construct(BatchRepositoryInterface $batchRepository)
    {
        $this->batchRepository = $batchRepository;
    }

    #[OA\Get(
        path: '/api/batches',
        tags: ['Batches'],
        summary: 'List all batches',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Batches retrieved successfully'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index()
    {
        $batches = $this->batchRepository->index();

        return $this->success($batches, "Batch Retrieved Successfully.", 200);
    }

    #[OA\Post(
        path: '/api/batches',
        tags: ['Batches'],
        summary: 'Create a new batch',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'description', 'start_date', 'end_date', 'status'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Batch 11'),
                    new OA\Property(property: 'description', type: 'string', example: 'Full-stack web development batch'),
                    new OA\Property(property: 'start_date', type: 'string', format: 'date', example: '2026-01-01'),
                    new OA\Property(property: 'end_date', type: 'string', format: 'date', example: '2026-06-30'),
                    new OA\Property(property: 'status', type: 'string', enum: ['upcoming', 'ongoing', 'complete'], example: 'upcoming'),
                    new OA\Property(property: 'instructor_ids', type: 'array', items: new OA\Items(type: 'integer'), example: [1, 2]),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Batch created successfully'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|string',
            'description'    => 'required|string',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date',
            'status'         => 'required|in:upcoming,ongoing,complete',
            'instructor_ids' => 'nullable|array',
            'instructor_ids.*' => 'exists:instructors,id',
        ]);

        if($validator->fails())
        {
            return $this->error("Validation Error", $validator->errors(), 422);
        }

        $batch = $this->batchRepository->store($request->all());

        return $this->success($batch, "Batch Created Successfully", 201);
    }

    #[OA\Get(
        path: '/api/batches/{id}',
        tags: ['Batches'],
        summary: 'Get a single batch',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Batch retrieved successfully'),
            new OA\Response(response: 404, description: 'Batch not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function show($id)
    {
        $batch = $this->batchRepository->show($id);

        if(!$batch){
            return $this->error(null, "Batch Not Found", 404);
        }

        return $this->success($batch, "Batch Show Successfully", 200);
    }

    #[OA\Put(
        path: '/api/batches/{id}',
        tags: ['Batches'],
        summary: 'Update a batch',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Batch 11'),
                    new OA\Property(property: 'description', type: 'string', example: 'Full-stack web development batch'),
                    new OA\Property(property: 'start_date', type: 'string', format: 'date', example: '2026-01-01'),
                    new OA\Property(property: 'end_date', type: 'string', format: 'date', example: '2026-06-30'),
                    new OA\Property(property: 'status', type: 'string', enum: ['upcoming', 'ongoing', 'complete'], example: 'ongoing'),
                    new OA\Property(property: 'instructor_ids', type: 'array', items: new OA\Items(type: 'integer'), example: [1, 2]),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Batch updated successfully'),
            new OA\Response(response: 404, description: 'Batch not found'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function update(UpdateBatchRequest $request, $id)
    {
        $batch = $this->batchRepository->show($id);

        if(!$batch){
            return $this->error(null, "Batch Not Found", 404);
        }

        $batch = $this->batchRepository->update($id, $request->validated());

        return $this->success($batch, "Batch Updated Successfully", 200);
    }

    #[OA\Delete(
        path: '/api/batches/{id}',
        tags: ['Batches'],
        summary: 'Delete a batch',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Batch deleted successfully'),
            new OA\Response(response: 404, description: 'Batch not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function delete($id)
    {
        $batch = $this->batchRepository->show($id);

        if(!$batch)
        {
            return $this->error(null, "Batch Not Found", 404);
        }

        $this->batchRepository->delete($id);

        return $this->success($batch, "Batch Deleted Successfully", 200);
    }
}
