@extends('masterlayout.master')

@section('content')
<div class="container-fluid py-4 purchase-show-page">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-1">Purchase</h2>
            <small class="text-muted">View purchase details</small>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('purchase.index') }}" class="btn btn-light border">Back</a>

            <a href="{{ route('purchase.edit', $purchase->id) }}" class="btn btn-primary">
                Edit
            </a>

            <a href="{{ route('purchase.pdf', $purchase->id) }}" class="btn btn-dark">
                Download PDF
            </a>
        </div>
    </div>

    {{-- STATUS --}}
    @php
        $paid = (float) $purchase->paid_amount;
        $due = (float) $purchase->due_amount;

        if ($due <= 0) {
            $status = 'Paid';
            $color = 'success';
        } elseif ($paid > 0) {
            $status = 'Partial';
            $color = 'warning';
        } else {
            $status = 'Due';
            $color = 'danger';
        }
    @endphp

    {{-- HEADER CARD --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-3">
                    <small class="text-muted">Purchase No</small>
                    <div class="fw-bold">{{ $purchase->purchase_no }}</div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Supplier</small>
                    <div class="fw-bold">{{ $purchase->supplier->supp_name ?? '-' }}</div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Date</small>
                    <div class="fw-bold">
                        {{ $purchase->created_at->format('d M Y H:i') }}
                    </div>
                </div>

                <div class="col-md-3">
                    <small class="text-muted">Status</small><br>
                    <span class="badge bg-{{ $color }} px-3 py-2">
                        {{ $status }}
                    </span>
                </div>

            </div>

        </div>
    </div>

    {{-- ITEMS --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">Purchase Lines</h5>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($purchase->metas as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    {{ $row->category->cat_name ?? $row->category_id }}
                                </td>

                                <td>{{ $row->qty }}</td>

                                <td>
                                    {{ $row->unit->unit_name ?? $row->unit_id }}
                                </td>

                                <td>{{ number_format($row->unit_price, 2) }}</td>

                                <td class="fw-bold">
                                    {{ number_format($row->qty * $row->unit_price, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    No items found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- TOTALS --}}
            <div class="row justify-content-end mt-4">
                <div class="col-md-4">

                    <table class="table">
                        <tr>
                            <th>Total</th>
                            <td class="text-end">
                                {{ number_format($purchase->total_amount, 2) }}
                            </td>
                        </tr>

                        <tr>
                            <th>Paid</th>
                            <td class="text-end text-success">
                                {{ number_format($purchase->paid_amount, 2) }}
                            </td>
                        </tr>

                        <tr>
                            <th>Due</th>
                            <td class="text-end text-danger">
                                {{ number_format($purchase->due_amount, 2) }}
                            </td>
                        </tr>
                    </table>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('styles')
<style>
.purchase-show-page {
    background: #f6f8fb;
    min-height: 100vh;
}

.card {
    border-radius: 12px;
}

.table td, .table th {
    padding: 10px;
}

.badge {
    font-size: 13px;
}
</style>
@endsection