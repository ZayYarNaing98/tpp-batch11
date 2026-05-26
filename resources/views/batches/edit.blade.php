@extends('layouts.app')

@section('title', 'Batch Edit')

@section('content')
    <div style="max-width: 600px;">
        <h2 class="my-4">Edit Batch</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('batches.update', [$batch->id]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Batch Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $batch->name }}" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description">{{ $batch->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Update</button>
            <a href="{{ route('batches.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </form>
    </div>
@endsection
