<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function index()
    {
        return User::with('roles')->get();
    }

    public function show($id)
    {
        return User::with('roles')->findOrFail($id);
    }

    public function store($data, $role = null)
    {
        $user = User::create($data);

        if ($role) {
            $user->syncRoles([$role]);
        }

        return $user;
    }

    public function update($id, $data, $role = null)
    {
        $user = User::findOrFail($id);

        $user->update($data);

        $user->syncRoles($role ? [$role] : []);

        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        return $user->delete();
    }
}
