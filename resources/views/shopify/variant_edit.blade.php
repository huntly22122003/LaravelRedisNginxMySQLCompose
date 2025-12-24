<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Variant</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <h1>Edit Variant</h1>
    <p><strong>Access Token:</strong> {{ $token }}</p>

    <form method="POST" action="{{ route('variants.update', ['productId' => $productId, 'variantId' => $variant['id']]) }}">
        @csrf @method('PUT')
        <input type="text" name="title" value="{{ $variant['title'] }}" required>
        <input type="text" name="price" value="{{ $variant['price'] ?? '' }}" required>
        <input type="text" name="sku" value="{{ $variant['sku'] ?? '' }}">
        <input type="text" name="option1" value="{{ $variant['option1'] ?? 'Default Title' }}">
        <button type="submit">Update Variant</button>
    </form>
</div>
</body>
</html>