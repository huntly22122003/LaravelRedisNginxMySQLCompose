<!DOCTYPE HTML>
<head>
    <title>Auth Page</title>
</head>
<body>
    <h1>Xin chào {{ Auth::guard('shop')->user()->name }}</h1>
    <form method="POST" action="{{ route('logout') }}">
    @csrf
        <button type="submit">Logout</button>
    </form>
    <form method="POST" action="{{route('updateuser')}}">
        @csrf
        <button type="submit">Update profile</button>
    </form>
    <a href="{{ route('tasks.index') }}">
        <button type="button">Tasks</button>
    </a>
    <a href="{{ route('security.logs') }}">
        <button type="button">Security Logs</button>
    </a>

</body>