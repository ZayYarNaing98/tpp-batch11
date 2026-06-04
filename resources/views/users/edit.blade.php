@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-account-multiple"></i>
            </span> Edit User
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
            <form action="{{ route('users.update', [$user->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                </div>
                <div class="form-group">
                    <label for="password">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role">
                        <option value="">— No Role —</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role', optional($user->roles->first())->name) === $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-gradient-success me-2">Update</button>
                <a href="{{ route('users.index') }}" class="btn btn-light">Back</a>
            </form>
        </div>
    </div>
@endsection
