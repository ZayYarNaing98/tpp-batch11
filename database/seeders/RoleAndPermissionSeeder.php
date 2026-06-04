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
        // Batch permissions
        $batchList   = Permission::firstOrCreate(['name' => 'batchList']);
        $batchCreate = Permission::firstOrCreate(['name' => 'batchCreate']);
        $batchUpdate = Permission::firstOrCreate(['name' => 'batchUpdate']);
        $batchDelete = Permission::firstOrCreate(['name' => 'batchDelete']);

        // Category permissions
        $categoryList   = Permission::firstOrCreate(['name' => 'categoryList']);
        $categoryCreate = Permission::firstOrCreate(['name' => 'categoryCreate']);
        $categoryUpdate = Permission::firstOrCreate(['name' => 'categoryUpdate']);
        $categoryDelete = Permission::firstOrCreate(['name' => 'categoryDelete']);

        // Student permissions
        $studentList   = Permission::firstOrCreate(['name' => 'studentList']);
        $studentCreate = Permission::firstOrCreate(['name' => 'studentCreate']);
        $studentUpdate = Permission::firstOrCreate(['name' => 'studentUpdate']);
        $studentDelete = Permission::firstOrCreate(['name' => 'studentDelete']);

        // Instructor permissions
        $instructorList   = Permission::firstOrCreate(['name' => 'instructorList']);
        $instructorCreate = Permission::firstOrCreate(['name' => 'instructorCreate']);
        $instructorUpdate = Permission::firstOrCreate(['name' => 'instructorUpdate']);
        $instructorDelete = Permission::firstOrCreate(['name' => 'instructorDelete']);

        // User permissions
        $userList   = Permission::firstOrCreate(['name' => 'userList']);
        $userCreate = Permission::firstOrCreate(['name' => 'userCreate']);
        $userUpdate = Permission::firstOrCreate(['name' => 'userUpdate']);
        $userDelete = Permission::firstOrCreate(['name' => 'userDelete']);

        // Role permissions
        $roleList   = Permission::firstOrCreate(['name' => 'roleList']);
        $roleCreate = Permission::firstOrCreate(['name' => 'roleCreate']);
        $roleUpdate = Permission::firstOrCreate(['name' => 'roleUpdate']);
        $roleDelete = Permission::firstOrCreate(['name' => 'roleDelete']);

        // Permission permissions
        $permissionList   = Permission::firstOrCreate(['name' => 'permissionList']);
        $permissionCreate = Permission::firstOrCreate(['name' => 'permissionCreate']);
        $permissionUpdate = Permission::firstOrCreate(['name' => 'permissionUpdate']);
        $permissionDelete = Permission::firstOrCreate(['name' => 'permissionDelete']);

        // Roles
        $admin      = Role::firstOrCreate(['name' => 'Admin']);
        $instructor = Role::firstOrCreate(['name' => 'Instructor']);
        $student    = Role::firstOrCreate(['name' => 'Student']);

        // Admin gets every permission
        $admin->syncPermissions(Permission::all());

        // Instructor manages batches
        $instructor->givePermissionTo([
            $batchList,
            $batchCreate,
            $batchUpdate,
            $batchDelete,
        ]);

        // Student can only view batches
        $student->givePermissionTo([
            $batchList,
        ]);
    }
}
