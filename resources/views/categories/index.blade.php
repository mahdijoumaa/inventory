@extends('masterlayout.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold">
                        <i class="fas fa-list text-primary mr-2"></i> Categories
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Categories</li>
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
                            <div class="icon"><i class="fas fa-list"></i></div>
                            <h6 class="fw-bold text-uppercase mb-2">Total Categories</h6>
                            <h3>{{ $Categories->count() }}</h3>
                            <p>Total Categories</p>
                        </div>
                        <a href="{{ route('categories.create') }}"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Add New <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Main Card --}}
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header d-flex align-items-center py-3">
                    <h3 class="card-title mb-0"><i class="fas fa-list mr-1"></i> Categories List</h3>
                    <div class="ml-auto">
                        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm px-3">
                            <i class="fas fa-plus-circle mr-1"></i> Add Category
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
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th width="160" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($Categories as $index => $category)
                                    <tr>
                                        <td>
                                            <span class="badge badge-secondary">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            @if ($category->cat_image)
                                                <img src="{{ asset('upload/' . $category->cat_image) }}"
                                                    alt="{{ $category->cat_name }}"
                                                    class="img-circle elevation-1 supplier-avatar"
                                                    width="42" height="42"
                                                    style="cursor:pointer; object-fit:cover;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#imageModal"
                                                    data-img="{{ asset('upload/categories/' . $category->cat_image) }}"
                                                    data-name="{{ $category->cat_name }}">
                                            @else
                                                <span
                                                    class="img-circle elevation-1 d-inline-flex align-items-center justify-content-center bg-gradient-secondary text-white"
                                                    style="width:42px;height:42px;font-size:16px;font-weight:700;border-radius:50%;">
                                                    {{ strtoupper(substr($category->cat_name, 0, 1)) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $category->id }}</td>
                                        <td><strong>{{ $category->cat_name }}</strong></td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                                class="btn btn-warning btn-xs px-2 mr-1" title="Edit Category">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>

                                            <button type="button" class="btn btn-danger delete" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal"
                                                data-url="{{ route('categories.destroy', $category->id) }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                                            No Categories found. <a href="{{ route('categories.create') }}">Add one now.</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-muted text-sm">
                    Showing {{ $Categories->count() }} category(s)
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
                    <i class="fas fa-image mr-1"></i> <span id="modalCategoryName"></span>
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

{{-- Delete Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="deleteModal" method="POST" class="d-inline-block">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this category?</p>
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
    const table = document.getElementById('myTable');
    const tbodyRows = table.querySelectorAll('tbody tr');

    // Initialize DataTable only if table has data
    const hasData = Array.from(tbodyRows).some(row => !row.querySelector('td[colspan]'));
    if (hasData) {
        new DataTable('#myTable', {
            paging: true,
            searching: true,
            ordering: true,
            scrollX: true,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search categories...',
                lengthMenu: 'Show _MENU_ categories',
                info: 'Showing _START_ to _END_ of _TOTAL_ categories',
                emptyTable: 'No categories found',
            },
            columnDefs: [
                { orderable: false, targets: [1, 4] } // Disable sort on Image & Actions
            ]
        });
    }

    // Image Modal
    const imageModal = document.getElementById('imageModal');
    imageModal.addEventListener('show.bs.modal', function (event) {
        const img = event.relatedTarget;
        const src = img.getAttribute('data-img');
        const name = img.getAttribute('data-name');

        document.getElementById('previewImage').src = src;
        document.getElementById('previewImage').alt = name;
        document.getElementById('modalCategoryName').textContent = name;
        document.getElementById('downloadImage').href = src;
        document.getElementById('downloadImage').download = name.replace(/\s+/g, '_');
    });

    // Delete Button
    $(document).on('click', '.delete', function () {
        let url = $(this).data('url');
        $('#deleteModal').attr('action', url);
    });
});
</script>
@endsection