<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: left; }
        .success { color: green; }
        .error { color: red; }
        form { display: inline-block; margin: 0 5px; }
        input[type="text"] { padding: 5px; margin-right: 5px; }
        button { padding: 5px 10px; }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    {{-- Form search --}}
    <form method="GET" action="{{ route('admin.dashboard') }}">
        <input type="text" name="search" value="{{ $keyword ?? '' }}" placeholder="Search users...">
        <button type="submit">Search</button>
    </form>
    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}">
    @csrf
        <button type="submit">Logout</button>
    </form>

    {{-- Add user --}}
    <a href="{{ route('admin.users.create') }}">
    <button type="button">Add User</button>
    </a>

    {{-- Bảng danh sách user --}}
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Actions Update Name|| Phone|| Address</th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->address }}</td>
                <td>
                    @foreach($user->roles as $role)
                        {{ $role->name }}
                    @endforeach
                </td>
                <td>
                    {{-- Form update --}}
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        <input type="text" name="name" value="{{ $user->name }}">
                        <input type="text" name="phone" value="{{ $user->phone }}">
                        <input type="text" name="address" value="{{ $user->address }}">
                        <button type="submit">Update</button>
                    </form>

                    {{-- Form delete --}}
                    <form method="POST" action="{{ route('admin.users.delete', $user->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this user?')">Delete</button>
                    </form>

                    {{-- Form assign role --}}
                    <form method="POST" action="{{ route('admin.users.assignRole', $user->id) }}">
                        @csrf
                        <select name="role_id">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit">Assign Role</button>
                    </form>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No users found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</body>
</html>