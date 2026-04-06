<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Purchase Invoice</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 20px;
            color: #222;
        }

        h2 {
            margin-bottom: 5px;
        }

        .header {
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info div {
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        table th {
            background: #f1f1f1;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            margin-top: 20px;
            width: 300px;
            margin-left: auto;
        }

        .totals td {
            padding: 6px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <!-- HEADER -->
    <div class="header">
        <h2>Purchase Invoice</h2>
        <div>Printed at: {{ now()->format('d M Y h:i A') }}</div>
    </div>

    <!-- INFO -->
    <div class="info">
        <div><strong>Purchase No:</strong> {{ $purchase->purchase_no }}</div>
        <div><strong>Supplier:</strong> {{ $purchase->supplier->supp_name ?? 'N/A' }}</div>
        <div><strong>Date:</strong> {{ $purchase->created_at->format('d M Y h:i A') }}</div>
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Unit</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($purchase->metas as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>
                        {{ $row->category->cat_name ?? $row->category->name ?? $row->category_id }}
                    </td>

                    <td>{{ $row->qty }}</td>

                    <td>{{ number_format($row->unit_price, 2) }}</td>

                    <td>
                        {{ $row->unit->unit_name ?? $row->unit->name ?? $row->unit_id }}
                    </td>

                    <td class="text-right">
                        {{ number_format($row->qty * $row->unit_price, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTALS -->
    <div class="totals">
        <table>
            <tr>
                <td><strong>Total</strong></td>
                <td class="text-right">{{ number_format($purchase->total_amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Paid</strong></td>
                <td class="text-right">{{ number_format($purchase->paid_amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Due</strong></td>
                <td class="text-right">{{ number_format($purchase->due_amount, 2) }}</td>
            </tr>
        </table>
    </div>

</body>
</html>