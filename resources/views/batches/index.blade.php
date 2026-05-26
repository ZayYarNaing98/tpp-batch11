<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Batch</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Batches</h1>
        <a href="{{ route('batches.create') }}" class="btn btn-outline-success btn-sm">+Create</a>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>DESCRIPTION</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $batch)
                    <tr>
                        <td>{{ $batch->id }}</td>
                        <td>{{ $batch->name }}</td>
                        <td>{{ $batch->description }}</td>
                        <td>{{ $batch->start_date ?? "-" }}</td>
                        <td>{{ $batch->end_date ?? "-" }}</td>
                        <td>{{ $batch->status }}</td>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>
