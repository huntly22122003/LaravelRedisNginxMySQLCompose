<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <h1>Edit Product</h1>
    <p><strong>Access Token:</strong> {{ $token }}</p>

    <form method="POST" action="{{ route('products.update', $product['id']) }}">
        @csrf @method('PUT')
        <input type="text" name="title" value="{{ $product['title'] }}" required>
        <input type="text" name="price" value="{{ $product['variants'][0]['price'] ?? '' }}" required>
        <button type="submit">Update Product</button>
    </form>
</div>
<!-- Nút sang trang Soft Delete -->
    <div style="margin-top:20px;">
        <a href="{{ route('products.softDeletedIndex') }}">
            <button type="button">Xem sản phẩm đã Soft Delete</button>
        </a>
    </div>

</body>
</html>