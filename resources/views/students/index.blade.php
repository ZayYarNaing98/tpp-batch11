@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <h1 class="mt-4">Students</h1>
    <a href="{{ route('students.create') }}" class="btn btn-outline-success btn-sm">+Create</a>

    <table class="table table-striped table-hover mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>PHONE</th>
                <th>ADDRESS</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ $student->address ?? '-' }}</td>
                    <td class="d-flex">
                        <a href="{{ route('students.edit', ['id' => $student->id]) }}" class="btn btn-outline-secondary btn-sm me-2">Edit</a>
                        <form action="{{ route('students.delete', [$student->id]) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
