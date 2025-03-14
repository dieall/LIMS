@extends('layouts.app')

@section('contents')


<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Edit Data Pengajuan Solder | {{ $pengajuansolder->tipe_solder }}</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('pengajuansolder.update', $pengajuansolder->id) }}" method="POST" enctype="multipart/form-pengajuansolder">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Nama -->
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" value="{{ $pengajuansolder->nama }}" required readonly>
                </div>

                <!-- Tanggal -->
                <div class="col-md-6 mb-3">
                    <label for="tgl" class="form-label">Tanggal</label>
                    <input type="date" name="tgl" class="form-control" id="tgl" value="{{ $pengajuansolder->tgl }}" required readonly>
                </div>

                <!-- Tipe Solder -->
                <div class="col-md-6 mb-3">
                    <label for="tipe_solder" class="form-label">Tipe Solder</label>
                    <input type="text" name="tipe_solder" class="form-control" id="tipe_solder" value="{{ $pengajuansolder->tipe_solder }}" required readonly>
                </div>

                <!-- Batch -->
                <div class="col-md-6 mb-3">
                    <label for="batch" class="form-label">Batch</label>
                    <input type="text" name="batch" class="form-control" id="batch" value="{{ $pengajuansolder->batch }}" required  readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input 
                        type="text" 
                        name="status" 
                        class="form-control 
                            {{ $pengajuansolder->status == 'Pengajuan' ? 'bg-primary text-white' : '' }} 
                            {{ $pengajuansolder->status == 'Proses Analisa' ? 'bg-info text-dark' : '' }} 
                            {{ $pengajuansolder->status == 'Selesai Analisa' ? 'bg-secondary text-white' : '' }} 
                            {{ $pengajuansolder->status == 'Review Hasil' ? 'bg-warning text-dark' : '' }} 
                            {{ $pengajuansolder->status == 'Approve' ? 'bg-success text-white' : '' }}" 
                        id="batch" 
                        value="{{ $pengajuansolder->status }}" 
                        readonly>
                </div>



                <!-- Jam Masuk -->
                <div class="col-md-6 mb-3">
                    <label for="jam_masuk" class="form-label">Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="form-control" id="jam_masuk" value="{{ $pengajuansolder->jam_masuk }}" required readonly>
                </div>
            </div>

            <hr>
            <h5>Komposisi Unsur</h5>
            <div class="row">
                @foreach(['sn', 'ag', 'cu', 'pb', 'sb', 'zn', 'fe', 'as', 'ni', 'bi', 'cd', 'ai', 'pe', 'ga'] as $element)
                    <div class="col-md-4 mb-3">
                        <label for="{{ $element }}" class="form-label">{{ strtoupper($element) }}</label>
                        <input type="text" name="{{ $element }}" class="form-control" id="{{ $element }}" 
                               value="{{ $pengajuansolder->$element }}" placeholder="Masukkan nilai {{ strtoupper($element) }}">
                    </div>
                @endforeach
            </div>



            <!-- Hidden Fields -->
            <input type="hidden" name="audit_trail" value="Updated by {{ Auth::user()->name }} at {{ now() }}">
            <input type="hidden" name="previous_status" value="{{ $pengajuansolder->status }}">
            <input type="hidden" name="previous_jam_masuk" value="{{ $pengajuansolder->jam_masuk }}">

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>

@endsection
