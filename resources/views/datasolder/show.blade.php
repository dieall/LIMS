@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Detail Solder</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Detail Data Solder</h6>
    </div>

    <!-- Tampilkan data solder -->
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="col-md-4">Field</th>
                    <th class="col-md-8">Value</th>
                </tr>
            </thead>
            <tbody>
                @if($solder->id)
                    <tr><td><strong>ID</strong></td><td>{{ $solder->id }}</td></tr>
                @endif
                @if($solder->nama_kategori)
                    <tr><td><strong>Nama Kategori</strong></td><td>{{ $solder->nama_kategori }}</td></tr>
                @endif
                @if($solder->tipe_solder)
                    <tr><td><strong>Tipe Solder</strong></td><td>{{ $solder->tipe_solder }}</td></tr>
                @endif
                @if($solder->spesification)
                    <tr><td><strong>Spesifikasi</strong></td><td>{{ $solder->spesification }}</td></tr>
                @endif
                @if($solder->tgl)
                    <tr><td><strong>Tanggal</strong></td><td>{{ $solder->tgl }}</td></tr>
                @endif
                @if($solder->rev)
                    <tr><td><strong>Rev</strong></td><td>{{ $solder->rev }}</td></tr>
                @endif
                @if($solder->sn)
                    <tr><td><strong>SN</strong></td><td>{{ $solder->sn }}</td></tr>
                @endif
                @if($solder->ag)
                    <tr><td><strong>AG</strong></td><td>{{ $solder->ag }}</td></tr>
                @endif
                @if($solder->cu)
                    <tr><td><strong>CU</strong></td><td>{{ $solder->cu }}</td></tr>
                @endif
                @if($solder->pb)
                    <tr><td><strong>PB</strong></td><td>{{ $solder->pb }}</td></tr>
                @endif
                @if($solder->sb)
                    <tr><td><strong>SB</strong></td><td>{{ $solder->sb }}</td></tr>
                @endif
                @if($solder->zn)
                    <tr><td><strong>ZN</strong></td><td>{{ $solder->zn }}</td></tr>
                @endif
                @if($solder->fe)
                    <tr><td><strong>FE</strong></td><td>{{ $solder->fe }}</td></tr>
                @endif
                @if($solder->as)
                    <tr><td><strong>AS</strong></td><td>{{ $solder->as }}</td></tr>
                @endif
                @if($solder->ni)
                    <tr><td><strong>NI</strong></td><td>{{ $solder->ni ?? 'N/A' }}</td></tr>
                @endif
                @if($solder->bi)
                    <tr><td><strong>BI</strong></td><td>{{ $solder->bi }}</td></tr>
                @endif
                @if($solder->cd)
                    <tr><td><strong>CD</strong></td><td>{{ $solder->cd ?? 'N/A' }}</td></tr>
                @endif
                @if($solder->ai)
                    <tr><td><strong>AI</strong></td><td>{{ $solder->ai }}</td></tr>
                @endif
                @if($solder->pe)
                    <tr><td><strong>PE</strong></td><td>{{ $solder->pe }}</td></tr>
                @endif
                @if($solder->ga)
                    <tr><td><strong>GA</strong></td><td>{{ $solder->ga ?? 'N/A' }}</td></tr>
                @endif
                @if($solder->created_at)
                    <tr><td><strong>Created At</strong></td><td>{{ $solder->created_at }}</td></tr>
                @endif
                @if($solder->updated_at)
                    <tr><td><strong>Updated At</strong></td><td>{{ $solder->updated_at }}</td></tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Tombol Kembali -->
    <div class="mt-4 d-flex justify-content-end">
        <a href="{{ route('datasolder') }}" class="btn btn-primary btn-lg">Kembali ke Daftar Solder</a>
    </div>
    <br>
</div>

@endsection
