<?php

namespace App\Services;

use App\Repositories\Student\StudentRepositoryInterface;

class StudentService
{
    protected $studentRepository;
    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }


    public function studentTotal()
    {
        $students = $this->studentRepository->index();

        return $students->count();
    }
}
