@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Data Rawmat</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data Rawmat</h6>
    </div>

    <div class="card-body">
        <!-- Form Utama -->
        <form action="{{ route('datarawmat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" id="formType" value="D9930C"> <!-- Default ke opsi pertama -->

            <!-- Isi Form -->
            <div class="row">
                <!-- Nama Rawmat -->
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama Rawmat</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama Rawmat" required>
                </div>

                <!-- Supplier -->
                <div class="col-md-6 mb-3">
                    <label for="supplier" class="form-label">Supplier</label>
                    <input type="text" name="supplier" class="form-control" id="supplier" placeholder="Masukkan Nama Supplier" required>
                </div>
            </div>

            <!-- Tombol Submit -->
           
                <button type="submit" class="btn btn-primary">Tambah Data</button>
            
        </form>
    </div>
</div>
@endsection
