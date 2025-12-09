<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" charset="UTF-8">
    <title>Update Profile</title>
</head>
<body>
    <h2>Update Profile</h2>
    <form action="{{ route('updateuser')}}" method="POST" enctype="multipart/form-dat">
        @csrf
        <p>Full name: {{ $user->name }}</p>
        <div>
            <label>Full Name change:</label>
            <input type="text" name="name">
        </div>
        <p>Email: {{ $user->email }}</p>
        <p>Phone now: {{ $user->phone }}</p>
        <div>
            <label>Phone Change:</label>
            <input type="text" name="phone">
        </div>
        <p>Address now: {{$user->address}}</p>
        <div>
            <label>Address Change:</label>
            <input type="text" name="address">
        </div>
        <button>Confirm Change</button>
    </form>
    <form action="{{route('website')}}" method="GET">
        <button>Go back</button>
    </form>
    <h2>Update Password</h2>
    <form action="{{ route('updateuserpassword') }}" method="POST">
        @csrf
        
        <div>
            <label>New Password:</label>
            <input type="password" name="new_password" required>
            @error('new_password')
                <p style="color:red">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Confirm New Password:</label>
            <input type="password" name="new_password_confirmation" required>
        </div>

        <button type="submit">Confirm Change</button>
    </form>

</body>
</html>
