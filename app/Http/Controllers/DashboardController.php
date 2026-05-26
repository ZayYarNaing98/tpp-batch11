<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Category;
use App\Models\Instructor;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalStudents'    => Student::count(),
            'totalBatches'     => Batch::count(),
            'totalCategories'  => Category::count(),
            'totalInstructors' => Instructor::count(),
            'recentBatches'    => Batch::latest()->take(5)->get(),
            'recentStudents'   => Student::latest()->take(5)->get(),
        ]);
    }
}
