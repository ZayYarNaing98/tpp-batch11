@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-shield-account"></i>
            </span> Roles
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Role List</h4>
                <a href="{{ route('roles.create') }}" class="btn btn-gradient-success btn-sm">+ Create</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>PERMISSIONS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @forelse ($role->permissions as $permission)
                                        <span class="badge badge-outline-success me-1 mb-1">{{ $permission->name }}</span>
                                    @empty
                                        <span class="text-muted">No permissions</span>
                                    @endforelse
                                </td>
                                <td class="d-flex">
                                    <a href="{{ route('roles.edit', ['id' => $role->id]) }}" class="btn btn-outline-secondary btn-sm me-2">Edit</a>
                                    <form action="{{ route('roles.delete', [$role->id]) }}" method="POST" onsubmit="return confirm('Delete this role?')">
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No roles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
