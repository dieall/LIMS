@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Detail Pengajuan Solder</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Detail Data | Pengajuan Solder</h6>
    </div>

    <div class="card-body">
        <h1>Detail Pengajuan Solder</h1>
        <hr>
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
                <table class="table table-bordered">
                <tr>
                        <th>Tanggal</th>
                        <td>{{ $dmt->id }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $dmt->tgl }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $dmt->category->nama_kategori ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Tipe Solder</th>
                        <td>{{ $dmt->transaksi->tipe_sampel}}</td>
                    </tr>
                    <tr>
                        <th>Jam Masuk</th>
                        <td>{{ $dmt->transaksi->jam_masuk }}</td>
                    </tr>
                    <tr>
                        <th>Batch / Lot</th>
                        <td>{{ $dmt->transaksi->batch }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $dmt->transaksi->nama }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $dmt->status }}</td>
                    </tr>
                </table>




            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Detail Chemical</th>
                    </tr>
              
    @if(!empty($dmt->ape))
    <tr>
        <th>Appereance</th>
        <td>{{ $dmt->ape }}</td>
    </tr>
    @endif

    @if(!empty($dmt->solid))
    <tr>
        <th>% Solide Content</th>
        <td>{{ $dmt->solid }}</td>
    </tr>
    @endif

    @if(!empty($dmt->tinc))
    <tr>
        <th>% Tin Content</th>
        <td>{{ $dmt->tinc }}</td>
    </tr>
    @endif

    @if(!empty($dmt->monomet))
    <tr>
        <th>% Monomethyltin Trichloride</th>
        <td>{{ $dmt->monomet }}</td>
    </tr>
    @endif

    @if(!empty($dmt->trime))
    <tr>
        <th>Trimethyltin Monochloride</th>
        <td>{{ $dmt->trime }}</td>
    </tr>
    @endif

    @if(!empty($dmt->cloride))
    <tr>
        <th>% Cloride</th>
        <td>{{ $dmt->cloride }}</td>
    </tr>
    @endif

    @if(!empty($dmt->spec))
    <tr>
        <th>Specific Gravity (25°C)</th>
        <td>{{ $dmt->spec }}</td>
    </tr>
    @endif

    @if(!empty($dmt->dimet))
    <tr>
        <th>Dimethyltin Dichloride</th>
        <td>{{ $dmt->dimet }}</td>
    </tr>
    @endif

    @if(!empty($dmt->moisture))
    <tr>
        <th>Moisture Content</th>
        <td>{{ $dmt->moisture }}</td>
    </tr>
    @endif
</table>

            </div>
        </div>




        <a href="{{ route('dmt.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

@endsection
