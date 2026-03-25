@extends('masterlayout.master')

@section('content')

    <div class="container-fluid">
        <div class="card card-primary card-outline mb-4">
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
                                <td>
                                    @if($perPage == -1)
                                        {{ $loop->iteration }}
                                    @else
                                        {{ $loop->iteration + ($suppliers->currentPage() - 1) * $suppliers->perPage() }}
                                    @endif
                                </td>

                                <!-- Image with click to enlarge -->
                                <td>
                                    <img src="{{ asset('upload/' . $supplier->supp_image) }}" width="50" height="50"
                                        style="object-fit: cover; cursor: pointer; border-radius: 5px;" data-bs-toggle="modal"
                                        data-bs-target="#imageModal{{ $supplier->id }}">
                                </td>

                                <td>{{ $supplier->supp_name }}</td>
                                <td>{{ $supplier->supp_email }}</td>
                                <td>{{ $supplier->supp_phone }}</td>
                                <td>{{ $supplier->supp_address }}</td>

                                <!-- Actions -->
                                <td>
                                    <a href="{{ route('supplier.edit', $supplier->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>

                                    <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="btn btn-sm btn-danger">Delete</button>
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
                <!-- Items per page selector -->
                <form method="GET" class="mb-3 d-flex align-items-center">
                    <label for="perPage" class="me-2 mb-0">Show per page:</label>
                    <select name="perPage" id="perPage" class="form-select w-auto" onchange="this.form.submit()">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="-1" {{ $perPage == -1 ? 'selected' : '' }}>All</option>

                    </select>
                </form>
                <!-- Custom Pagination -->
                <!-- Custom Pagination -->
                @if($perPage != -1) {{-- Only show pagination if not "All" --}}
                    <div class="mt-3">
                        {{ $suppliers->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
    </div>

@endsection