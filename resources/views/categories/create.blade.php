<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Category Create</title>
</head>

<body>
    <div>
        <h2>Create New Category</h2>
        {{-- {{ dd($errors) }} --}}
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter Category Name" />
            <button type="submit">
                + Create
            </button>
            <a href="{{ route('categories.index') }}">Back</a>
        </form>
    </div>
</body>

</html>
