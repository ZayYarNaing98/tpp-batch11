<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Repositories\Student\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    public function index()
    {
        return Student::with('batch')->get();
    }

    public function show($id)
    {
        return Student::find($id);
    }

    public function store($data)
    {
        return Student::create($data);
    }

    public function update($id, $data)
    {
        $student = Student::find($id);

        $student->update($data);

        return $student;
    }

    public function delete($id)
    {
        $student = Student::find($id);

        return $student->delete();
    }
}
