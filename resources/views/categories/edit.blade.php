<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <form action="{{ route('categories.update', [$category->id]) }}" method="POST">
            @csrf
            <label for="name">Category Name:</label>
            <br>
            <input type="text" value="{{ $category->name }}" name="name"/>
            <button type="submit">
                Update
            </button>
            <a href="{{ route('categories.index') }}">Back</a>
        </form>
    </div>
</body>
</html>
