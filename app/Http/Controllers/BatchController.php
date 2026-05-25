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
        $data = $request->validate([
            'name'        => 'required|string',
            'description' => 'required|string',
        ]);

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
        $batch = Batch::find($request->id);

        $batch->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('batches.index');
    }

    public function delete($id)
    {
        $batch = Batch::find($id);

        $batch->delete();

        return redirect()->route('batches.index');
    }
}
