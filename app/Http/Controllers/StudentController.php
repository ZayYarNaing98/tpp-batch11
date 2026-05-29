<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStudentRequest;
use App\Models\Batch;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('batch')->get();

        return view('students.index', [
            'data' => $students
        ]);
    }

    public function create()
    {
        $batches = Batch::get();

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
            $data = array_merge($data, ['image' => $imageName]);
        }

        Student::create($data);

        return redirect()->route('students.index');
    }

    public function edit($id)
    {
        $student = Student::find($id);
        $batches = Batch::get();

        return view('students.edit', compact('student', 'batches'));
    }

    public function update(UpdateStudentRequest $request)
    {
        $student = Student::find($request->id);

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

        $student->update($data);

        return redirect()->route('students.index');
    }

    public function delete($id)
    {
        $student = Student::find($id);

        $student->delete();

        return redirect()->route('students.index');
    }
}
