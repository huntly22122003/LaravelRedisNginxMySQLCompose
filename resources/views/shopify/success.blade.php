<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Shopify App Installed</title>
    @viteReactRefresh
    @vite('resources/js/app.jsx')
    <script>
  window.csrfToken = "{{ csrf_token() }}";
    </script>

</head>
<body>
    <div id="app"
         data-shop="{{ $shop }}"
         data-scope="{{ $data['scope'] }}"
         data-access-token="{{ $data['access_token'] }}"
         data-products-url="{{ route('products.index') }}"
         data-bulkshopify-url="{{ route('shopify.bulkshopify') }}"
         data-orders-url="{{ route('order.webhooks.index') }}"
         data-products='@json($products)'
         data-products-store="{{ route('products.store') }}"
         data-products-edit="{{ route('products.edit', ['id' => 1]) }}"
         data-products-update="{{ route('products.update') }}"
         data-products-softdelete="{{ route('products.softDelete') }}"
         data-products-softdeleteproduct='@json($softDelete)'
         data-products-harddelete="{{ route('products.destroy', ['id' => 1]) }}"
         data-variants="{{ route('shopify.variant', ['productId' => 0])}}"
         data-variants-update="{{ route('variants.update', ['variantId' => 0, 'productId' => 0]) }}"
         data-variants-delete="{{ route('variants.destroy', ['variantId' => 0, 'productId' => 0]) }}"
         data-variants-create="{{ route('variants.store', ['productId' => 0]) }}"
         data-orders-index="{{ route('order.webhooks.index') }}"
         data-bulk-import="{{ route('bulk.products.import') }}" 
         data-bulk-export="{{ route('bulk.products.export') }}"
         data-bulk-exportsearch="{{ route('bulk.products.search') }}"
         >
    </div>
</body>
</html>