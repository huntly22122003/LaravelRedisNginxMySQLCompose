<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopify Products</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <h1>Shopify Products</h1>
    <p><strong>Access Token:</strong> {{ $token }}</p>

    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <input type="text" name="title" placeholder="Product title" required>
        <input type="text" name="price" placeholder="Price" required>
        <button type="submit">Add Product</button>
    </form>

    <ul>
        @foreach($products as $product)
            <li>{{ $product['title'] }} - {{ $product['variants'][0]['price'] ?? 'N/A' }}</li>
        @endforeach
    </ul>
</div>
</body>
</html>