@extends('masterlayout.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Edit Product</h3>
        </div>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                <!-- Product Name -->
                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}"
                        class="form-control @error('product_name') is-invalid @enderror">
                    @error('product_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Product Code -->
                <div class="mb-3">
                    <label class="form-label">Product Code</label>
                    <input type="text" name="product_code" value="{{ old('product_code', $product->product_code) }}"
                        class="form-control @error('product_code') is-invalid @enderror">
                    @error('product_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="cat_id" class="form-select select2 @error('cat_id') is-invalid @enderror">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('cat_id', $product->cat_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->cat_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cat_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Supplier -->
                <div class="mb-3">
                    <label class="form-label">Supplier</label>
                    <select name="supp_id" class="form-select select2 @error('supp_id') is-invalid @enderror">
                        <option value="">-- Select Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supp_id', $product->supp_id) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->supp_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supp_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Brand -->
                <div class="mb-3">
                    <label class="form-label">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}"
                        class="form-control @error('brand') is-invalid @enderror">
                    @error('brand') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Product Image -->
                <div class="mb-3">
                    <label class="form-label">Upload Image</label>
                    <input type="file" name="product_image" class="dropify @error('product_image') is-invalid @enderror"
                        accept="image/*" data-default-file="{{ asset('upload/' . $product->product_image) }}">
                    @error('product_image') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('.dropify').dropify();
    $('.select2').select2({
        placeholder: 'Select an option',
        allowClear: true,
        width: '100%'
    });
</script>
@endsection