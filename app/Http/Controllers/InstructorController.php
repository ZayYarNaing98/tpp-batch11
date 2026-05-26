<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInstructorRequest;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::get();

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

        Instructor::create($data);

        return redirect()->route('instructors.index');
    }

    public function edit($id)
    {
        $instructor = Instructor::find($id);

        return view('instructors.edit', compact('instructor'));
    }

    public function update(UpdateInstructorRequest $request, $id)
    {
        $instructor = Instructor::find($id);

        $instructor->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('instructors.index');
    }

    public function delete($id)
    {
        $instructor = Instructor::find($id);

        $instructor->delete();

        return redirect()->route('instructors.index');
    }
}
