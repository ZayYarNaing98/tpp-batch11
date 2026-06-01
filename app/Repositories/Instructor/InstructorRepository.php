<?php

namespace App\Repositories\Instructor;

use App\Models\Instructor;
use App\Repositories\Instructor\InstructorRepositoryInterface;

class InstructorRepository implements InstructorRepositoryInterface
{
    public function index()
    {
        return Instructor::get();
    }

    public function show($id)
    {
        return Instructor::find($id);
    }

    public function store($data)
    {
        return Instructor::create($data);
    }

    public function update($id, $data)
    {
        $instructor = Instructor::find($id);

        $instructor->update($data);

        return $instructor;
    }

    public function delete($id)
    {
        $instructor = Instructor::find($id);

        return $instructor->delete();
    }
}
