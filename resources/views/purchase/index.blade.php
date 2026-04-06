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




@endsection



