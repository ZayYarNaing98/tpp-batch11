@extends('layouts.app')

@section('title', 'Create Student')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-account-school"></i>
            </span> Create Student
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
            <form action="{{ route('students.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ old('name') }}" />
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ old('email') }}" />
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone" value="{{ old('phone') }}" />
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address">{{ old('address') }}</textarea>
                </div>
                <button type="submit" class="btn btn-gradient-success me-2">+ Create</button>
                <a href="{{ route('students.index') }}" class="btn btn-light">Back</a>
            </form>
        </div>
    </div>
@endsection
