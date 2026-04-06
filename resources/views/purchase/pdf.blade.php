<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Purchase Invoice</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 0;
            padding: 0;
        }

        .page {
            padding: 28px;
        }

        .header {
            width: 100%;
            margin-bottom: 22px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
            border: none;
        }

        .logo {
            width: 120px;
            height: auto;
        }

        .company-info {
            text-align: right;
        }

        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #111;
            margin-bottom: 5px;
        }

        .company-text {
            font-size: 11px;
            color: #555;
            line-height: 1.6;
        }

        .invoice-title {
            margin-top: 18px;
            margin-bottom: 18px;
            padding: 12px 16px;
            background: #f4f6f8;
            border: 1px solid #e3e7eb;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 1px;
        }

        .info-wrap {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            width: 50%;
            vertical-align: top;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            background: #fafafa;
        }

        .label {
            font-size: 11px;
            color: #666;
            margin-bottom: 4px;
        }

        .value {
            font-size: 13px;
            font-weight: bold;
            color: #111;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        .items-table th {
            background: #1f2937;
            color: #fff;
            font-size: 11px;
            padding: 10px 8px;
            border: 1px solid #d1d5db;
            text-align: left;
        }

        .items-table td {
            border: 1px solid #d1d5db;
            padding: 9px 8px;
            font-size: 11px;
        }

        .items-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .text-right {
            text-align: right;
        }

        .summary-section {
            margin-top: 20px;
        }

        .summary-table {
            width: 320px;
            margin-left: auto;
            border-collapse: collapse;
        }

        .summary-table td {
            border: 1px solid #d1d5db;
            padding: 10px 12px;
            font-size: 12px;
        }

        .summary-table .head {
            background: #f3f4f6;
            font-weight: bold;
        }

        .summary-table .due {
            color: #b91c1c;
            font-weight: bold;
        }

        .footer {
            margin-top: 28px;
            border-top: 1px solid #ddd;
            padding-top: 14px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            vertical-align: top;
            border: none;
        }

        .notes {
            font-size: 11px;
            color: #555;
            line-height: 1.7;
        }

        .qr-box {
            text-align: right;
        }

        .qr-box img,
        .qr-box svg {
            width: 100px;
            height: 100px;
        }

        .small-muted {
            font-size: 10px;
            color: #777;
            margin-top: 6px;
        }
    </style>
</head>
<body>
    <div class="page">

        {{-- HEADER --}}
        <div class="header">
            <table class="header-table">
                <tr>
                    <td style="width: 35%;">
                        <img src="{{ public_path('images/company-logo.png') }}" class="logo" alt="Company Logo">
                    </td>
                    <td class="company-info" style="width: 65%;">
                        <div class="company-name">Your Company Name</div>
                        <div class="company-text">
                            Address Line 1<br>
                            Address Line 2<br>
                            Phone: +233 XX XXX XXXX<br>
                            Email: info@yourcompany.com
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- TITLE --}}
        <div class="invoice-title">
            PURCHASE INVOICE
        </div>

        {{-- INFO --}}
        <div class="info-wrap">
            <table class="info-table">
                <tr>
                    <td>
                        <div class="label">Purchase No</div>
                        <div class="value">{{ $purchase->purchase_no }}</div>
                    </td>
                    <td>
                        <div class="label">Date</div>
                        <div class="value">{{ $purchase->created_at->format('d M Y h:i A') }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label">Supplier</div>
                        <div class="value">{{ $purchase->supplier->supp_name ?? 'N/A' }}</div>
                    </td>
                    <td>
                        <div class="label">Status</div>
                        <div class="value">
                            @php
                                $paid = (float) $purchase->paid_amount;
                                $due = (float) $purchase->due_amount;
                            @endphp

                            @if($due <= 0)
                                Paid
                            @elseif($paid > 0)
                                Partial
                            @else
                                Due
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- ITEMS --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 6%;">#</th>
                    <th style="width: 34%;">Category</th>
                    <th style="width: 12%;">Qty</th>
                    <th style="width: 16%;">Unit</th>
                    <th style="width: 16%;">Unit Price</th>
                    <th style="width: 16%;">Line Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchase->metas as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->category->cat_name ?? $row->category->name ?? $row->category_id }}</td>
                        <td>{{ $row->qty }}</td>
                        <td>{{ $row->unit->unit_name ?? $row->unit->name ?? $row->unit_id }}</td>
                        <td class="text-right">{{ number_format((float) $row->unit_price, 2) }}</td>
                        <td class="text-right">{{ number_format((float) $row->qty * (float) $row->unit_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- TOTALS --}}
        <div class="summary-section">
            <table class="summary-table">
                <tr>
                    <td class="head">Total Amount</td>
                    <td class="text-right">{{ number_format((float) $purchase->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <td class="head">Paid Amount</td>
                    <td class="text-right">{{ number_format((float) $purchase->paid_amount, 2) }}</td>
                </tr>
                <tr>
                    <td class="head">Due Amount</td>
                    <td class="text-right due">{{ number_format((float) $purchase->due_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        {{-- FOOTER --}}
        <div class="footer">
            <table class="footer-table">
                <tr>
                    <td style="width: 70%;">
                        <div class="notes">
                            <strong>Notes:</strong><br>
                            Thank you for your business.<br>
                            This is a system-generated purchase invoice.<br>
                            Please keep this document for your records.
                        </div>
                    </td>
                    <td style="width: 30%;" class="qr-box">
                        <img src="data:image/svg+xml;base64,{{ $qrCode }}">
                        <div class="small-muted">Scan for purchase summary</div>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</body>
</html>