<!DOCTYPE HTML>
<head>
    <title>Auth Page</title>
</head>
<body>
<a href="{{ route('register') }}">Register</a>
<a href="{{route('login')}}">Login</a>
<form action="{{ route('shopify.session') }}" method="GET" style="display:inline;">
        <button type="submit">Get Shopify Data</button>
    </form>

</body>