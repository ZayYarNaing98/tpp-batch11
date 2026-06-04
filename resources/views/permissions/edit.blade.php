@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-key-variant"></i>
            </span> Edit Permission
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
            <form action="{{ route('permissions.update', [$permission->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Permission Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $permission->name) }}">
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-gradient-success me-2">Update</button>
                <a href="{{ route('permissions.index') }}" class="btn btn-light">Back</a>
            </form>
        </div>
    </div>
@endsection
