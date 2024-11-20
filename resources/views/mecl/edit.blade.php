@extends('layouts.app')

@section('contents')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Update Data MecL</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('mecl.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Batch / Lot -->
            <div class="mb-3">
                <label for="batch" class="form-label">Nama MeCL</label>
                <input type="text" name="nama_mecl" class="form-control" placeholder="Nama EHTG" value="{{ old('nama_mecl', $mecl->nama_mecl) }}" required>
                    @error('nama_mecl')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
            </div>
            <!-- Tombol Simpan -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>


@endsection
