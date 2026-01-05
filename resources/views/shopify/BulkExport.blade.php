<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bulk Export Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="mb-4 text-center">Exported Products</h2>

    {{-- Search Form --}}
    <form action="{{ route('bulk.products.search') }}" method="GET" class="row g-2 mb-4">
        <div class="col-auto">
            <input type="text" name="q" value="{{ $keyword ?? '' }}" class="form-control" placeholder="Search by title or vendor">
        </div>
        <div class="col-auto">
            <input type="number" name="limit" value="{{ request('limit', 10) }}" class="form-control" min="1" max="250" placeholder="Limit">
        </div>
        <div class="col-auto">
            <button class="btn btn-info">Search</button>
        </div>
        <div class="col-auto">
            <a href="{{ route('shopify.bulkshopify') }}" class="btn btn-secondary">Back to BulkShopify</a>
        </div>
    </form>

    {{-- Products Table --}}
    @if(!empty($products))
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Vendor</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product['id'] }}</td>
                        <td>{{ $product['title'] }}</td>
                        <td>{{ $product['vendor'] }}</td>
                        <td>{{ $product['variants'][0]['price'] ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning">
            No products found.
        </div>
    @endif

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<a href="{{ route('shopify.session') }}" class="btn btn-primary mt-3" target="_top">
   ⬅ Return
</a>

</body>
</html>
