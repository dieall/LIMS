@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('datathermo') }}">Data Thermohygrometer</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Data Thermohygrometer</li>
        </ol>
    </nav>
</div>

<div class="card shadow mb-2">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Detail Data Thermohygrometer</h6>
    </div>

    <div class="card-body">
        <!-- Displaying Shift as a normal text above the table -->
        <div class="mb-3 row">
    <!-- Nama Pengguna -->
    <div class="col-md-12 mb-3">
        <strong>Nama :</strong> {{ $datathermo->user->name }}  <!-- Menampilkan nama pengguna -->
    </div>

    <!-- Tanggal -->
    <div class="col-md-12 mb-3">
        <strong>Tanggal :</strong> {{ \Carbon\Carbon::parse($datathermo->tgl)->locale('id')->isoFormat('D MMMM YYYY') }}
    </div>

    <!-- Jam -->
    <div class="col-md-12 mb-3">
        <strong>Jam :</strong> {{ \Carbon\Carbon::parse($datathermo->waktu)->format('H:i') }}
    </div>
</div>





        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 10%;">Nama datathermo</th>
                        <th style="width: 10%;">suhu</th>
                        <th style="width: 10%;">kelembapan</th>
        
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Decode JSON fields
                        $nama_thermo = json_decode($datathermo['nama_thermo'], true) ?? [];
                        $suhu = json_decode($datathermo['suhu'], true) ?? [];
                        $kelembapan = json_decode($datathermo['kelembapan'], true) ?? [];

                        // Sort data alphabetically by datathermo name (A-Z)
                        array_multisort($nama_thermo, SORT_ASC, $suhu, $kelembapan);

                        // Find maximum row length (assume the length is the same for all fields)
                        $maxLength = max(count($nama_thermo), count($suhu), count($kelembapan));
                    @endphp

                    @for ($i = 0; $i < $maxLength; $i++)
                    <tr>
                        <td>{{ isset($nama_thermo[$i]) ? (is_array($nama_thermo[$i]) ? implode(', ', $nama_thermo[$i]) : $nama_thermo[$i]) : '-' }}</td>
                        <td>
                            {{ isset($suhu[$i]) ? (is_array($suhu[$i]) ? implode(', ', $suhu[$i]) . ' °C' : $suhu[$i] . ' °C') : '-' }}
                        </td>
                        <td>
                            {{ isset($kelembapan[$i]) ? (is_array($kelembapan[$i]) ? implode(', ', $kelembapan[$i]) . ' %' : $kelembapan[$i] . ' %') : '-' }}
                        </td>



                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <a href="{{ route('datathermo') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
