@extends('layouts.app')

@section('contents')

<div class="container">
    <h1>Detail Pengajuan Solder</h1>
    <hr>
    <table class="table table-bordered">
        <tr>
            <th>Tanggal</th>
            <td>{{ $pengajuansolder->tgl }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $pengajuansolder->kategori->id_category ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Tipe Solder</th>
            <td>{{ $pengajuansolder->tipe_solder }}</td>
        </tr>
        <tr>
            <th>Detail Solder</th>
            <td>
                @php
                    $detail = null;

                    // Cari di tabel terkait
                    if ($pengajuansolder->tipe_solder) {
                        $detail = $tbs_sncu->where('tipe_solder', $pengajuansolder->tipe_solder)->first() 
                            ?? $tbs_snagcu->where('tipe_solder', $pengajuansolder->tipe_solder)->first()
                            ?? $tbs_snag->where('tipe_solder', $pengajuansolder->tipe_solder)->first()
                            ?? $tbs_tin->where('tipe_solder', $pengajuansolder->tipe_solder)->first();
                    }
                @endphp

                @if ($detail)
                    <ul>
                        <li>Nama Solder: {{ $detail->nama_solder ?? 'Tidak tersedia' }}</li>
                        <li>Spesifikasi: {{ $detail->spesifikasi ?? 'Tidak tersedia' }}</li>
                        <li>Harga: {{ $detail->harga ?? 'Tidak tersedia' }}</li>
                    </ul>
                @else
                    Data detail tidak tersedia.
                @endif
            </td>
        </tr>
        <tr>
            <th>Batch / Lot</th>
            <td>{{ $pengajuansolder->batch }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $pengajuansolder->nama }}</td>
        </tr>
    </table>
    <a href="{{ route('pengajuansolder.index') }}" class="btn btn-secondary">Kembali</a>
</div>

@endsection
