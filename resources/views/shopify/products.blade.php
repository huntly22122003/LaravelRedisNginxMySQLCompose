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
            <li>
                {{ $product['title'] }} - {{ $product['variants'][0]['price'] ?? 'N/A' }}
                <a href="{{ route('products.edit', $product['id']) }}">Edit</a>
                <form method="POST" action="{{ route('products.softDelete', $product['id']) }}" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit">Soft Delete</button>
                </form>
                {{--Variant--}}
                <a href="{{ route('shopify.variant', ['productId' => $product['id']]) }}">Go to Variant Page</a>
            </li>
        @endforeach
    </ul>
    <!-- Nút sang trang Soft Delete -->
    <div style="margin-top:20px;">
        <a href="{{ route('products.softDeletedIndex') }}">
            <button type="button">Manage Soft Delete Product</button>
        </a>
    </div>

</div>
</body>
</html>