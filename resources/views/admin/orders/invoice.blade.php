<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Hind Siliguri', sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border: 1px solid #ddd;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #F58220;
        }

        .company-info h1 {
            color: #F58220;
            font-size: 32px;
            margin-bottom: 5px;
        }

        .company-info p {
            color: #666;
            font-size: 14px;
        }

        .invoice-meta {
            text-align: right;
        }

        .invoice-meta h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .invoice-meta p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }

        .addresses {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .address-block h3 {
            font-size: 16px;
            color: #F58220;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .address-block p {
            font-size: 14px;
            margin: 5px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table thead {
            background-color: #f8f9fa;
        }

        .items-table th {
            padding: 12px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #ddd;
        }

        .items-table td {
            padding: 12px;
            font-size: 14px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .items-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .product-meta {
            font-size: 12px;
            color: #666;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            margin-left: auto;
            width: 300px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 14px;
        }

        .totals-row.subtotal {
            border-top: 1px solid #ddd;
        }

        .totals-row.total {
            border-top: 2px solid #333;
            font-size: 18px;
            font-weight: bold;
            color: #F58220;
            padding-top: 15px;
            margin-top: 10px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 12px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background-color: #cfe2ff;
            color: #084298;
        }

        .status-shipped {
            background-color: #e7d6ff;
            color: #6f42c1;
        }

        .status-delivered {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #842029;
        }

        @media print {
            body {
                padding: 0;
            }

            .invoice-container {
                border: none;
                padding: 20px;
            }

            .no-print {
                display: none;
            }

            @page {
                margin: 1cm;
            }
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #F58220;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .print-button:hover {
            background-color: #d66e1a;
        }
    </style>
</head>

<body>
    <button onclick="window.print()" class="print-button no-print">
        <i class="fas fa-print"></i> Print Invoice
    </button>

    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1>বস্ত্র ভিলা</h1>
                <p>E-commerce Store</p>
                <p>Email: info@vastraavillaa.com</p>
                <p>Phone: +880 1234-567890</p>
            </div>
            <div class="invoice-meta">
                <h2>INVOICE</h2>
                <p><strong>Invoice #:</strong> {{ $order->order_number }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                <p><strong>Status:</strong>
                    <span class="status-badge status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Addresses -->
        <div class="addresses">
            <div class="address-block">
                <h3>Bill To:</h3>
                @if ($order->billing_address)
                    <p><strong>{{ $order->billing_address['name'] ?? trim(($order->billing_address['first_name'] ?? '') . ' ' . ($order->billing_address['last_name'] ?? '')) }}</strong>
                    </p>
                    <p>{{ $order->billing_address['address'] ?? '' }}</p>
                    <p>{{ $order->billing_address['city'] ?? '' }}</p>
                    <p>{{ $order->billing_address['country'] ?? '' }}</p>
                    <p>Phone: {{ $order->billing_address['phone'] ?? '' }}</p>
                @else
                    <p>No billing address available</p>
                @endif
            </div>

            <div class="address-block">
                <h3>Ship To:</h3>
                @if ($order->shipping_address)
                    <p><strong>{{ $order->shipping_address['name'] ?? trim(($order->shipping_address['first_name'] ?? '') . ' ' . ($order->shipping_address['last_name'] ?? '')) }}</strong>
                    </p>
                    <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                    <p>{{ $order->shipping_address['city'] ?? '' }}</p>
                    <p>{{ $order->shipping_address['country'] ?? '' }}</p>
                    <p>Phone: {{ $order->shipping_address['phone'] ?? '' }}</p>
                @else
                    <p>No shipping address available</p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Product</th>
                    <th style="width: 15%;" class="text-right">Price</th>
                    <th style="width: 10%;" class="text-right">Qty</th>
                    <th style="width: 25%;" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->orderItems as $item)
                    <tr>
                        <td>
                            <div class="product-info">
                                @if ($item->product && $item->product->image)
                                    <img src="{{ public_path('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}" class="product-image"
                                        onerror="this.style.display='none'">
                                @else
                                    <div class="product-image"
                                        style="background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999;">
                                        No Image
                                    </div>
                                @endif
                                <div class="product-details">
                                    <div class="product-name">{{ $item->product->name ?? 'N/A' }}</div>
                                    <div class="product-meta">
                                        @if ($item->color)
                                            Color: {{ $item->color }}
                                        @endif
                                        @if ($item->size)
                                            {{ $item->color ? ' | ' : '' }}Size: {{ $item->size }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-right">৳{{ number_format($item->price, 2) }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">৳{{ number_format($item->total, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px; color: #999;">
                            No items in this order
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <div class="totals-row subtotal">
                <span>Subtotal:</span>
                <span>৳{{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Delivery Charge:</span>
                <span>৳{{ number_format($order->shipping, 2) }}</span>
            </div>
            <div class="totals-row total">
                <span>Total:</span>
                <span>৳{{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <!-- Payment Info -->
        <div style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-radius: 6px;">
            <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
            <p><strong>Payment Status:</strong>
                <span class="status-badge status-{{ $order->payment_status }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>This is a computer-generated invoice and does not require a signature.</p>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script>
</body>

</html>
