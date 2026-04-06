@extends('masterlayout.master')

@section('content')
<div class="container-fluid py-4 purchase-page">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="page-title mb-1">Purchases</h2>
            <div class="page-subtitle">Manage supplier purchases, payments, and due balances</div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('purchase.create') }}" class="btn btn-primary btn-odoo">
                <i class="fas fa-plus me-1"></i> New Purchase
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-label">Total Purchases</div>
                <div class="stat-value">{{ $totalPurchases }}</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-label">Total Amount</div>
                <div class="stat-value">{{ number_format($totalAmount, 2) }}</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-label">Total Paid</div>
                <div class="stat-value text-success">{{ number_format($totalPaid, 2) }}</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-label">Total Due</div>
                <div class="stat-value text-danger">{{ number_format($totalDue, 2) }}</div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card odoo-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('purchase.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Search</label>
                        <input
                            type="text"
                            name="search"
                            class="form-control odoo-input"
                            placeholder="Search by purchase no, supplier, amount..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Payment Status</label>
                        <select name="payment_status" class="form-select odoo-input">
                            <option value="">All</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="due" {{ request('payment_status') == 'due' ? 'selected' : '' }}>Due</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark w-100">Filter</button>
                            <a href="{{ route('purchase.index') }}" class="btn btn-light w-100 border">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm border-0 rounded-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- Purchase List --}}
    <div class="card odoo-card">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Purchase Orders</h5>
                <span class="text-muted small">{{ $purchases->total() }} record(s)</span>
            </div>
        </div>

        <div class="card-body pt-2">
            <div class="table-responsive">
                <table class="table align-middle purchase-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Purchase No</th>
                            <th>Supplier</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($purchases as $index => $purchase)
                            @php
                                $paid = (float) $purchase->paid_amount;
                                $due = (float) $purchase->due_amount;

                                if ($due <= 0) {
                                    $status = 'Paid';
                                    $badgeClass = 'bg-success-subtle text-success';
                                } elseif ($paid > 0 && $due > 0) {
                                    $status = 'Partial';
                                    $badgeClass = 'bg-warning-subtle text-warning';
                                } else {
                                    $status = 'Due';
                                    $badgeClass = 'bg-danger-subtle text-danger';
                                }
                            @endphp

                            <tr>
                                <td>{{ $purchases->firstItem() + $index }}</td>

                                <td>
                                    <div class="fw-semibold text-dark">{{ $purchase->purchase_no }}</div>
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $purchase->supplier->supp_name ?? 'N/A' }}</div>
                                </td>

                                <td class="fw-semibold">{{ number_format($purchase->total_amount, 2) }}</td>
                                <td class="text-success fw-semibold">{{ number_format($purchase->paid_amount, 2) }}</td>
                                <td class="text-danger fw-semibold">{{ number_format($purchase->due_amount, 2) }}</td>

                                <td>
                                    <span class="badge rounded-pill px-3 py-2 {{ $badgeClass }}">
                                        {{ $status }}
                                    </span>
                                </td>

                                <td>
                                    <div>{{ $purchase->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $purchase->created_at->format('h:i A') }}</small>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <a href="{{ route('purchase.show', $purchase->id) }}" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>

                                        <a href="{{ route('purchase.edit', $purchase->id) }}" class="btn btn-sm btn-outline-secondary">
                                            Edit
                                        </a>

                                        <form action="{{ route('purchase.destroy', $purchase->id) }}" method="POST" onsubmit="return confirm('Delete this purchase?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state text-center py-5">
                                        <div class="empty-icon mb-3">📦</div>
                                        <h5 class="fw-bold">No purchases found</h5>
                                        <p class="text-muted mb-3">Start by creating your first purchase record.</p>
                                        <a href="{{ route('purchase.create') }}" class="btn btn-primary btn-odoo">
                                            Create Purchase
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($purchases->hasPages())
                <div class="pt-3">
                    {{ $purchases->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .purchase-page {
        background: #f6f8fb;
        min-height: 100vh;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    .btn-odoo {
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.12);
    }

    .odoo-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .stat-card {
        background: #fff;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        height: 100%;
        border: 1px solid #eef2f7;
    }

    .stat-label {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
    }

    .odoo-input {
        border-radius: 12px;
        min-height: 46px;
        border: 1px solid #dbe2ea;
        box-shadow: none;
    }

    .odoo-input:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.12);
    }

    .purchase-table thead th {
        background: #f9fafb;
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
        padding: 14px 12px;
    }

    .purchase-table tbody td {
        padding: 14px 12px;
        vertical-align: middle;
        border-color: #eef2f7;
    }

    .purchase-table tbody tr:hover {
        background: #fafcff;
    }

    .empty-state .empty-icon {
        font-size: 42px;
    }

    .bg-success-subtle {
        background: rgba(25, 135, 84, 0.12);
    }

    .bg-warning-subtle {
        background: rgba(255, 193, 7, 0.15);
    }

    .bg-danger-subtle {
        background: rgba(220, 53, 69, 0.12);
    }
</style>
@endsection