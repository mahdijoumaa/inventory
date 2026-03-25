@extends('masterlayout.master')

@section('content')

<div class="card card-primary card-outline mb-4">

    <!-- Card Header -->
    <div class="card-header">
        <h3 class="card-title">Add Supplier</h3>
    </div>

    <!-- Form Start -->
    <form action="{{ route('supplier.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 🔴 Global Errors -->
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

            <!-- Supplier Name -->
            <div class="mb-3">
                <label class="form-label">Supplier Name</label>
                <input type="text"
                       name="supp_name"
                       value="{{ old('supp_name') }}"
                       class="form-control @error('supp_name') is-invalid @enderror"
                       placeholder="Enter supplier name">

                @error('supp_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Supplier Email -->
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email"
                       name="supp_email"
                       value="{{ old('supp_email') }}"
                       class="form-control @error('supp_email') is-invalid @enderror"
                       placeholder="Enter email">

                @error('supp_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Supplier Phone -->
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text"
                       name="supp_phone"
                       value="{{ old('supp_phone') }}"
                       class="form-control @error('supp_phone') is-invalid @enderror"
                       placeholder="Enter phone number">

                @error('supp_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Supplier Address -->
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text"
                       name="supp_address"
                       value="{{ old('supp_address') }}"
                       class="form-control @error('supp_address') is-invalid @enderror"
                       placeholder="Enter address">

                @error('supp_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Supplier Image -->
            <div class="mb-3">
                <label class="form-label">Upload Image</label>
                <input type="file"
                       name="supp_image"
                       class="form-control @error('supp_image') is-invalid @enderror"
                       accept="image/*">

                @error('supp_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <!-- Card Footer -->
        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Supplier</button>
        </div>

    </form>
</div>

@endsection