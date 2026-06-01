<?php

namespace App\Repositories\Batch;

use App\Models\Batch;
use App\Repositories\Batch\BatchRepositoryInterface;

class BatchRepository implements BatchRepositoryInterface
{
    public function index()
    {
        return Batch::with('instructors')->get();
    }

    public function show($id)
    {
        return Batch::find($id);
    }

    public function store($data)
    {
        $batch = Batch::create($data);

        if (isset($data['instructor_ids'])) {
            $batch->instructors()->sync($data['instructor_ids']);
        }

        return $batch;
    }

    public function update($id, $data)
    {
        $batch = Batch::find($id);

        $batch->update($data);

        return $batch;
    }

    public function delete($id)
    {
        $batch = Batch::find($id);

        return $batch->delete();
    }
}
