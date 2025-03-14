@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Data Pengajuan Rawmat</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data Pengajuan Rawmat</h6>
    </div>

    <div class="card-body">
    <form action="{{ route('pengajuanrawmat.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Form Utama -->
    <div class="row">
        <!-- Nama Rawmat -->
        <div class="col-md-6 mb-3">
            <label for="rawmat" class="form-label">Nama Rawmat</label>
            <select name="rawmat" class="form-control" id="rawmat" required>
                <option value="">Pilih Nama Rawmat</option>
                @foreach($datarawmat as $rawmat)
                    <option value="{{ $rawmat->id }}" data-nama="{{ $rawmat->nama }}" data-supplier="{{ $rawmat->supplier }}">
                        {{ $rawmat->nama }} - {{ $rawmat->supplier }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tanggal -->
        <div class="col-md-6 mb-3" hidden>
            <label for="tgl" class="form-label">Tanggal</label>
            <input type="date" name="tgl" class="form-control" id="tgl" placeholder="Masukkan Tanggal" required>
        </div>

        <!-- Supplier -->
        <div class="col-md-6 mb-3">
            <label for="supplier" class="form-label">Supplier</label>
            <input type="text" name="supplier" class="form-control" id="supplier" placeholder="Masukkan Supplier" readonly>
        </div>

        <!-- Nama -->
        <input type="hidden" name="nama" id="nama">
    </div>

    <!-- Spesifikasi, Satuan, COA, Result -->
    <h6 class="mb-3">Spesifikasi, Satuan, COA, Result</h6>
    <table class="table table-bordered" id="dynamic-table">
        <thead>
            <tr>
                <th>Spesifikasi</th>
                <th>Satuan</th>
                <th>COA</th>
                <th>Result</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" name="spesifikasi[]" class="form-control"></td>
                <td><input type="text" name="satuan[]" class="form-control"></td>
                <td><input type="text" name="coa[]" class="form-control"></td>
                <td><input type="text" name="result[]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger btn-remove">Hapus</button></td>
            </tr>
        </tbody>
    </table>
    <button type="button" class="btn btn-success" id="add-row">Tambah Baris</button>

    <!-- Tombol Submit -->
    <button type="submit" class="btn btn-primary">Tambah Data</button>
</form>

    </div>
</div>

<script>
    // Fungsi untuk menambahkan baris input dinamis
    document.getElementById('add-row').addEventListener('click', function() {
        var tableBody = document.querySelector('#dynamic-table tbody');
        var newRow = document.createElement('tr');
        
        newRow.innerHTML = `
            <td><input type="text" name="spesifikasi[]" class="form-control"></td>
            <td><input type="text" name="satuan[]" class="form-control"></td>
            <td><input type="text" name="coa[]" class="form-control"></td>
            <td><input type="text" name="result[]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-remove">Hapus</button></td>
        `;
        
        tableBody.appendChild(newRow);
    });

    // Fungsi untuk menghapus baris input
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('btn-remove')) {
            event.target.closest('tr').remove();
        }
    });

    // Isi otomatis Supplier dan Nama berdasarkan Rawmat yang dipilih
    document.getElementById('rawmat').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const supplier = selectedOption.getAttribute('data-supplier');
        const nama = selectedOption.getAttribute('data-nama');

        document.getElementById('supplier').value = supplier ? supplier : '';
        document.getElementById('nama').value = nama ? nama : ''; // Set nama field value
    });

    // Set tanggal otomatis
    document.addEventListener('DOMContentLoaded', function () {
        const tglField = document.getElementById('tgl');

        const now = new Date();
        const today = now.toISOString().split('T')[0]; // Format YYYY-MM-DD

        if (!tglField.value) {
            tglField.value = today;
        }
    });
</script>
@endsection
