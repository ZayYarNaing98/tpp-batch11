<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBatchRequest;
use App\Models\Batch;
use App\Models\Instructor;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with('instructors')->get();

        return view('batches.index', [
            'data' => $batches
        ]);
    }

    public function create()
    {
        $instructors = Instructor::get();

        return view('batches.create', compact('instructors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required',
            'instructor_ids.*' => 'required|exists:instructors,id'
        ]);

        $batch = Batch::create($data);

        $batch->instructors()->sync($data['instructor_ids']);

        return redirect()->route('batches.index');
    }

    public function edit($id)
    {
        $batch = Batch::find($id);

        return view('batches.edit', compact('batch'));
    }

    public function update(UpdateBatchRequest $request)
    {
        $data = $request->validated();
        $batch = Batch::find($request->id);

        $batch->update($data);

        return redirect()->route('batches.index');
    }

    public function delete($id)
    {
        $batch = Batch::find($id);

        $batch->delete();

        return redirect()->route('batches.index');
    }
}
