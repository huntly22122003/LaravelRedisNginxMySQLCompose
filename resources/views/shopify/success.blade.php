<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Shopify App Installed</title>
</head>
<body>
    <h1>App installed successfully!</h1>

    <p><strong>Shop domain:</strong> {{ $shop }}</p>
    <p><strong>Scope:</strong> {{ $data['scope'] }}</p>
    <p><strong>Access Token:</strong> {{ $data['access_token'] }}</p>

    {{-- Nút qua trang product --}}
    <p>
        <a href="{{ route('products.index') }}">Go to Products Page</a>
    </p>
     {{-- Nút qua trang bulkshopify --}}
    <p>
        <a href="{{ route('shopify.bulkshopify') }}">Go to Bulk Shopify Page</a>
    </p>

</body>
</html>