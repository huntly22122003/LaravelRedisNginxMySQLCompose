<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Shop</th>
            <th>Email</th>
            <th>Total</th>
            <th>Financial</th>
            <th>Received At</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>#{{ $order->shopify_order_id }}</td>
                <td>{{ $order->shopify->domain }}</td>
                <td>{{ $order->email ?? '-' }}</td>
                <td>{{ $order->total_price }} {{ $order->currency }}</td>
                <td>{{ $order->financial_status }}</td>
                <td>{{ $order->received_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ url()->previous() }}">
    <button type="button">⬅ Return</button>
</a>
