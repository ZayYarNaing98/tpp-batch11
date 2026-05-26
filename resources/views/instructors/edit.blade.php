@extends('layouts.app')

@section('title', 'Instructor Edit')

@section('content')
    <div style="max-width: 600px;">
        <h2 class="my-4">Edit Instructor</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('instructors.update', [$instructor->id]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $instructor->name }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $instructor->email }}">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $instructor->phone }}">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Update</button>
            <a href="{{ route('instructors.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </form>
    </div>
@endsection
