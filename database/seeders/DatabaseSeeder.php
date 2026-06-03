<?php

namespace Database\Seeders;

use Database\Seeders\AdminSeeder;
use Database\Seeders\BatchSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\InstructorSeeder;
use Database\Seeders\StudentSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(InstructorSeeder::class);
        $this->call(BatchSeeder::class);
        $this->call(StudentSeeder::class);
    }
}
