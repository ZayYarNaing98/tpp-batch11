@extends('layouts.app')

@section('title', 'Batches')

@section('content')
    <h1 class="mt-4">Batches</h1>
    <a href="{{ route('batches.create') }}" class="btn btn-outline-success btn-sm">+Create</a>

    <table class="table table-striped table-hover mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>DESCRIPTION</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $batch)
                <tr>
                    <td>{{ $batch->id }}</td>
                    <td>{{ $batch->name }}</td>
                    <td>{{ $batch->description }}</td>
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
@endsection
