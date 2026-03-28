@extends('masterlayout.master')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 font-weight-bold">
                            <i class="fas fa-boxes text-primary mr-2"></i> Products
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                {{-- Stats Row --}}
                <div class="row mb-3">
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-primary">
                            <div class="inner text-center">
                                <div class="icon"><i class="fas fa-box"></i></div>
                                <h6 class="fw-bold text-uppercase mb-2 text-center">Total Products KPI</h6>
                                <h3 class="text-center">{{ $products->count() }}</h3>
                                <p class="text-center">Total Products</p>
                            </div>
                            <a href="{{ route('products.create') }}"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                Add New <i class="bi bi-link-45deg"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Main Card --}}
                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-header d-flex align-items-center py-3">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-list mr-1"></i> Products List
                        </h3>
                        <div class="ml-auto">
                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm px-3">
                                <i class="fas fa-plus-circle mr-1"></i> Add Product
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-hover table-striped mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="60">#</th>
                                        <th width="80">Image</th>
                                        <th>Product Name</th>
                                        <th>Code</th>
                                        <th>Category ID</th>
                                        <th>Supplier ID</th>
                                        <th>Brand</th>
                                        <th width="160" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $index => $product)
                                        <tr>
                                            <td><span class="badge badge-secondary">{{ $index + 1 }}</span></td>
                                            <td>
                                                @if ($product->product_image)
                                                    <img src="{{ asset('upload/' . $product->product_image) }}"
                                                        alt="{{ $product->product_name }}"
                                                        class="img-circle elevation-1 product-avatar" width="42" height="42"
                                                        style="cursor:pointer; object-fit:cover;" data-bs-toggle="modal"
                                                        data-bs-target="#imageModal"
                                                        data-img="{{ asset('upload/' . $product->product_image) }}"
                                                        data-name="{{ $product->product_name }}">
                                                @else
                                                    <span
                                                        class="img-circle elevation-1 d-inline-flex align-items-center justify-content-center bg-gradient-secondary text-white"
                                                        style="width:42px;height:42px;font-size:16px;font-weight:700;border-radius:50%;">
                                                        {{ strtoupper(substr($product->product_name, 0, 1)) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->product_code }}</td>
                                            <td>{{ $product->category ? $product->category->cat_name : '-' }}</td>
                                            <td>{{ $product->supplier ? $product->supplier->supp_name : '-' }}</td>
                                            <td>{{ $product->brand ?? '-' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="btn btn-warning btn-xs px-2 mr-1" title="Edit Product">
                                                    <i class="fas fa-edit mr-1"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-danger delete" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal"
                                                    data-url="{{ route('products.destroy', $product->id) }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5 text-muted">
                                                <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                                                No products found. <a href="{{ route('products.create') }}">Add one now.</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-muted text-sm">
                        Showing {{ $products->count() }} product(s)
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Image Preview Modal --}}
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white py-2">
                    <h6 class="modal-title mb-0" id="imageModalLabel">
                        <i class="fas fa-image mr-1"></i> <span id="modalProductName"></span>
                    </h6>
                </div>
                <div class="modal-body text-center p-3">
                    <img id="previewImage" src="" alt="" class="img-fluid rounded" style="max-height:320px;">
                </div>
                <div class="modal-footer justify-content-between py-2">
                    <a id="downloadImage" href="#" download class="btn btn-success btn-sm">
                        <i class="fas fa-download mr-1"></i> Download
                    </a>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="deleteForm" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this product?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Initialize DataTable only if there is data
            if (document.querySelector('#myTable tbody tr:not(:has(td[colspan]))')) {
                new DataTable('#myTable', {
                    paging: true,
                    searching: true,
                    ordering: true,
                    scrollX: true,
                    language: {
                        search: '<i class="fas fa-search"></i>',
                        searchPlaceholder: 'Search products...',
                        lengthMenu: 'Show _MENU_ products',
                        info: 'Showing _START_ to _END_ of _TOTAL_ products',
                        emptyTable: 'No products found',
                    },
                    columnDefs: [{ orderable: false, targets: [1, 7] }]
                });
            }

            // Image Modal
            const imageModal = document.getElementById('imageModal');
            imageModal.addEventListener('show.bs.modal', function (event) {
                const img = event.relatedTarget;
                document.getElementById('previewImage').src = img.dataset.img;
                document.getElementById('previewImage').alt = img.dataset.name;
                document.getElementById('modalProductName').textContent = img.dataset.name;
                document.getElementById('downloadImage').href = img.dataset.img;
                document.getElementById('downloadImage').download = img.dataset.name.replace(/\s+/g, '_');
            });

            // Delete button
            $(document).on('click', '.delete', function () {
                let url = $(this).data('url');
                $('#deleteForm').attr('action', url);
            });
        });
    </script>
@endsection