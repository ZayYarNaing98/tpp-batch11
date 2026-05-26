@extends('layouts.app')

@section('title', 'Instructors')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-account-tie"></i>
            </span> Instructors
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Instructor List</h4>
                <a href="{{ route('instructors.create') }}" class="btn btn-gradient-success btn-sm">+ Create</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
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
            </div>
        </div>
    </div>
@endsection
