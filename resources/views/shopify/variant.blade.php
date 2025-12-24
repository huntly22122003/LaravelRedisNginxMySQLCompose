<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Variants</title>
</head>
<body>
    <h1>Variants for Product {{ $productId }}</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <ul>
        @foreach($variants as $variant)
            <li>
                {{ $variant['title'] ?? 'No title' }} - Price: {{ $variant['price'] ?? 'N/A' }}

                {{-- Nút Edit --}}
                <a href="{{ route('variants.edit', ['productId' => $productId, 'variantId' => $variant['id']]) }}">
                    Edit
                </a>

                {{-- Form Delete --}}
                <form method="POST" action="{{ route('variants.destroy', ['productId' => $productId, 'variantId' => $variant['id']]) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    <h2>Create new variant</h2>
    <form method="POST" action="{{ route('variants.store', ['productId' => $productId]) }}">
        @csrf
        <label>Title: <input type="text" name="title" required></label><br>
        <label>Price: <input type="text" name="price" required></label><br>
        <label>SKU: <input type="text" name="sku"></label><br>
        <label>Option1: <input type="text" name="option1" value="Default Title"></label><br>
        <button type="submit">Create Variant</button>

    </form>
</body>
</html>