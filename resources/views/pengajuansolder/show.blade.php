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
        <div class="row">
            <!-- Kolom Kiri: Informasi Utama -->
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $pengajuansolder->tgl }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $pengajuansolder->category->nama_kategori ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Tipe Solder</th>
                        <td>{{ $pengajuansolder->tipe_solder }}</td>
                    </tr>

                    <tr>
                        <th>Batch / Lot</th>
                        <td>{{ $pengajuansolder->batch }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $pengajuansolder->nama }}</td>
                    </tr>
                    <tr>
                        <th>Jam Pengajuan</th>
                        <td>{{ $pengajuansolder->audit_trail}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $pengajuansolder->status }}</td>
                    </tr>
                </table>

                <!-- Tabel Riwayat Status -->
                <h5>Riwayat Status</h5>
                <table class="table table-bordered">
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
                @foreach($pengajuansolder->statusHistory as $history)
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
                            <td>{{ $currentDate->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $history->status }}</td>
                            <td>{{ $history->rejection_reason ?? '-' }}</td>
                            <td>{{ $interval }}</td>
                            <td>{{ ucwords($history->user->name ?? 'Tidak Diketahui') }}</td> <!-- Normalisasi nama pengguna -->
                        </tr>
                @endforeach
                <tr>
                    @php
                        $lastDate = \Carbon\Carbon::parse($pengajuansolder->jam_masuk);
                        $interval = $previousDate ? round($previousDate->diffInMinutes($lastDate), 0) . ' menit' : '-'; // Membulatkan interval ke angka bulat
                    @endphp
                    <td>{{ $no++ }}</td>
                    <td>{{ $lastDate->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $pengajuansolder->status }}</td>
                    <td>{{ $pengajuansolder->rejection_reason ?? '-' }}</td>
                    <td>{{ $interval }}</td>
                    <td>{{ ucwords($pengajuansolder->statusHistory->last()->user->name ?? 'Tidak Diketahui') }}</td> <!-- Normalisasi nama pengguna -->
                </tr>
                </tbody>
                </table>




                <!-- Formulir Penolakan untuk Foreman -->
                @if (Auth::user()->level === 'Foreman')
                    <form action="{{ route('pengajuansolder.tolak', $pengajuansolder->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="rejection_reason">Alasan Penolakan</label>
                            <textarea id="rejection_reason" name="rejection_reason" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger mt-2">Tolak</button>
                    </form>
                @endif
            </div>

            <!-- Kolom Kanan: Detail Solder -->
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th>Sn</th><td>{{ $pengajuansolder->sn ?? '-' }}</td></tr>
                    <tr><th>Ag</th><td>{{ $pengajuansolder->ag ?? '-' }}</td></tr>
                    <tr><th>Cu</th><td>{{ $pengajuansolder->cu ?? '-' }}</td></tr>
                    <tr><th>Pb</th><td>{{ $pengajuansolder->pb ?? '-' }}</td></tr>
                    <tr><th>Sb</th><td>{{ $pengajuansolder->sb ?? '-' }}</td></tr>
                    <tr><th>Zn</th><td>{{ $pengajuansolder->zn ?? '-' }}</td></tr>
                    <tr><th>Fe</th><td>{{ $pengajuansolder->fe ?? '-' }}</td></tr>
                    <tr><th>As</th><td>{{ $pengajuansolder->as ?? '-' }}</td></tr>
                    <tr><th>Ni</th><td>{{ $pengajuansolder->ni ?? '-' }}</td></tr>
                    <tr><th>Bi</th><td>{{ $pengajuansolder->bi ?? '-' }}</td></tr>
                    <tr><th>Cd</th><td>{{ $pengajuansolder->cd ?? '-' }}</td></tr>
                    <tr><th>Ai</th><td>{{ $pengajuansolder->ai ?? '-' }}</td></tr>
                    <tr><th>Pe</th><td>{{ $pengajuansolder->pe ?? '-' }}</td></tr>
                    <tr><th>Ga</th><td>{{ $pengajuansolder->ga ?? '-' }}</td></tr>
                </table>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-3">
            <a href="{{ route('pengajuansolder.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

@endsection
