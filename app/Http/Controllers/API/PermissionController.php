<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends BaseController
{
    protected $permissionRepository;
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index()
    {
        $permissions = $this->permissionRepository->index();

        return $this->success($permissions, "Permission Retrieved Successfully.", 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permissions,name',
        ]);

        if($validator->fails())
        {
            return $this->error("Validation Error", $validator->errors(), 422);
        }

        $permission = $this->permissionRepository->store([
            'name'       => $request->name,
            'guard_name' => 'web',
        ]);

        return $this->success($permission, "Permission Created Successfully", 201);
    }

    public function show($id)
    {
        $permission = $this->permissionRepository->show($id);

        if(!$permission){
            return $this->error(null, "Permission Not Found", 404);
        }

        return $this->success($permission, "Permission Show Successfully", 200);
    }

    public function update(Request $request, $id)
    {
        $permission = $this->permissionRepository->show($id);

        if(!$permission){
            return $this->error(null, "Permission Not Found", 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permissions,name,' . $id,
        ]);

        if($validator->fails())
        {
            return $this->error("Validation Error", $validator->errors(), 422);
        }

        $permission = $this->permissionRepository->update($id, ['name' => $request->name]);

        return $this->success($permission, "Permission Updated Successfully", 200);
    }

    public function delete($id)
    {
        $permission = $this->permissionRepository->show($id);

        if(!$permission)
        {
            return $this->error(null, "Permission Not Found", 404);
        }

        $this->permissionRepository->delete($id);

        return $this->success($permission, "Permission Deleted Successfully", 200);
    }
}
