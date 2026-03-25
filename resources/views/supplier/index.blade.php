@extends('masterlayout.master')

@section('content')

<div class="card-header">
    <!-- Title -->
    <h3 class="card-title mb-0">Suppliers List</h3>

    <!-- Add Button on the far right of the page -->
    <div class="d-flex justify-content-end w-100 position-absolute top-0 end-0 p-3">
        <a href="{{ route('supplier.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus-circle"></i> Add Supplier
        </a>
    </div>
</div>
    <div class="card-body table-responsive">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $supplier)
                    <tr>
                        <td>{{ $loop->iteration + ($suppliers->currentPage() - 1) * $suppliers->perPage() }}</td>

                        <!-- Image with click to enlarge -->
                        <td>
                            <img src="{{ asset('upload/' . $supplier->supp_image) }}"
                                 width="50"
                                 height="50"
                                 style="object-fit: cover; cursor: pointer; border-radius: 5px;"
                                 data-bs-toggle="modal"
                                 data-bs-target="#imageModal{{ $supplier->id }}">
                        </td>

                        <td>{{ $supplier->supp_name }}</td>
                        <td>{{ $supplier->supp_email }}</td>
                        <td>{{ $supplier->supp_phone }}</td>
                        <td>{{ $supplier->supp_address }}</td>

                        <!-- Actions -->
                        <td>
                            <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-primary">Edit</a>

                            <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal for Image -->
                    <div class="modal fade" id="imageModal{{ $supplier->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <img src="{{ asset('upload/' . $supplier->supp_image) }}" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="7" class="text-center">No suppliers found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Custom Pagination -->
        <div class="mt-3">
           {{ $suppliers->links('pagination::bootstrap-5') }}
          
           
        </div>

        
    </div>
</div>

@endsection