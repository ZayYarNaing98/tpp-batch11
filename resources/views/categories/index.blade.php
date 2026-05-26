@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <h1 class="mt-4">Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-outline-success btn-sm">+Create</a>

    <table class="table table-striped table-hover mt-3">
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
@endsection
