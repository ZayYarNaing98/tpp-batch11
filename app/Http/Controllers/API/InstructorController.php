<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\UpdateInstructorRequest;
use App\Repositories\Instructor\InstructorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstructorController extends BaseController
{
    protected $instructorRepository;
    public function __construct(InstructorRepositoryInterface $instructorRepository)
    {
        $this->instructorRepository = $instructorRepository;
    }

    public function index()
    {
        $instructors = $this->instructorRepository->index();

        return $this->success($instructors, "Instructor Retrieved Successfully.", 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string',
            'email' => 'required|email|unique:instructors,email',
            'phone' => 'required|string',
        ]);

        if($validator->fails())
        {
            return $this->error("Validation Error", $validator->errors(), 422);
        }

        $instructor = $this->instructorRepository->store($request->all());

        return $this->success($instructor, "Instructor Created Successfully", 201);
    }

    public function show($id)
    {
        $instructor = $this->instructorRepository->show($id);

        if(!$instructor){
            return $this->error(null, "Instructor Not Found", 404);
        }

        return $this->success($instructor, "Instructor Show Successfully", 200);
    }

    public function update(UpdateInstructorRequest $request, $id)
    {
        $instructor = $this->instructorRepository->show($id);

        if(!$instructor){
            return $this->error(null, "Instructor Not Found", 404);
        }

        $instructor = $this->instructorRepository->update($id, $request->validated());

        return $this->success($instructor, "Instructor Updated Successfully", 200);
    }

    public function delete($id)
    {
        $instructor = $this->instructorRepository->show($id);

        if(!$instructor)
        {
            return $this->error(null, "Instructor Not Found", 404);
        }

        $this->instructorRepository->delete($id);

        return $this->success($instructor, "Instructor Deleted Successfully", 200);
    }
}
