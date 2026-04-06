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

                    <div class="card-body">

                        <!-- Purchase ID -->
                        <div class="mb-3">
                            <label class="form-label">Purchase Id</label>
                            <input type="text" name="purchase_id" id="purchase_id" class="form-control" readonly
                                value="{{ $purchase_no }}">

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
                                    <option value="{{ $supplier->id }}">
                                        {{ $supplier->supp_name }}
                                    </option>
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
                                            <button type="button" onclick="cloneRow()" id="addRow"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-plus">+</i>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="tbody">
                                    <tr class="tr">
                                        <td>
                                            <select name="cat_id[]" class="form-control" id="cat_1">
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
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->cat_name }}
                                                    </option>
                                                @endforeach
                                            </select>



                                        </td>

                                        <td>
                                            <select name="unit[]" class="form-control">
                                                <option value="" id="unit_1">Select Unit</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">
                                                        {{ $unit->unit_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <input type="number" name="quantity[]" id="quantity_1" class="form-control" min="1" value="1" onkeyup="calc_total(this)">
                                        </td>

                                        <td>
                                            <input type="number" name="price[]" id="price_1" class="form-control" step="0.01" min="0" onkeyup="calc_total(this)">
                                        </td>

                                        <td>
                                            <input type="number" name="line_total[]" class="form-control" step="0.01"
                                                min="0" readonly id="totat_1">
                                        </td>

                                        <td class="text-center">
                                            <button type="button" onclick="removeRow(this)"
                                                class="btn btn-danger btn-sm">X</button>
                                        </td>
                                    </tr>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-end">Total</th>
                                        <th>
                                            <input type="number" name="total" id="grand_total" class="form-control" step="0.01"
                                                min="0" readonly>
                                           
                                                
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
                        <button type="submit" class="btn btn-primary">Save Category</button>
                    </div>

            </form>
        </div>
    </div>

@endsection


@section('scripts')

    <script>

        let count =2;

        function cloneRow() {

            const tr = `


                    <tr class="tr">
                                        <td>
                                            <select name="cat_id[]" class="form-control" id="cat_${count}">
                                                <option value="">Select category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->cat_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>



                                            <select name="product_id[]" class="form-control" id="product_${count}">
                                                <option value="">Select Product</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->cat_name }}
                                                    </option>
                                                @endforeach
                                            </select>



                                        </td>

                                        <td>
                                            <select name="unit[]" class="form-control">
                                                <option value="" id="unit_${count}">Select Unit</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">
                                                        {{ $unit->unit_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <input type="number" name="quantity[]" id="quantity_${count}" class="form-control" min="1" value="1" onkeyup="calc_total(this)">
                                        </td>

                                        <td>
                                            <input type="number" name="price[]" id="price_${count}" class="form-control" step="0.01" min="0" onkeyup="calc_total(this)">
                                        </td>

                                        <td>
                                            <input type="number" name="line_total[]" class="form-control" step="0.01"
                                                min="0" readonly id="totat_${count}">
                                        </td>

                                        <td class="text-center">
                                            <button type="button" onclick="removeRow(this)"
                                                class="btn btn-danger btn-sm">X</button>
                                        </td>
                                    </tr>


                    `;

            $('#purchaseTable tbody').append(tr);


                                count++;


        }

        function removeRow(btn) {
            let row = $(btn).closest('tr');
            let table = $('#purchaseTable tbody');

            if (table.find('tr').length > 1) {
                row.remove();
            } else {
                alert('At least one row is required');
            }
        }

   
   
   
   function calc_total(btn_cal)
{
    const id = $(btn_cal).attr('id');
    const num = id.split('_')[1];

    const quantity = parseFloat($('#quantity_' + num).val()) || 0;
    const price = parseFloat($('#price_' + num).val()) || 0;

    const total = quantity * price;

    $('#totat_' + num).val(total.toFixed(2));

    // 🔥 call grand total after each change
    calculateGrandTotal();
}

function calculateGrandTotal()
{
    let grand = 0;

    $('[id^="totat_"]').each(function () {
        grand += parseFloat($(this).val()) || 0;
    });

    $('#grand_total').val(grand.toFixed(2));
}
        


   </script>



@endsection