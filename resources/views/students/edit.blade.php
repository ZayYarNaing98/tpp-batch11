<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Edit</title>
</head>

<body>
    <div>
        <h2>Edit Student</h2>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('students.update', [$student->id]) }}" method="POST">
            @csrf
            <label for="name">Name:</label>
            <br>
            <input type="text" id="name" name="name" value="{{ $student->name }}" />
            <br><br>
            <label for="email">Email:</label>
            <br>
            <input type="email" id="email" name="email" value="{{ $student->email }}" />
            <br><br>
            <label for="phone">Phone:</label>
            <br>
            <input type="text" id="phone" name="phone" value="{{ $student->phone }}" />
            <br><br>
            <label for="address">Address:</label>
            <br>
            <textarea id="address" name="address">{{ $student->address }}</textarea>
            <br><br>
            <button type="submit">Update</button>
            <a href="{{ route('students.index') }}">Back</a>
        </form>
    </div>
</body>

</html>
