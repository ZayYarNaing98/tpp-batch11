<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class RoleController extends BaseController
{
    protected $roleRepository;
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    #[OA\Get(
        path: '/api/roles',
        tags: ['Roles'],
        summary: 'List all roles',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Roles retrieved successfully'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index()
    {
        $roles = $this->roleRepository->index();

        return $this->success($roles, "Role Retrieved Successfully.", 200);
    }

    #[OA\Post(
        path: '/api/roles',
        tags: ['Roles'],
        summary: 'Create a new role',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'editor'),
                    new OA\Property(property: 'permissions', type: 'array', items: new OA\Items(type: 'string'), example: ['create-post', 'edit-post']),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Role created successfully'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
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
            ['name' => $request->name, 'guard_name' => 'api'],
            $request->permissions ?? []
        );

        return $this->success($role, "Role Created Successfully", 201);
    }

    #[OA\Get(
        path: '/api/roles/{id}',
        tags: ['Roles'],
        summary: 'Get a single role',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Role retrieved successfully'),
            new OA\Response(response: 404, description: 'Role not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function show($id)
    {
        $role = $this->roleRepository->show($id);

        if(!$role){
            return $this->error(null, "Role Not Found", 404);
        }

        return $this->success($role, "Role Show Successfully", 200);
    }

    #[OA\Put(
        path: '/api/roles/{id}',
        tags: ['Roles'],
        summary: 'Update a role',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'editor'),
                    new OA\Property(property: 'permissions', type: 'array', items: new OA\Items(type: 'string'), example: ['create-post', 'edit-post']),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Role updated successfully'),
            new OA\Response(response: 404, description: 'Role not found'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
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

    #[OA\Delete(
        path: '/api/roles/{id}',
        tags: ['Roles'],
        summary: 'Delete a role',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Role deleted successfully'),
            new OA\Response(response: 404, description: 'Role not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
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
