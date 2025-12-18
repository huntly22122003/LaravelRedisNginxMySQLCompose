<!DOCTYPE html>
<html>
<head>
    <title>Shopify Connection Check</title>
</head>
<body>
    @if($result['success'])
        <h1>✅ Connected to Shopify!</h1>
        <p>Shop Name: {{ $result['data']['name'] }}</p>
        <p>Domain: {{ $result['data']['domain'] }}</p>
        <p>Country: {{ $result['data']['country_name'] }}</p>
    @else
        <h1>❌ Connection Failed</h1>
        <p>{{ $result['message'] }}</p>
    @endif
</body>
</html>