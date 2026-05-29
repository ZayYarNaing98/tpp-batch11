@extends('layouts.app')

@section('title', 'Create Batch')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-layers"></i>
            </span> Create Batch
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
            <form action="{{ route('batches.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Batch Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter batch name">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter batch description"></textarea>
                </div>
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date">
                </div>
                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="upcoming">Upcoming</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="complete">Complete</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="instructor">Select Instructor</label>
                    @foreach ($instructors as $instructor)
                        <input type="checkbox" name="instructor_ids[]" id="instructor_{{$instructor->id}}" value="{{ $instructor->id }}"/>
                        <label for="instructor_{{$instructor->id}}">
                            {{ $instructor->name }}
                        </label>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-gradient-success me-2">+ Create</button>
                <a href="{{ route('batches.index') }}" class="btn btn-light">Back</a>
            </form>
        </div>
    </div>
@endsection
