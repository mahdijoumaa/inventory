@extends('masterlayout.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold">
                        <i class="fas fa-balance-scale text-primary mr-2"></i> Units
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Units</li>
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
                        <div class="icon"><i class="fas fa-balance-scale"></i></div>
                        <h6 class="fw-bold text-uppercase mb-2">Total Units</h6>
                        <h3>{{ $Units->count() }}</h3>
                        <p>Total Units</p>
                    </div>
                    <a href="{{ route('unit.create') }}"
                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        Add New <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header d-flex align-items-center py-3">
                <h3 class="card-title mb-0"><i class="fas fa-balance-scale mr-1"></i> Units List</h3>
                <div class="ml-auto">
                    <a href="{{ route('unit.create') }}" class="btn btn-primary btn-sm px-3">
                        <i class="fas fa-plus-circle mr-1"></i> Add Unit
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="60">#</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Notes</th>
                                <th width="160" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($Units as $index => $unit)
                                <tr>
                                    <td>
                                        <span class="badge badge-secondary">{{ $index + 1 }}</span>
                                    </td>
                                    <td>{{ $unit->id }}</td>
                                    <td><strong>{{ $unit->unit_name }}</strong></td>
                                    <td>{{ $unit->unit_notes ?? '-' }}</td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('unit.edit', $unit->id) }}"
                                            class="btn btn-warning btn-xs px-2 mr-1">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>

                                        <button type="button" class="btn btn-danger delete"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModalBox"
                                            data-url="{{ route('unit.destroy', $unit->id) }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                                        No Units found. 
                                        <a href="{{ route('unit.create') }}">Add one now.</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer text-muted text-sm">
                Showing {{ $Units->count() }} unit(s)
            </div>
        </div>

    </div>
</section>


</div>

{{-- Delete Modal --}}

<div class="modal fade" id="deleteModalBox" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')


            
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Are you sure you want to delete this unit?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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

    // DataTable
    new DataTable('#myTable', {
        paging: true,
        searching: true,
        ordering: true,
        scrollX: true,
        language: {
            search: '<i class="fas fa-search"></i>',
            searchPlaceholder: 'Search units...',
            lengthMenu: 'Show _MENU_ units',
            info: 'Showing _START_ to _END_ of _TOTAL_ units',
        },
        columnDefs: [
            { orderable: false, targets: [4] }
        ]
    });

    // Delete Modal
    $(document).on('click', '.delete', function () {
        let url = $(this).data('url');
        $('#deleteForm').attr('action', url);
    });

});
</script>

@endsection
