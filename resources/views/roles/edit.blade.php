@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-shield-account"></i>
            </span> Edit Role
        </h3>
    </div>

    <div class="card">
        <div class="card-body" style="max-width: 600px;">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('roles.update', [$role->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Role Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $role->name) }}">
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Assign Permissions</label>
                    @if ($permissions->isEmpty())
                        <p class="text-muted">No permissions available. Please create permissions first.</p>
                    @else
                        <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                            @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                            value="{{ $permission->name }}"
                                            {{ in_array($permission->name, old('permissions', $role->permissions->pluck('name')->toArray())) ? 'checked' : '' }}>
                                        {{ $permission->name }}
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-gradient-success me-2">Update</button>
                <a href="{{ route('roles.index') }}" class="btn btn-light">Back</a>
            </form>
        </div>
    </div>
@endsection
