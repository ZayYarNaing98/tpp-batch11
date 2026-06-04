<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => "admin@mail.com"],
            ['name' => "Admin", 'password' => Hash::make('password')]
        );

        $john = User::firstOrCreate(
            ['email' => "john@mail.com"],
            ['name' => "John", 'password' => Hash::make('password')]
        );

        $marry = User::firstOrCreate(
            ['email' => "marry@mail.com"],
            ['name' => "Marry", 'password' => Hash::make('password')]
        );

        $admin->assignRole('Admin');
        $john->assignRole('Instructor');
        $marry->assignRole('Student');
    }
}
