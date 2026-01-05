<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bulk Shopify Import / Export</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Bulk Shopify Import / Export</h2>

    {{-- Import Form --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Bulk Import Products</div>
        <div class="card-body">
            <form action="{{ route('bulk.products.import') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="products" class="form-label">Products JSON</label>
                    <textarea name="products" id="products" class="form-control" rows="8"
                        placeholder='[{"title":"Product 1","vendor":"Vendor A"},{"title":"Product 2","vendor":"Vendor B"}]'></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Import</button>
            </form>
        </div>
    </div>

    {{-- Export Button --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Bulk Export Products</div>
        <div class="card-body">
            <form action="{{ route('bulk.products.export') }}" method="GET">
                <button type="submit" class="btn btn-success">Export All Products</button>
            </form>
        </div>
    </div>
            
    <a href="{{ route('shopify.session') }}" class="btn btn-primary mt-3" target="_top">
    ⬅ Return
    </a>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>