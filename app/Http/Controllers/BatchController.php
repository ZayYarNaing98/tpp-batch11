<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBatchRequest;
use App\Repositories\Batch\BatchRepositoryInterface;
use App\Repositories\Instructor\InstructorRepositoryInterface;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function __construct(
        private BatchRepositoryInterface $batchRepository,
        private InstructorRepositoryInterface $instructorRepository,
    ) {}

    public function index()
    {
        $batches = $this->batchRepository->index();

        return view('batches.index', [
            'data' => $batches
        ]);
    }

    public function create()
    {
        $instructors = $this->instructorRepository->index();

        return view('batches.create', compact('instructors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string',
            'description'      => 'required|string',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date',
            'status'           => 'required',
            'instructor_ids.*' => 'required|exists:instructors,id'
        ]);

        $this->batchRepository->store($data);

        return redirect()->route('batches.index');
    }

    public function edit($id)
    {
        $batch = $this->batchRepository->show($id);

        return view('batches.edit', compact('batch'));
    }

    public function update(UpdateBatchRequest $request)
    {
        $this->batchRepository->update($request->id, $request->validated());

        return redirect()->route('batches.index');
    }

    public function delete($id)
    {
        $this->batchRepository->delete($id);

        return redirect()->route('batches.index');
    }
}
