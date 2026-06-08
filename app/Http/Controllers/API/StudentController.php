<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\UpdateStudentRequest;
use App\Repositories\Student\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends BaseController
{
    protected $studentRepository;
    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function index()
    {
        $students = $this->studentRepository->index();

        return $this->success($students, "Student Retrieved Successfully.", 200);
    }

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

    public function show($id)
    {
        $student = $this->studentRepository->show($id);

        if(!$student){
            return $this->error(null, "Student Not Found", 404);
        }

        return $this->success($student, "Student Show Successfully", 200);
    }

    public function update(UpdateStudentRequest $request, $id)
    {
        $student = $this->studentRepository->show($id);

        if(!$student){
            return $this->error(null, "Student Not Found", 404);
        }

        $student = $this->studentRepository->update($id, $request->validated());

        return $this->success($student, "Student Updated Successfully", 200);
    }

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
