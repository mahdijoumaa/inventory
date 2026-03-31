@extends('masterlayout.master')

@section('content')

<div class="container-fluid mt-4">


    
    
<div class="card">

    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Unit Information</h3>
    </div>

    <!-- Form -->
    <form action="{{ route('unit.store') }}" method="POST">
        @csrf

        <!-- Errors -->
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

            <!-- Unit Name -->
            <div class="mb-3">
                <label class="form-label">Unit Name</label>
                <input type="text" name="unit_name" value="{{ old('unit_name') }}"
                    class="form-control @error('unit_name') is-invalid @enderror"
                    placeholder="Enter unit name (e.g. Kg, Piece, Box)">

                @error('unit_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Unit Notes -->
            <div class="mb-3">
                <label class="form-label">Unit Notes</label>
                <textarea name="unit_notes"
                    class="form-control @error('unit_notes') is-invalid @enderror"
                    placeholder="Enter notes (optional)">{{ old('unit_notes') }}</textarea>

                @error('unit_notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <!-- Footer -->
        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ route('unit.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Unit</button>
        </div>

    </form>
</div>


</div>

@endsection

