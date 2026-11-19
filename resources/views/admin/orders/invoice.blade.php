<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; color: #333; }
        .header { border-bottom: 2px solid #2563eb; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #2563eb; }
        .meta { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f3f4f6; }
        .text-right { text-align: right; }
        .total { font-size: 15px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>RigStore Hardware Invoice</h1>
        <p>Order #{{ $order->id }} &bull; Date: {{ $order->created_at->format('d M Y') }}</p>
    </div>

    <div class="meta">
        <strong>Customer:</strong> {{ $order->user->name }} ({{ $order->user->email }})<br>
        <strong>Status:</strong> {{ ucfirst($order->status) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="text-right">RP{{ number_format($item->price_at_purchase, 2) }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">RP{{ number_format($item->price_at_purchase * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right total">Total Paid</td>
                <td class="text-right total">RP{{ number_format($order->total_price, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>