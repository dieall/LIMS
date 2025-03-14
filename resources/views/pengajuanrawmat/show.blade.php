@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengajuanrawmat.index') }}">Pengajuan Raw Material</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pengajuan Raw Material</li>
        </ol>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Detail Pengajuan Raw Material</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 10%;">Nama</th>
                        <th style="width: 10%;">Supplier</th>
                        <th style="width: 10%;">Spesifikasi</th>
                        <th style="width: 10%;">Satuan</th>
                        <th style="width: 10%;">COA</th>
                        <th style="width: 10%;">Result</th>
                        <th style="width: 5%;">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $spesifikasi = json_decode($pengajuanrawmat['spesifikasi'], true) ?? [];
                        $satuan = json_decode($pengajuanrawmat['satuan'], true) ?? [];
                        $coa = json_decode($pengajuanrawmat['coa'], true) ?? [];
                        $result = json_decode($pengajuanrawmat['result'], true) ?? [];
                        
                        // Find maximum row length
                        $maxLength = max(count($spesifikasi), count($satuan), count($coa), count($result));
                    @endphp

                    @for ($i = 0; $i < $maxLength; $i++)
                    <tr>
                        @if ($i == 0)
                        <td rowspan="{{ $maxLength }}">{{ $pengajuanrawmat['nama'] }}</td>
                        <td rowspan="{{ $maxLength }}">{{ $pengajuanrawmat['supplier'] }}</td>
                        @endif
                        <td>{{ $spesifikasi[$i] ?? '-' }}</td>
                        <td>{{ $satuan[$i] ?? '-' }}</td>
                        <td>{{ $coa[$i] ?? '-' }}</td>
                        <td>{{ $result[$i] ?? '-' }}</td>
                        @if ($i == 0)
                        <td rowspan="{{ $maxLength }}">{{ \Carbon\Carbon::parse($pengajuanrawmat['tgl'])->format('d-m-Y') }}</td>
                        @endif
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
