<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Category;
use App\Models\Instructor;
use App\Models\Student;
use App\Services\BatchService;
use App\Services\StudentService;

class DashboardController extends Controller
{

    protected $studentService;
    protected $batchService;
    public function __construct(StudentService $studentService, BatchService $batchService)
    {
        $this->studentService = $studentService;
        $this->batchService = $batchService;
    }

    public function index()
    {

        $studentTotal = $this->studentService->studentTotal();

        $batchTotal = $this->batchService->batchTotal();
        return view('dashboard', [
            'totalStudents'    => $studentTotal,
            'totalBatches'     => $batchTotal,
            'totalCategories'  => Category::count(),
            'totalInstructors' => Instructor::count(),
            'recentBatches'    => Batch::latest()->take(5)->get(),
            'recentStudents'   => Student::latest()->take(5)->get(),
        ]);
    }
}
