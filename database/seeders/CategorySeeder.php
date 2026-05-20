<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'PHP',
            'Laravel',
            'NextJS',
            'ReactJS',
            'VueJS'
        ];

        foreach ($categories as $data) {
            Category::create(['name' => $data]);
        }
    }
}
