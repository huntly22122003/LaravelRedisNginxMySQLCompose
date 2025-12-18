<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Variants</title>
</head>
<body>
    <h1>Variants for Product {{ $productId }} (Shop: {{ $shop }})</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <ul>
        @foreach($variants as $variant)
            <li>
                {{ $variant['title'] ?? 'No title' }} - Price: {{ $variant['price'] ?? 'N/A' }}
            </li>
        @endforeach
    </ul>

    <h2>Create new variant</h2>
    <form method="POST" action="{{ route('shopify.storeVariant', ['productId' => $productId]) }}">
        @csrf
        <input type="hidden" name="shop" value="{{ $shop }}">
        <label>Title: <input type="text" name="title"></label><br>
        <label>Price: <input type="text" name="price"></label><br>
        <label>SKU: <input type="text" name="sku"></label><br>
        <button type="submit">Create Variant</button>
    </form>
</body>
</html>