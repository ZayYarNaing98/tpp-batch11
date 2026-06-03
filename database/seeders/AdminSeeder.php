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
        $john = User::create([
            'name' => "John",
            'email' => "john@mail.com",
            'password' => Hash::make('password'),
        ]);

        $marry = User::create([
            'name' => "Marry",
            'email' => "marry@mail.com",
            'password' => Hash::make('password'),
        ]);

        $john->assignRole('Instructor');
        $marry->assignRole('Student');
    }
}
