@extends('masterlayout.master')

@section('content')

<div class="container-fluid mt-4">
    <div class="card">

        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Purchase Form</h3>
        </div>

        <!-- Form -->
        <form action="{{ route('purchase.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Errors -->
            @if ($errors->any())
                <div class="alert alert-danger mx-3 mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">

                <!-- Purchase ID -->
                <div class="mb-3">
                    <label class="form-label">Purchase Id</label>
                    <input type="text" name="purchase_id" id="purchase_id" class="form-control" readonly value="{{ $purchase_no }}">
                    @error('purchase_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Supplier -->
                <div class="mb-3">
                    <label class="form-label">Supplier</label>
                    <select name="supp_id" id="supp_id" class="form-control">
                        <option value="">Select Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->supp_name }}</option>
                        @endforeach
                    </select>
                    @error('supp_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Paid Amount -->
                <div class="mb-3">
                    <label class="form-label">Paid Amount</label>
                    <input type="text" name="paid_amount" id="paid_amount" class="form-control">
                    @error('paid_amount')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Items Table -->
                <div class="col-12">
                    <table class="table table-bordered table-striped" id="purchaseTable">
                        <thead>
                            <tr>
                                <th class="text-center">Category</th>
                                <th class="text-center">Product</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">
                                    <button type="button" onclick="cloneRow()" id="addRow" class="btn btn-success btn-sm">
                                        <i class="fas fa-plus">+</i>
                                    </button>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="tbody">
                            <tr class="tr">
                                <td>
                                    <select name="cat_id[]" class="form-control" id="cat_1" onchange="loadProducts(this)">
                                        <option value="">Select category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <select name="product_id[]" class="form-control" id="product_1">
                                        <option value="">Select Product</option>
                                    </select>
                                </td>

                                <td>
                                    <select name="unit[]" class="form-control" id="unit_1">
                                        <option value="">Select Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">
                                                {{ $unit->unit_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input type="number" name="quantity[]" id="quantity_1" class="form-control" min="1" value="1" oninput="calc_total(this)">
                                </td>

                                <td>
                                    <input type="number" name="price[]" id="price_1" class="form-control" step="0.01" min="0" oninput="calc_total(this)">
                                </td>

                                <td>
                                    <input type="number" name="line_total[]" class="form-control" step="0.01" min="0" readonly id="total_1">
                                </td>

                                <td class="text-center">
                                    <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">X</button>
                                </td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end">Total</th>
                                <th>
                                    <input type="number" name="total" id="grand_total" class="form-control" step="0.01" min="0" readonly>
                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>

            <!-- Footer -->
            <div class="card-footer d-flex justify-content-end gap-2">
                
                <a href="#" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Purchase</button>
            </div>

        </form>
    </div>
</div>

@endsection



@section('scripts')

<script>
    let count = 2;
    let isRestoringDraft = false;
    let formChanged = false;
    const draftKey = 'purchase_form_draft';

    function cloneRow(rowData = null) {
        const rowNumber = count;

        const tr = `
            <tr class="tr">
                <td>
                    <select name="cat_id[]" class="form-control" id="cat_${rowNumber}" onchange="loadProducts(this)">
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->cat_name }}
                            </option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <select name="product_id[]" class="form-control" id="product_${rowNumber}">
                        <option value="">Select Product</option>
                    </select>
                </td>

                <td>
                    <select name="unit[]" class="form-control" id="unit_${rowNumber}">
                        <option value="">Select Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">
                                {{ $unit->unit_name }}
                            </option>
                        @endforeach
                    </select>
                </td>

                <td>
                    <input type="number" name="quantity[]" id="quantity_${rowNumber}" class="form-control" min="1" value="1" oninput="calc_total(this)">
                </td>

                <td>
                    <input type="number" name="price[]" id="price_${rowNumber}" class="form-control" step="0.01" min="0" oninput="calc_total(this)">
                </td>

                <td>
                    <input type="number" name="line_total[]" class="form-control" step="0.01" min="0" readonly id="total_${rowNumber}">
                </td>

                <td class="text-center">
                    <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">X</button>
                </td>
            </tr>
        `;

        $('#purchaseTable tbody').append(tr);

        if (rowData) {
            $('#cat_' + rowNumber).val(rowData.cat_id || '');
            $('#unit_' + rowNumber).val(rowData.unit || '');
            $('#quantity_' + rowNumber).val(rowData.quantity || 1);
            $('#price_' + rowNumber).val(rowData.price || 0);

            if (rowData.cat_id) {
                loadProducts($('#cat_' + rowNumber)[0], rowData.product_id);
            }

            calc_total($('#price_' + rowNumber)[0]);
        }

        count++;
    }

    function removeRow(btn) {
        let row = $(btn).closest('tr');
        let table = $('#purchaseTable tbody');

        if (table.find('tr').length > 1) {
            row.remove();
            calculateGrandTotal();
            savePurchaseDraft();
        } else {
            alert('At least one row is required');
        }
    }

    function loadProducts(catSelect, selectedProductId = null) {
        const catId = $(catSelect).val();
        const rowId = $(catSelect).attr('id').split('_')[1];
        const productSelect = $('#product_' + rowId);

        productSelect.html('<option value="">Loading...</option>');

        if (!catId) {
            productSelect.html('<option value="">Select Product</option>');
            savePurchaseDraft();
            return;
        }

        $.ajax({
            url: '/products/by-category/' + catId,
            type: 'GET',
            success: function(products) {
                let options = '<option value="">Select Product</option>';

                products.forEach(function(product) {
                    options += `<option value="${product.id}">${product.product_name}</option>`;
                });

                productSelect.html(options);

                if (selectedProductId) {
                    productSelect.val(selectedProductId);
                }

                savePurchaseDraft();
            },
            error: function() {
                productSelect.html('<option value="">No products found</option>');
            }
        });
    }

    function calc_total(btn_cal) {
        const id = $(btn_cal).attr('id');
        const num = id.split('_')[1];

        const quantity = parseFloat($('#quantity_' + num).val()) || 0;
        const price = parseFloat($('#price_' + num).val()) || 0;
        const total = quantity * price;

        $('#total_' + num).val(total.toFixed(2));

        calculateGrandTotal();
        savePurchaseDraft();
    }

    function calculateGrandTotal() {
        let grand = 0;

        $('[id^="total_"]').each(function () {
            grand += parseFloat($(this).val()) || 0;
        });

        $('#grand_total').val(grand.toFixed(2));
    }

    function getPurchaseDraftData() {
        let rows = [];

        $('#purchaseTable tbody tr').each(function () {
            const row = $(this);
            rows.push({
                cat_id: row.find('select[name="cat_id[]"]').val(),
                product_id: row.find('select[name="product_id[]"]').val(),
                unit: row.find('select[name="unit[]"]').val(),
                quantity: row.find('input[name="quantity[]"]').val(),
                price: row.find('input[name="price[]"]').val(),
                line_total: row.find('input[name="line_total[]"]').val()
            });
        });

        return {
            purchase_id: $('#purchase_id').val(),
            supp_id: $('#supp_id').val(),
            paid_amount: $('#paid_amount').val(),
            total: $('#grand_total').val(),
            rows: rows
        };
    }

    function savePurchaseDraft() {
        if (isRestoringDraft) return;

        const data = getPurchaseDraftData();
        localStorage.setItem(draftKey, JSON.stringify(data));
        formChanged = true;
    }

    function restorePurchaseDraft() {
        const saved = localStorage.getItem(draftKey);

        if (!saved) return;

        const draft = JSON.parse(saved);

        if (!draft || !draft.rows || draft.rows.length === 0) return;

        if (!confirm('A saved draft was found. Do you want to restore it?')) {
            return;
        }

        isRestoringDraft = true;

        $('#supp_id').val(draft.supp_id || '');
        $('#paid_amount').val(draft.paid_amount || '');

        $('#purchaseTable tbody').html('');
        count = 1;

        draft.rows.forEach(function (row) {
            if (count === 1) {
                const firstRow = `
                    <tr class="tr">
                        <td>
                            <select name="cat_id[]" class="form-control" id="cat_1" onchange="loadProducts(this)">
                                <option value="">Select category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->cat_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <select name="product_id[]" class="form-control" id="product_1">
                                <option value="">Select Product</option>
                            </select>
                        </td>

                        <td>
                            <select name="unit[]" class="form-control" id="unit_1">
                                <option value="">Select Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">
                                        {{ $unit->unit_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <input type="number" name="quantity[]" id="quantity_1" class="form-control" min="1" value="1" oninput="calc_total(this)">
                        </td>

                        <td>
                            <input type="number" name="price[]" id="price_1" class="form-control" step="0.01" min="0" oninput="calc_total(this)">
                        </td>

                        <td>
                            <input type="number" name="line_total[]" class="form-control" step="0.01" min="0" readonly id="total_1">
                        </td>

                        <td class="text-center">
                            <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">X</button>
                        </td>
                    </tr>
                `;
                $('#purchaseTable tbody').append(firstRow);

                $('#cat_1').val(row.cat_id || '');
                $('#unit_1').val(row.unit || '');
                $('#quantity_1').val(row.quantity || 1);
                $('#price_1').val(row.price || 0);

                if (row.cat_id) {
                    loadProducts($('#cat_1')[0], row.product_id);
                }

                calc_total($('#price_1')[0]);
                count = 2;
            } else {
                cloneRow(row);
            }
        });

        calculateGrandTotal();
        isRestoringDraft = false;
    }

    function clearPurchaseDraft() {
        if (confirm('Are you sure you want to clear the saved draft?')) {
            localStorage.removeItem(draftKey);
            formChanged = false;
            location.reload();
        }
    }

    // auto save on normal fields
    $(document).on('change keyup', '#supp_id, #paid_amount, #purchaseTable select, #purchaseTable input', function () {
        savePurchaseDraft();
    });

    // warn before leaving if not saved
    window.addEventListener('beforeunload', function (e) {
        if (formChanged && localStorage.getItem(draftKey)) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // clear draft after successful save
    @if(session('success'))
        localStorage.removeItem(draftKey);
        formChanged = false;
    @endif

    // restore on page load
    $(document).ready(function () {
        restorePurchaseDraft();
    });
</script>

@endsection

