<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->index();

        return $this->success($users, "User Retrieved Successfully.", 200);
    }

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

    public function show($id)
    {
        $user = $this->userRepository->show($id);

        if(!$user){
            return $this->error(null, "User Not Found", 404);
        }

        return $this->success($user, "User Show Successfully", 200);
    }

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
