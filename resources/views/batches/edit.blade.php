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
            <button type="submit">Update</button>
            <a href="{{ route('batches.index') }}">Back</a>
        </form>
    </div>
</body>

</html>
