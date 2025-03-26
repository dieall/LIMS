@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('instruments') }}">Kondisi I</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pengajuan Raw Material</li>
        </ol>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Detail Pengajuan Raw Material</h6>
    </div>

    <div class="card-body">
        <!-- Displaying Shift as a normal text above the table -->
        <div class="mb-3 row">
  
<div class="col-md-12 mb-3">
        <strong>Shift :</strong> {{ $instrument['shift'] }}
    </div>

    <div class="col-md-12 mb-3">
        <strong>Tanggal :</strong> {{ \Carbon\Carbon::parse($instrument->tgl)->locale('id')->isoFormat('D MMMM YYYY') }}
    </div>



<div class="col-md-12 mb-3">
        <strong>Jam :</strong> {{ \Carbon\Carbon::parse($instrument->jam)->format('H:i') }}
    </div>
    <div class="col-md-12 mb-3">
        <strong>Nama :</strong> {{ $instrument->user->name }}  <!-- Menampilkan nama pengguna -->
    </div>
</div>


        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 10%;">Nama Instrument</th>
                        <th style="width: 10%;">Kondisi</th>
                        <th style="width: 10%;">Keterangan</th>
        
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Decode JSON fields
                        $nama_instrument = json_decode($instrument['nama_instrument'], true) ?? [];
                        $kondisi = json_decode($instrument['kondisi'], true) ?? [];
                        $keterangan = json_decode($instrument['keterangan'], true) ?? [];

                        // Sort data alphabetically by instrument name (A-Z)
                        array_multisort($nama_instrument, SORT_ASC, $kondisi, $keterangan);

                        // Find maximum row length (assume the length is the same for all fields)
                        $maxLength = max(count($nama_instrument), count($kondisi), count($keterangan));
                    @endphp

                    @for ($i = 0; $i < $maxLength; $i++)
                    <tr>
                        <td>{{ isset($nama_instrument[$i]) ? (is_array($nama_instrument[$i]) ? implode(', ', $nama_instrument[$i]) : $nama_instrument[$i]) : '-' }}</td>
                        <td>{{ isset($kondisi[$i]) ? (is_array($kondisi[$i]) ? implode(', ', $kondisi[$i]) : $kondisi[$i]) : '-' }}</td>
                        <td>{{ isset($keterangan[$i]) ? (is_array($keterangan[$i]) ? implode(', ', $keterangan[$i]) : $keterangan[$i]) : '-' }}</td>


                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <a href="{{ route('pengajuanrawmat.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
