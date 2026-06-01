<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStudentRequest;
use App\Repositories\Batch\BatchRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(
        private StudentRepositoryInterface $studentRepository,
        private BatchRepositoryInterface $batchRepository,
    ) {}

    public function index()
    {
        $students = $this->studentRepository->index();

        return view('students.index', [
            'data' => $students
        ]);
    }

    public function create()
    {
        $batches = $this->batchRepository->index();

        return view('students.create', compact('batches'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'batch_id'    => 'nullable|exists:batches,id',
            'name'        => 'required|string',
            'email'       => 'required|email',
            'phone'       => 'required|string',
            'address'     => 'nullable|string',
            'enrolled_at' => 'nullable|date',
            'status'      => 'required|in:active,inactive,graduated',
            'image'       => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('studentImages'), $imageName);
            $data['image'] = $imageName;
        }

        $this->studentRepository->store($data);

        return redirect()->route('students.index');
    }

    public function edit($id)
    {
        $student = $this->studentRepository->show($id);
        $batches = $this->batchRepository->index();

        return view('students.edit', compact('student', 'batches'));
    }

    public function update(UpdateStudentRequest $request)
    {
        $data = [
            'batch_id'    => $request->batch_id,
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'address'     => $request->address,
            'enrolled_at' => $request->enrolled_at,
            'status'      => $request->status,
        ];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('studentImages'), $imageName);
            $data['image'] = $imageName;
        }

        $this->studentRepository->update($request->id, $data);

        return redirect()->route('students.index');
    }

    public function delete($id)
    {
        $this->studentRepository->delete($id);

        return redirect()->route('students.index');
    }
}
