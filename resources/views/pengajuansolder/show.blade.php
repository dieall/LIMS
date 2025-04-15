@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Detail Pengajuan Solder</li>
        </ol>
    </nav>
    <hr>
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
                        <td>{{ $pengajuansolder->tgl ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $pengajuansolder->datasolder->nama_kategori ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Tipe Solder</th>
                        <td>{{ $pengajuansolder->tipe_solder ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Batch / Lot</th>
                        <td>{{ $pengajuansolder->batch ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $pengajuansolder->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jam Pengajuan</th>
                        <td>{{ $pengajuansolder->audit_trail ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($pengajuansolder->status == 'Pengajuan')
                                <span class="badge bg-primary">{{ $pengajuansolder->status }}</span>
                            @elseif ($pengajuansolder->status == 'Proses Analisa')
                                <span class="badge bg-info">{{ $pengajuansolder->status }}</span>
                            @elseif ($pengajuansolder->status == 'Selesai Analisa')
                                <span class="badge bg-secondary">{{ $pengajuansolder->status }}</span>
                            @elseif ($pengajuansolder->status == 'Review Hasil')
                                <span class="badge bg-warning">{{ $pengajuansolder->status }}</span>
                            @elseif ($pengajuansolder->status == 'Approve')
                                <span class="badge bg-success">{{ $pengajuansolder->status }}</span>
                            @else
                                {{ $pengajuansolder->status ?? '-' }}
                            @endif
                        </td>
                    </tr>
                </table>

                <!-- Tabel Riwayat Status -->
                <h5>Riwayat Status</h5>
                <div class="table-responsive">
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
                                $lastStatusInHistory = null;
                            @endphp

                            @forelse($pengajuansolder->statusHistory as $history)
                                @php
                                    // Save the last status we find in history
                                    $lastStatusInHistory = $history->status;
                                    
                                    // Menghitung interval waktu antara status saat ini dan status sebelumnya
                                    $currentDate = \Carbon\Carbon::parse($history->changed_at);
                                    $interval = '-';

                                    if ($previousDate) {
                                        // Membulatkan interval waktu ke angka bulat dalam satuan menit
                                        $interval = round($previousDate->diffInMinutes($currentDate), 0) . ' menit';
                                    }

                                    // Menyimpan tanggal status sebelumnya untuk perhitungan interval selanjutnya
                                    $previousDate = $currentDate;
                                @endphp

                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $currentDate->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $history->status }}</td>
                                    <td>{{ $history->rejection_reason ?? '-' }}</td>
                                    <td>{{ $interval }}</td>
                                    <td>{{ ucwords($history->user->name ?? 'Tidak Diketahui') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada riwayat status</td>
                                </tr>
                            @endforelse

                            <!-- Only add the current status if it's not already the last status in history -->
                            @if($pengajuansolder->statusHistory->count() > 0 && $lastStatusInHistory !== $pengajuansolder->status)
                                <tr>
                                    @php
                                        // Menghitung interval waktu dari status terakhir hingga status saat ini
                                        $lastDate = \Carbon\Carbon::parse($pengajuansolder->jam_masuk);
                                        $interval = $previousDate ? round($previousDate->diffInMinutes($lastDate), 0) . ' menit' : '-';
                                        
                                        // Get the last user who modified this record
                                        $lastUserName = $pengajuansolder->statusHistory->last() ? 
                                            $pengajuansolder->statusHistory->last()->user->name ?? 'Tidak Diketahui' : 'Tidak Diketahui';
                                    @endphp
                                    <td>{{ $no }}</td>
                                    <td>{{ $lastDate->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $pengajuansolder->status }}</td>
                                    <td>{{ $pengajuansolder->rejection_reason ?? '-' }}</td>
                                    <td>{{ $interval }}</td>
                                    <td>{{ ucwords($lastUserName) }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Formulir Penolakan untuk Foreman -->
                @if (Auth::user()->level === 'Foreman' && $pengajuansolder->status === 'Review Hasil')
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

            <!-- Kolom Kanan: Detail Solder dengan Status Validasi -->
            <div class="col-md-6">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Unsur Kimia</th>
                            <th>Hasil</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Sn</th>
                            <td>{{ $pengajuansolder->sn ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->sn_status) !!}</td>
                        </tr>
                        <tr>
                            <th>Ag</th>
                            <td>{{ $pengajuansolder->ag ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->ag_status) !!}</td>
                        </tr>
                        <tr>
                            <th>Cu</th>
                            <td>{{ $pengajuansolder->cu ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->cu_status) !!}</td>
                        </tr>
                        <tr>
                            <th>Pb</th>
                            <td>{{ $pengajuansolder->pb ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->pb_status) !!}</td>
                        </tr>
                        <tr>
                            <th>Sb</th>
                            <td>{{ $pengajuansolder->sb ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->sb_status) !!}</td>
                        </tr>
                        <tr>
                            <th>Zn</th>
                            <td>{{ $pengajuansolder->zn ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->zn_status) !!}</td>
                        </tr>
                        <tr>
                            <th>Fe</th>
                            <td>{{ $pengajuansolder->fe ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->fe_status) !!}</td>
                        </tr>
                        <tr>
                            <th>As</th>
                            <td>{{ $pengajuansolder->as ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->as_status) !!}</td>
                        </tr>
                        <tr>
                            <th>Ni</th>
                            <td>{{ $pengajuansolder->ni ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->ni_status) !!}</td>
                        </tr>
                        <tr>
                            <th>Bi</th>
                            <td>{{ $pengajuansolder->bi ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->bi_status) !!}</td>
                        </tr>
                        <tr>
                            <th>Cd</th>
                            <td>{{ $pengajuansolder->cd ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->cd_status) !!}</td>
                        </tr>
                        <tr>
                            <th>Ai</th>
                            <td>{{ $pengajuansolder->ai ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->ai_status) !!}</td>
                        </tr>
                        <tr>
                            <th>Pe</th>
                            <td>{{ $pengajuansolder->pe ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->pe_status) !!}</td>
                        </tr>
                        <tr>
                            <th>Ga</th>
                            <td>{{ $pengajuansolder->ga ?? '-' }}</td>
                            <td>{!! getStatusBadge($pengajuansolder->ga_status) !!}</td>
                        </tr>
                    </tbody>
                </table>
                

            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-3">
            <a href="{{ route('pengajuansolder.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

@php
// Helper function for generating status badges
function getStatusBadge($status) {
    if($status == 'Passed') {
        return '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Passed</span>';
    } elseif($status == 'Not Passed') {
        return '<span class="badge bg-danger"><i class="fas fa-times-circle"></i> Not Passed</span>';
    } else {
        return '<span class="badge bg-secondary"><i class="fas fa-minus-circle"></i> Not Tested</span>';
    }
}
@endphp

<style>
    /* Status badges */
    .badge {
        padding: 0.4em 0.6em;
        font-size: 0.875em;
    }
    
    /* Progress bar */
    .progress {
        height: 25px;
    }
    .progress-bar {
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    /* Table enhancements */
    .table th {
        background-color: #f8f9fa;
    }
</style>

@endsection
