@extends('layouts.app')

@section('title', 'Category Create')

@section('content')
    <div style="max-width: 600px;">
        <h2 class="my-4">Create New Category</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Category Name">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm me-2">+ Create</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection
