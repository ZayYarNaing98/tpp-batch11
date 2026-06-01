<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInstructorRequest;
use App\Repositories\Instructor\InstructorRepositoryInterface;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function __construct(
        private InstructorRepositoryInterface $instructorRepository,
    ) {}

    public function index()
    {
        $instructors = $this->instructorRepository->index();

        return view('instructors.index', [
            'data' => $instructors,
        ]);
    }

    public function create()
    {
        return view('instructors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email|unique:instructors,email',
            'phone' => 'required|string',
        ]);

        $this->instructorRepository->store($data);

        return redirect()->route('instructors.index');
    }

    public function edit($id)
    {
        $instructor = $this->instructorRepository->show($id);

        return view('instructors.edit', compact('instructor'));
    }

    public function update(UpdateInstructorRequest $request, $id)
    {
        $this->instructorRepository->update($id, [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('instructors.index');
    }

    public function delete($id)
    {
        $this->instructorRepository->delete($id);

        return redirect()->route('instructors.index');
    }
}
