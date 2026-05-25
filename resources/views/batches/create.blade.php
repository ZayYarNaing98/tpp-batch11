<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-API-Compatible" content="ie=edge">
    <title>Batch Create</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2 class="my-4">Create New Batch</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('batches.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Batch Name:</label>
                <input type="text" class="form-control" name="name" placeholder="Enter Batch Name" />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Batch Description:</label>
                <input type="text" class="form-control" name="description" placeholder="Enter Batch Name" />
            </div>
            <button type="submit" class="btn btn-primary btn-sm">+ Create</button>
            <a href="{{ route('batches.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>
