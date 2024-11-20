@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="a">Data MecL</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data Category</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Mengubah input Category menjadi dropdown select -->


            <div class="mb-3">
                <label for="tipe_sampel" class="form-label">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" placeholder="Masukkan Nama Kategori" required>
            </div>



            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>


@endsection
