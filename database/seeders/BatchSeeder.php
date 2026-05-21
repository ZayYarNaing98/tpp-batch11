<?php

namespace Database\Seeders;

use App\Models\Batch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batches = [
            [
                'name' => "Batch 1",
                'description' => "This is batch one."
            ],
            [
                'name' => "Batch 2",
                'description' => "This is batch two."
            ],
            [
                'name' => "Batch 3",
                'description' => "This is batch three."
            ],
            [
                'name' => "Batch 4",
                'description' => "This is batch four."
            ],
            [
                'name' => "Batch 5",
                'description' => "This is batch five."
            ],
        ];

        foreach($batches as $batch)
        {
            Batch::create($batch);
        }
    }
}
