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

        <div class="col-md-6 mb-3">
            <label for="nama_chemical">Nama Chemical</label>
            <input type="text" name="nama_chemical" id="nama_chemical" class="form-control" value="{{ $pengajuanchemical->nama_chemical }}" required>
        </div>


    <!-- Nama -->

        <div class="col-md-6 mb-3">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ $pengajuanchemical->nama }}" required>
        </div>

    <!-- Tanggal -->
 
        <div class="col-md-6 mb-3">
            <label for="tgl">Tanggal</label>
            <input type="date" name="tgl" id="tgl" class="form-control" value="{{ $pengajuanchemical->tgl }}" required>
        </div>
 

    <!-- Jam Masuk -->

        <div class="col-md-6 mb-3">
            <label for="jam_masuk">Jam Masuk</label>
            <input type="text" name="jam_masuk" id="jam_masuk" class="form-control" value="{{ $pengajuanchemical->jam_masuk }}" required>
        </div>


    <!-- Status -->
    <div class="col-md-6 mb-3">
        <label for="status" class="form-label">Status</label>
        <input 
            type="text" 
            name="status" 
            class="form-control 
                {{ $pengajuanchemical->status == 'Pengajuan' ? 'bg-primary text-white' : '' }} 
                {{ $pengajuanchemical->status == 'Proses Analisa' ? 'bg-info text-dark' : '' }} 
                {{ $pengajuanchemical->status == 'Selesai Analisa' ? 'bg-secondary text-white' : '' }} 
                {{ $pengajuanchemical->status == 'Review Hasil' ? 'bg-warning text-dark' : '' }} 
                {{ $pengajuanchemical->status == 'Approve' ? 'bg-success text-white' : '' }}" 
            id="status" 
            value="{{ $pengajuanchemical->status }}" 
            readonly>
    </div>

    <!-- Batch -->

        <div class="col">
            <label for="batch">Batch</label>
            <input type="text" name="batch" id="batch" class="form-control" value="{{ $pengajuanchemical->batch }}" required>
        </div>




    <!-- Deskripsi -->
    @if ($pengajuanchemical->desc)
        <div class="col-md-12 mb-3">
            <label for="desc">Deskripsi</label>
            <textarea name="desc" id="desc" class="form-control" rows="3">{{ $pengajuanchemical->desc }}</textarea>
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

    <!-- Tin -->
    @if ($pengajuanchemical->tin)
        <div class="col-md-6 mb-3">
            <label for="tin">Tin</label>
            <input type="text" name="tin" id="tin" class="form-control" value="{{ $pengajuanchemical->tin }}">
        </div>
    @endif

    <!-- Solid -->
    @if ($pengajuanchemical->solid)
        <div class="col-md-6 mb-3">
            <label for="solid">Solid</label>
            <input type="text" name="solid" id="solid" class="form-control" value="{{ $pengajuanchemical->solid }}">
        </div>
    @endif

    <!-- RI -->
    @if ($pengajuanchemical->ri)
        <div class="col-md-6 mb-3">
            <label for="ri">RI</label>
            <input type="text" name="ri" id="ri" class="form-control" value="{{ $pengajuanchemical->ri }}">
        </div>
    @endif

    <!-- SG -->
    @if ($pengajuanchemical->sg)
        <div class="col-md-6 mb-3">
            <label for="sg">SG</label>
            <input type="text" name="sg" id="sg" class="form-control" value="{{ $pengajuanchemical->sg }}">
        </div>
    @endif

    <!-- Acid -->
    @if ($pengajuanchemical->acid)
        <div class="col-md-6 mb-3">
            <label for="acid">Acid</label>
            <input type="text" name="acid" id="acid" class="form-control" value="{{ $pengajuanchemical->acid }}">
        </div>
    @endif

    <!-- Sulfur -->
    @if ($pengajuanchemical->sulfur)
        <div class="col-md-6 mb-3">
            <label for="sulfur">Sulfur</label>
            <input type="text" name="sulfur" id="sulfur" class="form-control" value="{{ $pengajuanchemical->sulfur }}">
        </div>
    @endif

    <!-- Water -->
    @if ($pengajuanchemical->water)
        <div class="col-md-6 mb-3">
            <label for="water">Water</label>
            <input type="text" name="water" id="water" class="form-control" value="{{ $pengajuanchemical->water }}">
        </div>
    @endif

    <!-- Mono -->
    @if ($pengajuanchemical->mono)
        <div class="col-md-6 mb-3">
            <label for="mono">Mono</label>
            <input type="text" name="mono" id="mono" class="form-control" value="{{ $pengajuanchemical->mono }}">
        </div>
    @endif

    <!-- Yellow -->
    @if ($pengajuanchemical->yellow)
        <div class="col-md-6 mb-3">
            <label for="yellow">Yellow</label>
            <input type="text" name="yellow" id="yellow" class="form-control" value="{{ $pengajuanchemical->yellow }}">
        </div>
    @endif

    <!-- EH -->
    @if ($pengajuanchemical->eh)
        <div class="col-md-6 mb-3">
            <label for="eh">EH</label>
            <input type="text" name="eh" id="eh" class="form-control" value="{{ $pengajuanchemical->eh }}">
        </div>
    @endif

    <!-- Visco -->
    @if ($pengajuanchemical->visco)
        <div class="col-md-6 mb-3">
            <label for="visco">Visco</label>
            <input type="text" name="visco" id="visco" class="form-control" value="{{ $pengajuanchemical->visco }}">
        </div>
    @endif

    <!-- PT -->
    @if ($pengajuanchemical->pt)
        <div class="col-md-6 mb-3">
            <label for="pt">PT</label>
            <input type="text" name="pt" id="pt" class="form-control" value="{{ $pengajuanchemical->pt }}">
        </div>
    @endif

    <!-- Moisture -->
    @if ($pengajuanchemical->moisture)
        <div class="col-md-6 mb-3">
            <label for="moisture">Moisture</label>
            <input type="text" name="moisture" id="moisture" class="form-control" value="{{ $pengajuanchemical->moisture }}">
        </div>
    @endif

    <!-- Chloride -->
    @if ($pengajuanchemical->cloride)
        <div class="col-md-6 mb-3">
            <label for="cloride">Chloride</label>
            <input type="text" name="cloride" id="cloride" class="form-control" value="{{ $pengajuanchemical->cloride }}">
        </div>
    @endif

    <!-- Spec -->
    @if ($pengajuanchemical->spec)
        <div class="col-md-6 mb-3">
            <label for="spec">Spec</label>
            <input type="text" name="spec" id="spec" class="form-control" value="{{ $pengajuanchemical->spec }}">
        </div>
    @endif

    <!-- Densi -->
    @if ($pengajuanchemical->densi)
        <div class="col-md-6 mb-3">
            <label for="densi">Densi</label>
            <input type="text" name="densi" id="densi" class="form-control" value="{{ $pengajuanchemical->densi }}">
        </div>
    @endif

</div>


            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="{{ route('pengajuanchemical.index') }}" class="btn btn-secondary ml-2">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
