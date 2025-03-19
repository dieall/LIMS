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
        <h6 class="m-0 font-weight-bold">Detail Data Pengajuan Chemical | {{ $pengajuanchemical->nama }}</h6>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $pengajuanchemical->tgl }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $pengajuanchemical->nama_chemical }}</td>
                    </tr>
                    <tr>
                        <th>Nama Sampel</th>
                        <td>{{ $pengajuanchemical->nama }}</td>
                    </tr>
                    <tr>
                        <th>Batch / Lot</th>
                        <td>{{ $pengajuanchemical->batch }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $pengajuanchemical->orang }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $pengajuanchemical->status }}</td>
                    </tr>
                </table>

                <!-- Tabel Riwayat Status -->
                <h5>Riwayat Status</h5>
                <table class="table table-bordered mt-3">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Jam Masuk</th>
            <th>Status</th>
            <th>Alasan Penolakan</th>
            <th>Interval Waktu</th>
            <th>Nama</th>
        
        </tr>
    </thead>
    <tbody>
    @php
        $no = 1;
        $previousDate = null;
    @endphp
    @foreach($pengajuanchemical->statusHistory as $history)
        @php
            $currentDate = \Carbon\Carbon::parse($history->changed_at);
            $interval = '-';

            if ($previousDate) {
                $interval = round($previousDate->diffInMinutes($currentDate), 0) . ' menit'; // Membulatkan interval ke angka bulat
            }

            $previousDate = $currentDate;
        @endphp
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ \Carbon\Carbon::parse($history->changed_at)->format('Y-m-d H:i:s') }}</td>
                <td>{{ $history->status }}</td>
                <td>{{ $history->rejection_reason ?? '-' }}</td>
                <td>{{ $interval }}</td>
                <td>{{ ucwords($history->user->name ?? 'Tidak Diketahui') }}</td> <!-- Normalisasi nama pengguna -->
               
            </tr>
        @endforeach

        <!-- Status Saat Ini -->
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ \Carbon\Carbon::parse($pengajuanchemical->jam_masuk)->format('Y-m-d H:i:s') }}</td>
            <td>{{ $pengajuanchemical->status }}</td>
            <td>{{ $pengajuanchemical->rejection_reason ?? '-' }}</td>
            
        </tr>
    </tbody>
</table>


                <!-- Form Penolakan Khusus Foreman -->
                @if (Auth::user()->level === 'Foreman' && $pengajuanchemical->status === 'Review Hasil')
    <form action="{{ route('pengajuanchemical.tolak', $pengajuanchemical->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="rejection_reason">Alasan Penolakan</label>
            <textarea id="rejection_reason" name="rejection_reason" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-danger mt-2">Tolak</button>
    </form>

@endif
            </div>
    

        <!-- Tabel Detail Tambahan -->
        <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Unsur Kimia</th>
                    <th>Results</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengajuanchemical->getAttributes() as $key => $value)
                    @if (!empty($value) && !in_array($key, [
                        'nama_chemical', 'nama', 'tgl', 'batch', 'desc', 'status',
                        'created_at', 'updated_at', 'orang', 'id', 'jam_masuk'
                    ]))
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
            <!-- Tombol Kembali -->
            <div class="mt-3">
            <a href="{{ route('pengajuanchemical.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
</div>
</div>


@endsection
