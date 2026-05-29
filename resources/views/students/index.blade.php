@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-account-school"></i>
            </span> Students
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Student List</h4>
                <a href="{{ route('students.create') }}" class="btn btn-gradient-success btn-sm">+ Create</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>IMAGE</th>
                            <th>BATCH</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>PHONE</th>
                            <th>ENROLLED AT</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>
                                    @if ($student->image)
                                        <img src="{{ asset('studentImages/' . $student->image) }}" alt="{{ $student->name }}" width="50" height="50" style="object-fit: cover;" class="rounded">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $student->batch->name ?? '-' }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->enrolled_at ? $student->enrolled_at->format('Y-m-d') : '-' }}</td>
                                <td>
                                    <label class="badge
                                        @if($student->status === 'active') badge-gradient-success
                                        @elseif($student->status === 'inactive') badge-gradient-warning
                                        @else badge-gradient-dark
                                        @endif">
                                        {{ ucfirst($student->status) }}
                                    </label>
                                </td>
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
            </div>
        </div>
    </div>
@endsection
