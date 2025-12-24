<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Soft Deleted Products</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <h1>Soft Deleted Products</h1>
    <ul>
        @foreach($products as $product)
            @php $payload = json_decode($product->payload, true); @endphp
            <li>
                {{ $payload['title'] }} - {{ $payload['variants'][0]['price'] ?? 'N/A' }}
                <form method="POST" action="{{ route('products.destroy', $product->shopify_product_id) }}" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit">Hard Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
</body>
</html>