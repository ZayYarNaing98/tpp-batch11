<?php

namespace Database\Seeders;

use App\Models\Instructor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    public function run(): void
    {
        $instructors = [
            [
                'name'  => 'Ko Zaw',
                'email' => 'kozaw@mail.com',
                'phone' => '09100000001',
            ],
            [
                'name'  => 'Ma Myat',
                'email' => 'mamyat@mail.com',
                'phone' => '09100000002',
            ],
            [
                'name'  => 'Ko Thurein',
                'email' => 'thurein@mail.com',
                'phone' => '09100000003',
            ],
        ];

        foreach ($instructors as $instructor) {
            Instructor::create($instructor);
        }
    }
}
