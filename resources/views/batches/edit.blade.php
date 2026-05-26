<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Batch Edit</title>
</head>

<body>
    <div>
        <h2>Edit Batch</h2>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('batches.update', [$batch->id]) }}" method="POST">
            @csrf
            <label for="name">Batch Name:</label>
            <br>
            <input type="text" id="name" name="name" value="{{ $batch->name }}" />
            <br><br>
            <label for="description">Description:</label>
            <br>
            <textarea id="description" name="description">{{ $batch->description }}</textarea>
            <br><br>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" value="{{$batch->start_date}}" class="form-control" name="start_date" />
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" value="{{$batch->end_date}}" class="form-control" name="end_date" />
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Batch Status:</label>
                <select name="status" id="status">
                    <option value="upcoming"  {{ $batch->status == "upcoming" ? 'selected' : '' }}>Upcoming</option>
                    <option value="ongoing" {{ $batch->status == "ongoing" ? 'selected' : '' }}>Ongoing</option>
                    <option value="complete" {{ $batch->status == "complete" ? 'selected' : '' }}>Complete</option>
                </select>
            </div>
            <button type="submit">Update</button>
            <a href="{{ route('batches.index') }}">Back</a>
        </form>
    </div>
</body>

</html>
