<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructor = Role::create(['name' => 'Instructor']);
        $student = Role::create(['name' => 'Student']);

        $batchList = Permission::create(['name' => 'batchList']);
        $batchCreate = Permission::create(['name' => 'batchCreate']);
        $batchUpdate = Permission::create(['name' => 'batchUpdate']);
        $batchDelete = Permission::create(['name' => 'batchDelete']);


        $instructor->givePermissionTo([
            $batchList,
            $batchCreate,
            $batchUpdate,
            $batchDelete
        ]);

        $student->givePermissionTo([
            $batchList
        ]);
    }
}
