@extends('layouts.app')

@section('title', 'Batch Create')

@section('content')
    <div style="max-width: 600px;">
        <h2 class="my-4">Create New Batch</h2>
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
            <div class="mb-3">
                <label for="name" class="form-label">Batch Name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter Batch Name" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" name="description" placeholder="Enter Description" />
            </div>
            <button type="submit" class="btn btn-primary btn-sm">+ Create</button>
            <a href="{{ route('batches.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </form>
    </div>
@endsection
