@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-account-school"></i>
            </span> Edit Student
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
            <form action="{{ route('students.update', [$student->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="batch_id">Batch</label>
                    <select class="form-control" id="batch_id" name="batch_id">
                        <option value="">-- Select Batch --</option>
                        @foreach ($batches as $batch)
                            <option value="{{ $batch->id }}" {{ old('batch_id', $student->batch_id) == $batch->id ? 'selected' : '' }}>
                                {{ $batch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $student->name) }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $student->email) }}">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $student->phone) }}">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $student->address) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="enrolled_at">Enrolled At</label>
                    <input type="date" class="form-control" id="enrolled_at" name="enrolled_at"
                        value="{{ old('enrolled_at', $student->enrolled_at ? $student->enrolled_at->format('Y-m-d') : '') }}">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="active" {{ old('status', $student->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $student->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="graduated" {{ old('status', $student->status) === 'graduated' ? 'selected' : '' }}>Graduated</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    @if ($student->image)
                        <div class="mb-2">
                            <img src="{{ asset('studentImages/' . $student->image) }}" alt="Current Image" width="100" class="rounded">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <button type="submit" class="btn btn-gradient-success me-2">Update</button>
                <a href="{{ route('students.index') }}" class="btn btn-light">Back</a>
            </form>
        </div>
    </div>
@endsection
