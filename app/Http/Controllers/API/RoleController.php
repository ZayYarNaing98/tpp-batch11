<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends BaseController
{
    protected $roleRepository;
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->index();

        return $this->success($roles, "Role Retrieved Successfully.", 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|unique:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        if($validator->fails())
        {
            return $this->error("Validation Error", $validator->errors(), 422);
        }

        $role = $this->roleRepository->store(
            ['name' => $request->name, 'guard_name' => 'web'],
            $request->permissions ?? []
        );

        return $this->success($role, "Role Created Successfully", 201);
    }

    public function show($id)
    {
        $role = $this->roleRepository->show($id);

        if(!$role){
            return $this->error(null, "Role Not Found", 404);
        }

        return $this->success($role, "Role Show Successfully", 200);
    }

    public function update(Request $request, $id)
    {
        $role = $this->roleRepository->show($id);

        if(!$role){
            return $this->error(null, "Role Not Found", 404);
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|unique:roles,name,' . $id,
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        if($validator->fails())
        {
            return $this->error("Validation Error", $validator->errors(), 422);
        }

        $role = $this->roleRepository->update(
            $id,
            ['name' => $request->name],
            $request->permissions ?? []
        );

        return $this->success($role, "Role Updated Successfully", 200);
    }

    public function delete($id)
    {
        $role = $this->roleRepository->show($id);

        if(!$role)
        {
            return $this->error(null, "Role Not Found", 404);
        }

        $this->roleRepository->delete($id);

        return $this->success($role, "Role Deleted Successfully", 200);
    }
}
