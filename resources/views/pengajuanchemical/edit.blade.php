@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Data Pengajuan Chemical</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Edit Data Pengajuan Chemical</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pengajuanchemical.update', $pengajuanchemical->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Nama Chemical -->
                @if ($pengajuanchemical->nama_chemical)
                    <div class="col-md-6 mb-3">
                        <label for="nama_chemical">Nama Chemical</label>
                        <input type="text" name="nama_chemical" id="nama_chemical" class="form-control" value="{{ $pengajuanchemical->nama_chemical }}" required>
                    </div>
                @endif

                <!-- Nama -->
                @if ($pengajuanchemical->nama)
                    <div class="col-md-6 mb-3">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $pengajuanchemical->nama }}" required>
                    </div>
                @endif

                <!-- Tanggal -->
                @if ($pengajuanchemical->tgl)
                    <div class="col-md-6 mb-3">
                        <label for="tgl">Tanggal</label>
                        <input type="date" name="tgl" id="tgl" class="form-control" value="{{ $pengajuanchemical->tgl }}" required>
                    </div>
                @endif

                <!-- Jam Masuk -->
                @if ($pengajuanchemical->jam_masuk)
                    <div class="col-md-6 mb-3">
                        <label for="jam_masuk">Jam Masuk</label>
                        <input type="text" name="jam_masuk" id="jam_masuk" class="form-control" value="{{ $pengajuanchemical->jam_masuk }}" required>
                    </div>
                @endif

                <!-- Batch -->
                @if ($pengajuanchemical->batch)
                    <div class="col-md-6 mb-3">
                        <label for="batch">Batch</label>
                        <input type="text" name="batch" id="batch" class="form-control" value="{{ $pengajuanchemical->batch }}" required>
                    </div>
                @endif

                <!-- Deskripsi -->
                @if ($pengajuanchemical->desc)
                    <div class="col-md-12 mb-3">
                        <label for="desc">Deskripsi</label>
                        <textarea name="desc" id="desc" class="form-control" rows="3">{{ $pengajuanchemical->desc }}</textarea>
                    </div>
                @endif

                <!-- Status -->
                @if ($pengajuanchemical->status)
                    <div class="col-md-6 mb-3">
                        <label for="status">Status</label>
                        <input type="text" name="status" id="status" class="form-control" value="{{ $pengajuanchemical->status }}" required>
                    </div>
                @endif

                <!-- Clarity -->
                @if ($pengajuanchemical->clarity)
                    <div class="col-md-6 mb-3">
                        <label for="clarity">Clarity</label>
                        <input type="text" name="clarity" id="clarity" class="form-control" value="{{ $pengajuanchemical->clarity }}">
                    </div>
                @endif

                <!-- Transmission -->
                @if ($pengajuanchemical->transmission)
                    <div class="col-md-6 mb-3">
                        <label for="transmission">Transmission</label>
                        <input type="text" name="transmission" id="transmission" class="form-control" value="{{ $pengajuanchemical->transmission }}">
                    </div>
                @endif

                <!-- APE -->
                @if ($pengajuanchemical->ape)
                    <div class="col-md-6 mb-3">
                        <label for="ape">APE</label>
                        <input type="text" name="ape" id="ape" class="form-control" value="{{ $pengajuanchemical->ape }}">
                    </div>
                @endif

                <!-- Dimet -->
                @if ($pengajuanchemical->dimet)
                    <div class="col-md-6 mb-3">
                        <label for="dimet">Dimet</label>
                        <input type="text" name="dimet" id="dimet" class="form-control" value="{{ $pengajuanchemical->dimet }}">
                    </div>
                @endif

                <!-- Trime -->
                @if ($pengajuanchemical->trime)
                    <div class="col-md-6 mb-3">
                        <label for="trime">Trime</label>
                        <input type="text" name="trime" id="trime" class="form-control" value="{{ $pengajuanchemical->trime }}">
                    </div>
                @endif

                <!-- Tambahkan field lain sesuai kebutuhan -->
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="{{ route('pengajuanchemical.index') }}" class="btn btn-secondary ml-2">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
