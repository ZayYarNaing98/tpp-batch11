<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class UserController extends BaseController
{
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[OA\Get(
        path: '/api/users',
        tags: ['Users'],
        summary: 'List all users',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Users retrieved successfully'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index()
    {
        $users = $this->userRepository->index();

        return $this->success($users, "User Retrieved Successfully.", 200);
    }

    #[OA\Post(
        path: '/api/users',
        tags: ['Users'],
        summary: 'Create a new user',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'password', 'password_confirmation'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Admin User'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'admin@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password'),
                    new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: 'password'),
                    new OA\Property(property: 'role', type: 'string', example: 'admin'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'User created successfully'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'nullable|exists:roles,name',
        ]);

        if($validator->fails())
        {
            return $this->error("Validation Error", $validator->errors(), 422);
        }

        $user = $this->userRepository->store(
            $request->only(['name', 'email', 'password']),
            $request->role
        );

        return $this->success($user, "User Created Successfully", 201);
    }

    #[OA\Get(
        path: '/api/users/{id}',
        tags: ['Users'],
        summary: 'Get a single user',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'User retrieved successfully'),
            new OA\Response(response: 404, description: 'User not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function show($id)
    {
        $user = $this->userRepository->show($id);

        if(!$user){
            return $this->error(null, "User Not Found", 404);
        }

        return $this->success($user, "User Show Successfully", 200);
    }

    #[OA\Put(
        path: '/api/users/{id}',
        tags: ['Users'],
        summary: 'Update a user',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Admin User'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'admin@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'newpassword'),
                    new OA\Property(property: 'role', type: 'string', example: 'admin'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'User updated successfully'),
            new OA\Response(response: 404, description: 'User not found'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userRepository->show($id);

        if(!$user){
            return $this->error(null, "User Not Found", 404);
        }

        $data = $request->only(['name', 'email']);

        if($request->filled('password'))
        {
            $data['password'] = $request->password;
        }

        $user = $this->userRepository->update($id, $data, $request->role);

        return $this->success($user, "User Updated Successfully", 200);
    }

    #[OA\Delete(
        path: '/api/users/{id}',
        tags: ['Users'],
        summary: 'Delete a user',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'User deleted successfully'),
            new OA\Response(response: 404, description: 'User not found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function delete($id)
    {
        $user = $this->userRepository->show($id);

        if(!$user)
        {
            return $this->error(null, "User Not Found", 404);
        }

        $this->userRepository->delete($id);

        return $this->success($user, "User Deleted Successfully", 200);
    }
}
