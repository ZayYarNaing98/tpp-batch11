@extends('layouts.app')

@section('title', 'Batches')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-layers"></i>
            </span> Batches
        </h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Batch List</h4>
                <a href="{{ route('batches.create') }}" class="btn btn-gradient-success btn-sm">+ Create</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>INSTRUCTORS</th>
                            <th>DESCRIPTION</th>
                            <th>START DATE</th>
                            <th>END DATE</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $batch)
                            <tr>
                                <td>{{ $batch->id }}</td>
                                <td>{{ $batch->name }}</td>
                                <td>
                                    @if ($batch->instructors->isNotEmpty())
                                        {{ $batch->instructors->pluck('name')->join(',') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $batch->description }}</td>
                                <td>{{ $batch->start_date ?? '-' }}</td>
                                <td>{{ $batch->end_date ?? '-' }}</td>
                                <td>
                                    <label class="badge
                                        @if($batch->status === 'upcoming') badge-gradient-warning
                                        @elseif($batch->status === 'ongoing') badge-gradient-success
                                        @else badge-gradient-dark
                                        @endif">
                                        {{ ucfirst($batch->status) }}
                                    </label>
                                </td>
                                <td class="d-flex">
                                    <a href="{{ route('batches.edit', ['id' => $batch->id]) }}" class="btn btn-outline-secondary btn-sm me-2">Edit</a>
                                    <form action="{{ route('batches.delete', [$batch->id]) }}" method="POST">
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
