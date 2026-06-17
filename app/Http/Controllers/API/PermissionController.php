<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class PermissionController extends BaseController
{
    protected $permissionRepository;
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    #[OA\Get(
        path: '/api/permissions',
        tags: ['Permissions'],
        summary: 'List all permissions',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Permissions retrieved successfully'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index()
    {
        $permissions = $this->permissionRepository->index();

        return $this->success($permissions, "Permission Retrieved Successfully.", 200);
    }

    #[OA\Post(
        path: '/api/permissions',
        tags: ['Permissions'],
        summary: 'Create a new permission',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'edit-post'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Permission created successfully'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
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

    #[OA\Get(
        path: '/api/permissions/{id}',
        tags: ['Permissions'],
        summary: 'Get a single permission',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Permission retrieved successfully'),
            new OA\Response(response: 404, description: 'Permission not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function show($id)
    {
        $permission = $this->permissionRepository->show($id);

        if(!$permission){
            return $this->error(null, "Permission Not Found", 404);
        }

        return $this->success($permission, "Permission Show Successfully", 200);
    }

    #[OA\Put(
        path: '/api/permissions/{id}',
        tags: ['Permissions'],
        summary: 'Update a permission',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'edit-post'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Permission updated successfully'),
            new OA\Response(response: 404, description: 'Permission not found'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
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

    #[OA\Delete(
        path: '/api/permissions/{id}',
        tags: ['Permissions'],
        summary: 'Delete a permission',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Permission deleted successfully'),
            new OA\Response(response: 404, description: 'Permission not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
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
