@extends('masterlayout.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Product Information</h3>
        </div>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Global Errors --}}
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

                {{-- BASIC INFO --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="product_name" value="{{ old('product_name') }}"
                            class="form-control @error('product_name') is-invalid @enderror">
                        @error('product_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Code</label>
                        <input type="text" name="product_code" value="{{ old('product_code') }}"
                            class="form-control @error('product_code') is-invalid @enderror">
                        @error('product_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- CATEGORY + SUPPLIER --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select name="cat_id" class="form-select select2 @error('cat_id') is-invalid @enderror">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('cat_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->cat_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('cat_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Supplier</label>
                        <select name="supp_id" class="form-select select2 @error('supp_id') is-invalid @enderror">
                            <option value="">-- Select Supplier --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supp_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->supp_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supp_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- BRAND + UNIT --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Brand</label>
                        <input type="text" name="brand" value="{{ old('brand') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Unit</label>
                        <select name="unit" class="form-select">
                            <option value="pcs">Pieces</option>
                            <option value="kg">Kilogram</option>
                            <option value="box">Box</option>
                            <option value="liter">Liter</option>
                        </select>
                    </div>
                </div>

                {{-- PRICING --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cost Price</label>
                        <input type="number" step="0.01" name="cost_price" value="{{ old('cost_price') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sell Price</label>
                        <input type="number" step="0.01" name="sell_price" value="{{ old('sell_price') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">VAT (%)</label>
                        <input type="number" step="0.01" name="vat" value="{{ old('vat', 0) }}"
                            class="form-control">
                    </div>
                </div>

                {{-- BARCODE + LOCATION --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Barcode</label>
                        <input type="text" name="barcode" value="{{ old('barcode') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" value="{{ old('location') }}"
                            class="form-control">
                    </div>
                </div>

                {{-- STOCK --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Min Stock</label>
                        <input type="number" name="min_stock" value="{{ old('min_stock', 0) }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Max Stock</label>
                        <input type="number" name="max_stock" value="{{ old('max_stock') }}"
                            class="form-control">
                    </div>
                </div>

                {{-- EXPIRY + STATUS --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Expiry Date</label>
                        <input type="date" name="expiry_date" value="{{ old('expiry_date') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6 mb-3 d-flex align-items-center">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label">Active Product</label>
                        </div>
                    </div>
                </div>

                {{-- DESCRIPTION --}}
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                </div>

                {{-- IMAGE --}}
                <div class="mb-3">
                    <label class="form-label">Upload Image</label>
                    <input type="file" name="product_image"
                        class="dropify"
                        accept="image/*"
                        data-max-file-size="2M"
                        data-allowed-file-extensions="jpg jpeg png">
                </div>

            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Dropify
    $('.dropify').dropify();

    // Select2
    $('.select2').select2({
        placeholder: 'Select an option',
        allowClear: true,
        width: '100%'
    });

    // Auto profit calculation
    const cost = document.querySelector('[name="cost_price"]');
    const sell = document.querySelector('[name="sell_price"]');

    function calculateProfit() {
        let profit = (parseFloat(sell.value || 0) - parseFloat(cost.value || 0));
        console.log("Profit:", profit);
    }

    cost.addEventListener('input', calculateProfit);
    sell.addEventListener('input', calculateProfit);
</script>
@endsection