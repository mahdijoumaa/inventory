@extends('masterlayout.master')

@section('content')

<div class="container-fluid mt-4">

     <div class="card">

        <!-- Card Header -->
         <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>customers Information</h3>
        </div>

        <!-- Form Start -->
        <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
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

                <!-- customer Name -->
                <div class="mb-3">
                    <label class="form-label">customer Name</label>
                    <input type="text" name="cust_name" value="{{ old('cust_name') }}"
                        class="form-control @error('cust_name') is-invalid @enderror" placeholder="Enter customer name">

                    @error('cust_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- customer Email -->
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" name="cust_email" value="{{ old('cust_email') }}"
                        class="form-control @error('cust_email') is-invalid @enderror" placeholder="Enter email">

                    @error('cust_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- customer Phone -->
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="cust_phone" value="{{ old('cust_phone') }}"
                        class="form-control @error('cust_phone') is-invalid @enderror" placeholder="Enter phone number">

                    @error('cust_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- customer Address -->
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="cust_address" value="{{ old('cust_address') }}"
                        class="form-control @error('cust_address') is-invalid @enderror" placeholder="Enter address">

                    @error('cust_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- customer Image -->
                <div class="mb-3">
                    <label class="form-label">Upload Image</label>

                    <input type="file" name="cust_image" class="dropify @error('cust_image') is-invalid @enderror"
                        accept="image/*" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png"
                        data-default-file="{{ old('cust_image') }}">

                    @error('cust_image')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Card Footer -->
            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save customer</button>



            </div>

        </form>
    </div>
</div>

    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                let customerId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form
                        const form = document.createElement('form');
                        form.action = '/customer/' + customerId;
                        form.method = 'POST';

                        // Add CSRF token
                        const token = document.createElement('input');
                        token.type = 'hidden';
                        token.name = '_token';
                        token.value = '{{ csrf_token() }}';
                        form.appendChild(token);

                        // Add DELETE method
                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'DELETE';
                        form.appendChild(method);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>

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