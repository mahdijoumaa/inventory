@extends('masterlayout.master')

@section('content')

<div class="card card-primary card-outline mb-4">

    <!-- Card Header -->
    <div class="card-header">
        <h3 class="card-title">Edit customer</h3>
    </div>

    <!-- Form Start -->
    <form action="{{ route('customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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

            <!-- customer Name -->
            <div class="mb-3">
                <label class="form-label">customer Name</label>
                <input type="text" name="supp_name"
                       value="{{ old('supp_name', $customer->supp_name) }}"
                       class="form-control @error('supp_name') is-invalid @enderror">

                @error('supp_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="supp_email"
                       value="{{ old('supp_email', $customer->supp_email) }}"
                       class="form-control @error('supp_email') is-invalid @enderror">

                @error('supp_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="supp_phone"
                       value="{{ old('supp_phone', $customer->supp_phone) }}"
                       class="form-control @error('supp_phone') is-invalid @enderror">

                @error('supp_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="supp_address"
                       value="{{ old('supp_address', $customer->supp_address) }}"
                       class="form-control @error('supp_address') is-invalid @enderror">

                @error('supp_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label class="form-label">Upload Image</label>

                <input type="file"
                       name="supp_image"
                       class="dropify @error('supp_image') is-invalid @enderror"
                       accept="image/*"
                       data-max-file-size="2M"
                       data-allowed-file-extensions="jpg jpeg png"
                       data-default-file="{{ asset('upload/' . ($customer->supp_image ?? 'no_image.png')) }}">

                @error('supp_image')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <!-- Footer -->
        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ route('customer.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update customer</button>
        </div>

    </form>
</div>

@endsection

@section('scripts')
<script>
$('.dropify').dropify({
    messages: {
        default: 'Drag and drop an image or click',
        replace: 'Drag and drop or click to replace',
        remove:  'Remove',
        error:   'Oops, something went wrong.'
    }
});
</script>
@endsection