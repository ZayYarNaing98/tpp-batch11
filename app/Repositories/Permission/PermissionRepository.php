<?php

namespace App\Repositories\Permission;

use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function index()
    {
        return Permission::all();
    }

    public function show($id)
    {
        return Permission::findOrFail($id);
    }

    public function store($data)
    {
        return Permission::create($data);
    }

    public function update($id, $data)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($data);

        return $permission;
    }

    public function delete($id)
    {
        $permission = Permission::findOrFail($id);

        return $permission->delete();
    }
}
