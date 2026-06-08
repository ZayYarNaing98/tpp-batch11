<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\UpdateBatchRequest;
use App\Repositories\Batch\BatchRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BatchController extends BaseController
{
    protected $batchRepository;
    public function __construct(BatchRepositoryInterface $batchRepository)
    {
        $this->batchRepository = $batchRepository;
    }

    public function index()
    {
        $batches = $this->batchRepository->index();

        return $this->success($batches, "Batch Retrieved Successfully.", 200);
    }

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

    public function show($id)
    {
        $batch = $this->batchRepository->show($id);

        if(!$batch){
            return $this->error(null, "Batch Not Found", 404);
        }

        return $this->success($batch, "Batch Show Successfully", 200);
    }

    public function update(UpdateBatchRequest $request, $id)
    {
        $batch = $this->batchRepository->show($id);

        if(!$batch){
            return $this->error(null, "Batch Not Found", 404);
        }

        $batch = $this->batchRepository->update($id, $request->validated());

        return $this->success($batch, "Batch Updated Successfully", 200);
    }

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
