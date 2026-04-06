@extends('masterlayout.master')

@section('content')
<div class="container-fluid py-3 pos-page">
    <div class="row g-3">

        {{-- LEFT SIDE --}}
        <div class="col-lg-8">
            <div class="card pos-card mb-3">
                <div class="card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Purchase No</label>
                            <input type="text" class="form-control pos-input" value="{{ $purchase_no ?? 'AUTO' }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Supplier</label>
                            <select id="supplier_id" class="form-control pos-input">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers ?? [] as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->supp_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-bold">Scan Barcode</label>
                            <input type="text" id="barcodeInput" class="form-control pos-input"
                                   placeholder="Scan or type barcode and press Enter">
                        </div>
                    </div>
                </div>
            </div>

            {{-- CATEGORY BAR --}}
            <div class="card pos-card mb-3">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2 category-wrap">
                        <button type="button" class="btn btn-category active" onclick="filterProducts('all', this)">All</button>
                        @foreach($categories ?? [] as $category)
                            <button type="button"
                                    class="btn btn-category"
                                    onclick="filterProducts('{{ $category->id }}', this)">
                                {{ $category->cat_name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- PRODUCT GRID --}}
            <div class="card pos-card">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Products</h5>
                        <input type="text" id="productSearch" class="form-control search-box" placeholder="Search product...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3" id="productGrid">
                        @foreach($products ?? [] as $product)
                            <div class="col-md-4 col-xl-3 product-item"
                                 data-category="{{ $product->cat_id ?? '' }}"
                                 data-name="{{ strtolower($product->product_name ?? '') }}"
                                 data-barcode="{{ $product->barcode ?? $product->item_code ?? '' }}">
                                <div class="product-card"
                                     onclick="addToCart({
                                        id: '{{ $product->id }}',
                                        name: @js($product->product_name ?? 'Product'),
                                        price: '{{ $product->buy_price ?? $product->item_cost ?? 0 }}',
                                        category_id: '{{ $product->cat_id ?? '' }}',
                                        unit_id: '{{ $product->unit_id ?? '' }}',
                                        barcode: @js($product->barcode ?? $product->item_code ?? '')
                                     })">
                                    <div class="product-icon">📦</div>
                                    <div class="product-name">{{ $product->product_name ?? 'Product' }}</div>
                                    <div class="product-price">{{ number_format((float)($product->buy_price ?? $product->item_cost ?? 0), 2) }}</div>
                                    <div class="product-code">{{ $product->barcode ?? $product->item_code ?? '' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE / CART --}}
        <div class="col-lg-4">
            <div class="card pos-card cart-card">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">Purchase Cart</h5>
                </div>

                <div class="card-body">
                    <div class="cart-table-wrap">
                        <table class="table align-middle cart-table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th width="110">Qty</th>
                                    <th width="90">Price</th>
                                    <th width="90">Total</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody id="cartBody">
                                <tr id="emptyCartRow">
                                    <td colspan="5" class="text-center text-muted py-4">No items yet</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <div class="mb-2 d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong id="grandTotal">0.00</strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Paid Amount</label>
                        <input type="number" id="paidAmount" class="form-control pos-input" step="0.01" min="0" value="0" oninput="updateDueAmount()">
                    </div>

                    <div class="mb-3 d-flex justify-content-between">
                        <strong>Due Amount</strong>
                        <strong id="dueAmount" class="text-danger">0.00</strong>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-success pos-action-btn" onclick="savePurchase()">
                            Save Purchase
                        </button>
                        <button class="btn btn-warning pos-action-btn" onclick="clearCart()">
                            Clear Cart
                        </button>
                        <button class="btn btn-dark pos-action-btn" onclick="window.print()">
                            Print
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<form id="purchaseSubmitForm" action="{{ route('purchase.store') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="purchase_id" value="{{ $purchase_no ?? '' }}">
    <input type="hidden" name="supp_id" id="hidden_supp_id">
    <input type="hidden" name="paid_amount" id="hidden_paid_amount">
    <input type="hidden" name="total" id="hidden_total">
    <div id="hiddenInputsContainer"></div>
</form>
@endsection

@section('styles')
<style>
    .pos-page {
        background: #f4f6f9;
        min-height: 100vh;
    }

    .pos-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    .pos-input {
        min-height: 52px;
        border-radius: 14px;
        font-size: 16px;
    }

    .category-wrap {
        overflow-x: auto;
    }

    .btn-category {
        border-radius: 14px;
        padding: 12px 20px;
        border: 1px solid #dbe2ea;
        background: #fff;
        font-weight: 700;
        min-height: 52px;
    }

    .btn-category.active {
        background: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }

    .search-box {
        max-width: 240px;
        border-radius: 12px;
        min-height: 44px;
    }

    .product-card {
        background: #fff;
        border: 1px solid #e8edf3;
        border-radius: 18px;
        padding: 16px;
        text-align: center;
        cursor: pointer;
        transition: 0.2s ease;
        height: 100%;
        min-height: 170px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
    }

    .product-icon {
        font-size: 34px;
        margin-bottom: 10px;
    }

    .product-name {
        font-weight: 700;
        font-size: 15px;
        margin-bottom: 6px;
    }

    .product-price {
        color: #0d6efd;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .product-code {
        font-size: 12px;
        color: #6b7280;
        word-break: break-all;
    }

    .cart-card {
        position: sticky;
        top: 16px;
    }

    .cart-table-wrap {
        max-height: 420px;
        overflow-y: auto;
    }

    .cart-table th {
        font-size: 13px;
        white-space: nowrap;
    }

    .qty-box {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .qty-btn {
        width: 30px;
        height: 30px;
        border: none;
        border-radius: 8px;
        font-weight: 700;
    }

    .qty-value {
        min-width: 28px;
        text-align: center;
        font-weight: 700;
    }

    .pos-action-btn {
        min-height: 52px;
        border-radius: 14px;
        font-size: 16px;
        font-weight: 700;
    }

    @media (max-width: 991px) {
        .cart-card {
            position: static;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    let cart = [];

    function filterProducts(categoryId, btn) {
        $('.btn-category').removeClass('active');
        $(btn).addClass('active');

        $('.product-item').each(function () {
            const itemCategory = $(this).data('category');

            if (categoryId === 'all' || String(itemCategory) === String(categoryId)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $('#productSearch').on('input', function () {
        const search = $(this).val().toLowerCase();

        $('.product-item').each(function () {
            const name = ($(this).data('name') || '').toLowerCase();
            const barcode = String($(this).data('barcode') || '').toLowerCase();

            if (name.includes(search) || barcode.includes(search)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $('#barcodeInput').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();

            const barcode = $(this).val().trim().toLowerCase();
            if (!barcode) return;

            let found = false;

            $('.product-item').each(function () {
                const itemBarcode = String($(this).data('barcode') || '').toLowerCase();

                if (itemBarcode === barcode) {
                    $(this).find('.product-card').click();
                    found = true;
                    return false;
                }
            });

            if (!found) {
                alert('Product not found for barcode: ' + barcode);
            }

            $(this).val('');
        }
    });

    function addToCart(product) {
        const existing = cart.find(x => String(x.id) === String(product.id));

        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: parseFloat(product.price) || 0,
                qty: 1,
                category_id: product.category_id || '',
                unit_id: product.unit_id || '',
                barcode: product.barcode || ''
            });
        }

        renderCart();
    }

    function renderCart() {
        const body = $('#cartBody');
        body.html('');

        if (cart.length === 0) {
            body.html(`<tr id="emptyCartRow"><td colspan="5" class="text-center text-muted py-4">No items yet</td></tr>`);
            updateTotals();
            return;
        }

        cart.forEach((item, index) => {
            const total = item.qty * item.price;

            body.append(`
                <tr>
                    <td>
                        <div class="fw-bold">${item.name}</div>
                        <small class="text-muted">${item.barcode || ''}</small>
                    </td>
                    <td>
                        <div class="qty-box">
                            <button type="button" class="qty-btn btn-secondary" onclick="changeQty(${index}, -1)">-</button>
                            <span class="qty-value">${item.qty}</span>
                            <button type="button" class="qty-btn btn-primary text-white" onclick="changeQty(${index}, 1)">+</button>
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm"
                               value="${item.price}"
                               min="0"
                               step="0.01"
                               onchange="changePrice(${index}, this.value)">
                    </td>
                    <td class="fw-bold">${total.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(${index})">X</button>
                    </td>
                </tr>
            `);
        });

        updateTotals();
    }

    function changeQty(index, diff) {
        cart[index].qty += diff;
        if (cart[index].qty <= 0) {
            cart.splice(index, 1);
        }
        renderCart();
    }

    function changePrice(index, value) {
        cart[index].price = parseFloat(value) || 0;
        renderCart();
    }

    function removeItem(index) {
        cart.splice(index, 1);
        renderCart();
    }

    function updateTotals() {
        let total = 0;
        cart.forEach(item => total += item.qty * item.price);

        $('#grandTotal').text(total.toFixed(2));
        updateDueAmount();
    }

    function updateDueAmount() {
        const total = parseFloat($('#grandTotal').text()) || 0;
        const paid = parseFloat($('#paidAmount').val()) || 0;
        const due = Math.max(total - paid, 0);

        $('#dueAmount').text(due.toFixed(2));
    }

    function clearCart() {
        if (confirm('Clear all cart items?')) {
            cart = [];
            renderCart();
        }
    }

    function savePurchase() {
        if (cart.length === 0) {
            alert('Please add at least one item.');
            return;
        }

        const supplierId = $('#supplier_id').val();
        if (!supplierId) {
            alert('Please select supplier.');
            $('#supplier_id').focus();
            return;
        }

        const total = parseFloat($('#grandTotal').text()) || 0;
        const paid = parseFloat($('#paidAmount').val()) || 0;

        $('#hidden_supp_id').val(supplierId);
        $('#hidden_paid_amount').val(paid);
        $('#hidden_total').val(total);

        const container = $('#hiddenInputsContainer');
        container.html('');

        cart.forEach(item => {
            container.append(`<input type="hidden" name="cat_id[]" value="${item.category_id}">`);
            container.append(`<input type="hidden" name="product_id[]" value="${item.id}">`);
            container.append(`<input type="hidden" name="unit[]" value="${item.unit_id}">`);
            container.append(`<input type="hidden" name="quantity[]" value="${item.qty}">`);
            container.append(`<input type="hidden" name="price[]" value="${item.price}">`);
            container.append(`<input type="hidden" name="line_total[]" value="${(item.qty * item.price).toFixed(2)}">`);
        });

        $('#purchaseSubmitForm').submit();
    }

    renderCart();
</script>
@endsection