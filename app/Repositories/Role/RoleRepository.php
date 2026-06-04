<?php

namespace App\Repositories\Role;

use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function index()
    {
        return Role::with('permissions')->get();
    }

    public function show($id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function store($data, $permissions = [])
    {
        $role = Role::create($data);

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return $role;
    }

    public function update($id, $data, $permissions = [])
    {
        $role = Role::findOrFail($id);
        $role->update($data);
        $role->syncPermissions($permissions);

        return $role;
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);

        return $role->delete();
    }
}
