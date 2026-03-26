@extends('masterlayout.master')

@section('content')

<div class="container-fluid mt-4">

    <div class="card">
       <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Suppliers List</h3>
            <a href="{{ route('supplier.create') }}" class="btn btn-primary btn-sm">Add Supplier</a>
        </div>
        <div class="card-body">
            <table id="myTable" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th> <!-- New column -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->id }}</td>
                        <td>
                            @if ($supplier->supp_image)
                                <img src="{{ asset('upload/' . $supplier->supp_image) }}" 
                                     alt="{{ $supplier->supp_name }}" 
                                     width="50" height="50" style="border-radius:50%; cursor:pointer;"
                                     data-bs-toggle="modal" data-bs-target="#imageModal"
                                     data-img="{{ asset('upload/' . $supplier->supp_image) }}"
                                     data-name="{{ $supplier->supp_name }}">
                            @else
                                <span>No Image</span>
                            @endif
                        </td>
                        <td>{{ $supplier->supp_name }}</td>
                        <td>{{ $supplier->supp_email }}</td>
                        <td>
                            <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" style="display:inline-block;" 
                                  onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Image Modal (same as before) -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="previewImage" src="" alt="" class="img-fluid" style="max-height:400px;">
      </div>
      <div class="modal-footer justify-content-between">
        <a id="downloadImage" href="#" download class="btn btn-success">Download Image</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Initialize DataTable
    let table = new DataTable('#myTable', {
        paging: true,
        searching: true,
        ordering: true,
        responsive: true
    });

    // Image click preview
    const imageModal = document.getElementById('imageModal');
    const previewImage = document.getElementById('previewImage');
    const downloadBtn = document.getElementById('downloadImage');

    imageModal.addEventListener('show.bs.modal', function (event) {
        const img = event.relatedTarget;
        const src = img.getAttribute('data-img');
        const name = img.getAttribute('data-name');

        previewImage.src = src;
        previewImage.alt = name;
        imageModal.querySelector('.modal-title').textContent = name;

        downloadBtn.href = src;
        downloadBtn.download = name.replace(/\s+/g, '_');
    });
});
</script>
@endsection