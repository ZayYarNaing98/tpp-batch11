@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-tag-multiple"></i>
            </span> Categories
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Category List</h4>
                <a href="{{ route('categories.create') }}" class="btn btn-gradient-success btn-sm">+ Create</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('categories.edit', ['id' => $category->id]) }}" class="btn btn-outline-secondary btn-sm me-2">Edit</a>
                                    <form action="{{ route('categories.delete', [$category->id]) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
