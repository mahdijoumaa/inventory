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
        <div class="card-body">

            <!-- Supplier Name -->
            <div class="mb-3">
                <label for="supp_name" class="form-label">Supplier Name</label>
                <input type="text" class="form-control" id="supp_name" name="supp_name" placeholder="Enter supplier name" required>
            </div>

            <!-- Supplier Email -->
            <div class="mb-3">
                <label for="supp_email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="supp_email" name="supp_email" placeholder="Enter email" required>
            </div>

            <!-- Supplier Phone -->
            <div class="mb-3">
                <label for="supp_phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="supp_phone" name="supp_phone" placeholder="Enter phone number" required>
            </div>

            <!-- Supplier Address -->
            <div class="mb-3">
                <label for="supp_address" class="form-label">Address</label>
                <input type="text" class="form-control" id="supp_address" name="supp_address" placeholder="Enter address" required>
            </div>

            <!-- Supplier Image Upload -->
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="supp_image" name="supp_image" accept="image/*" required>
                <label class="input-group-text" for="supp_image">Upload Image</label>
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