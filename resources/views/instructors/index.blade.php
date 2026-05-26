@extends('layouts.app')

@section('title', 'Instructors')

@section('content')
    <h1 class="mt-4">Instructors</h1>
    <a href="{{ route('instructors.create') }}" class="btn btn-outline-success btn-sm">+Create</a>

    <table class="table table-striped table-hover mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>PHONE</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $instructor)
                <tr>
                    <td>{{ $instructor->id }}</td>
                    <td>{{ $instructor->name }}</td>
                    <td>{{ $instructor->email }}</td>
                    <td>{{ $instructor->phone }}</td>
                    <td class="d-flex">
                        <a href="{{ route('instructors.edit', ['id' => $instructor->id]) }}" class="btn btn-outline-secondary btn-sm me-2">Edit</a>
                        <form action="{{ route('instructors.delete', [$instructor->id]) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
