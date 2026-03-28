@extends('masterlayout.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="card">
        <!-- Card Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Edit Category</h3>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>

        <!-- Form Start -->
        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Validation Errors -->
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

                <!-- Category Name -->
                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="cat_name" value="{{ old('cat_name', $category->cat_name) }}"
                        class="form-control @error('cat_name') is-invalid @enderror" placeholder="Enter category name">

                    @error('cat_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category Image -->
                <div class="mb-3">
                    <label class="form-label">Category Image</label>
                    <input type="file" name="cat_image" class="dropify @error('cat_image') is-invalid @enderror"
                        accept="image/*" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png"
                        data-default-file="{{ $category->cat_image ? asset('upload/categories/' . $category->cat_image) : '' }}">

                    @error('cat_image')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Card Footer -->
            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Category</button>
            </div>
        </form>
    </div>
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