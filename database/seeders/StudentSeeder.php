<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'name'    => 'Aung Aung',
                'email'   => 'aung@mail.com',
                'phone'   => '09111111111',
                'address' => 'Yangon',
            ],
            [
                'name'    => 'Su Su',
                'email'   => 'susu@mail.com',
                'phone'   => '09222222222',
                'address' => 'Mandalay',
            ],
            [
                'name'    => 'Kyaw Kyaw',
                'email'   => 'kyaw@mail.com',
                'phone'   => '09333333333',
                'address' => 'Naypyidaw',
            ],
            [
                'name'    => 'Nyi Nyi',
                'email'   => 'nyinyi@mail.com',
                'phone'   => '09444444444',
                'address' => 'Bago',
            ],
            [
                'name'    => 'Hnin Hnin',
                'email'   => 'hnin@mail.com',
                'phone'   => '09555555555',
                'address' => null,
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
