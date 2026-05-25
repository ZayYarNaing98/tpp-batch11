<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-API-Compatible" content="ie=edge">
    <title>Batch Create</title>
</head>

<body>
    <div>
        <h2>Create New Batch</h2>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('batches.store') }}" method="POST">
            @csrf
            <label for="name">Batch Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter Batch Name" value="{{ old('name') }}" />
            <br><br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Enter Description">{{ old('description') }}</textarea>
            <br><br>
            <button type="submit">+ Create</button>
            <a href="{{ route('batches.index') }}">Back</a>
        </form>
    </div>
</body>

</html>
