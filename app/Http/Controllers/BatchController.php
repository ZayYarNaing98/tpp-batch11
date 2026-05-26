<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBatchRequest;
use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::get();

        return view('batches.index', [
            'data' => $batches
        ]);
    }

    public function create()
    {
        return view('batches.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'name'        => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required',
        ]);
        // dd($data);

        Batch::create($data);

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
