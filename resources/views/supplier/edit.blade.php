@extends('masterlayout.master')

@section('content')

<div class="container-fluid">
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title mb-0">Edit Supplier</h3>
        </div>

        <form action="{{ route('supplier.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <!-- Supplier Name -->
                <div class="form-group">
                    <label for="supp_name">Supplier Name</label>
                    <input type="text" name="supp_name" id="supp_name" class="form-control" value="{{ old('supp_name', $supplier->supp_name) }}" required>
                </div>

                <!-- Supplier Email -->
                <div class="form-group">
                    <label for="supp_email">Email</label>
                    <input type="email" name="supp_email" id="supp_email" class="form-control" value="{{ old('supp_email', $supplier->supp_email) }}" required>
                </div>

                <!-- Supplier Phone -->
                <div class="form-group">
                    <label for="supp_phone">Phone</label>
                    <input type="text" name="supp_phone" id="supp_phone" class="form-control" value="{{ old('supp_phone', $supplier->supp_phone) }}" required>
                </div>

                <!-- Supplier Address -->
                <div class="form-group">
                    <label for="supp_address">Address</label>
                    <input type="text" name="supp_address" id="supp_address" class="form-control" value="{{ old('supp_address', $supplier->supp_address) }}" required>
                </div>

                <!-- Supplier Image -->
                <div class="form-group">
                    <label for="supp_image">Image</label>
                    <input type="file" name="supp_image" id="supp_image" class="form-control">
                    @if($supplier->supp_image)
                        <img src="{{ asset('upload/'.$supplier->supp_image) }}" alt="Supplier Image" class="img-thumbnail mt-2" width="100">
                    @endif
                </div>
            </div>

     
            
            <!-- Card Footer -->
        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Supplier</button>
        </div>
      
      
        </form>
    </div>
</div>
@endsection