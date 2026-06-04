<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;
    protected $roleRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $users = $this->userRepository->index();

        return view('users.index', [
            'data' => $users
        ]);
    }

    public function create()
    {
        $roles = $this->roleRepository->index();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'nullable|exists:roles,name',
        ]);

        $role = $data['role'] ?? null;
        unset($data['role']);

        $this->userRepository->store($data, $role);

        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user  = $this->userRepository->show($id);
        $roles = $this->roleRepository->index();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $this->userRepository->update($id, $data, $request->role);

        return redirect()->route('users.index');
    }

    public function delete($id)
    {
        $this->userRepository->delete($id);

        return redirect()->route('users.index');
    }
}
