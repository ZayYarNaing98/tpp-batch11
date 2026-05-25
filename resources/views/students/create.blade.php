<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Create</title>
</head>

<body>
    <div>
        <h2>Create New Student</h2>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter Name" value="{{ old('name') }}" />
            <br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" />
            <br><br>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" placeholder="Enter Phone" value="{{ old('phone') }}" />
            <br><br>
            <label for="address">Address:</label>
            <textarea id="address" name="address" placeholder="Enter Address">{{ old('address') }}</textarea>
            <br><br>
            <button type="submit">+ Create</button>
            <a href="{{ route('students.index') }}">Back</a>
        </form>
    </div>
</body>

</html>
