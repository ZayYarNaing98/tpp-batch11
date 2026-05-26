@extends('layouts.app')

@section('title', 'Student Create')

@section('content')
    <div style="max-width: 600px;">
        <h2 class="my-4">Create New Student</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ old('name') }}" />
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" />
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="{{ old('phone') }}" />
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" placeholder="Enter Address">{{ old('address') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">+ Create</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </form>
    </div>
@endsection
