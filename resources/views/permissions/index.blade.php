@extends('layouts.app')

@section('title', 'Permissions')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-key-variant"></i>
            </span> Permissions
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Permission List</h4>
                <a href="{{ route('permissions.create') }}" class="btn btn-gradient-success btn-sm">+ Create</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>GUARD</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->guard_name }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('permissions.edit', ['id' => $permission->id]) }}" class="btn btn-outline-secondary btn-sm me-2">Edit</a>
                                    <form action="{{ route('permissions.delete', [$permission->id]) }}" method="POST" onsubmit="return confirm('Delete this permission?')">
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No permissions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
