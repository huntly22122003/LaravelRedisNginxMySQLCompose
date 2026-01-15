<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Auth Page</title>

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>

<body>
    <div class="card">
        <div class="title">🔐 Authentication</div>

        <div class="actions">
            <a href="{{ route('register') }}" class="primary">Register</a>
            <a href="{{ route('login') }}" class="secondary">Login</a>

            <div class="divider">— Shopify —</div>

            <form action="{{ route('shopify.session') }}" method="GET">
                <button type="submit">Go to ReactJS Shopify</button>
            </form>

            <form action="https://front-next-iota.vercel.app/welcome" method="GET">
                <button type="submit">Check backend with NextJS</button>
            </form>

            <form action="https://front-next-ls4k.vercel.app/check-shopify" method="GET">
                <button type="submit">Go to NextJS Shopify</button>
            </form>
        </div>
    </div>
</body>
</html>
