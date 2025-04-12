@extends('layouts.app')

@section('contents')
<style>
    /* Validation status styles */
    .validation-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 12px;
        font-weight: bold;
        display: inline-block;
    }

    .validation-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 12px;
        font-weight: bold;
        display: inline-block;
    }
    
    /* Badge styles */
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
</style>

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Detail Pengajuan Chemical</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Detail Data Pengajuan Chemical | {{ $pengajuanchemical->nama }}</h6>
        <span class="badge {{ getStatusBadgeClass($pengajuanchemical->status) }}">{{ $pengajuanchemical->status }}</span>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Column 1: Basic Information & Status History -->
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $pengajuanchemical->tgl ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $pengajuanchemical->nama_chemical ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama Sampel</th>
                        <td>{{ $pengajuanchemical->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Batch / Lot</th>
                        <td>{{ $pengajuanchemical->batch ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $pengajuanchemical->orang ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($pengajuanchemical->status == 'Pengajuan')
                                <span class="badge bg-primary">{{ $pengajuanchemical->status }}</span>
                            @elseif ($pengajuanchemical->status == 'Proses Analisa')
                                <span class="badge bg-info">{{ $pengajuanchemical->status }}</span>
                            @elseif ($pengajuanchemical->status == 'Selesai Analisa')
                                <span class="badge bg-secondary">{{ $pengajuanchemical->status }}</span>
                            @elseif ($pengajuanchemical->status == 'Review Hasil')
                                <span class="badge bg-warning">{{ $pengajuanchemical->status }}</span>
                            @elseif ($pengajuanchemical->status == 'Approve')
                                <span class="badge bg-success">{{ $pengajuanchemical->status }}</span>
                            @else
                                {{ $pengajuanchemical->status ?? '-' }}
                            @endif
                        </td>
                    </tr>
                </table>

                <!-- Tabel Riwayat Status -->
                <h5>Riwayat Status</h5>
                <div class="table-responsive">
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

                            @forelse($pengajuanchemical->statusHistory as $history)
                                @php
                                    $currentDate = \Carbon\Carbon::parse($history->changed_at);
                                    $interval = '-';

                                    if ($previousDate) {
                                        // Calculate interval in minutes
                                        $interval = round($previousDate->diffInMinutes($currentDate)) . ' menit';
                                    }

                                    // Store date for next iteration
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

                            <!-- Only add current status if it's not already in history -->
                            @if(!$pengajuanchemical->statusHistory->contains('status', $pengajuanchemical->status))
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pengajuanchemical->jam_masuk)->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $pengajuanchemical->status }}</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>{{ $pengajuanchemical->orang ?? 'Tidak Diketahui' }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

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

            <!-- Column 2: Chemical Properties with Status -->
            <div class="col-md-6">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Unsur Kimia</th>
                            <th>Results</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $excludedFields = [
                                'nama_chemical', 'nama', 'tgl', 'batch', 'desc', 'status',
                                'created_at', 'updated_at', 'orang', 'id', 'jam_masuk'
                            ];
                            
                            $displayNames = [
                                'clarity' => 'Clarity',
                                'transmission' => '% Transmission',
                                'ape' => 'Appearance',
                                'dimet' => 'Dimethyltin Dichloride',
                                'trime' => 'Trimethyltin Monochloride',
                                'tin' => '% Tin',
                                'solid' => '% Solid Content',
                                'ri' => 'RI @ 25°C',
                                'sg' => 'SG @ 25°C',
                                'acid' => 'Acid Value',
                                'sulfur' => '% Sulfur',
                                'water' => 'Water Content',
                                'mono' => 'Monomethyltin',
                                'yellow' => 'Yellowish Index',
                                'eh' => '2-EH',
                                'visco' => 'Viscosity @ 25°C',
                                'pt' => 'Pt-Co',
                                'moisture' => 'Moisture Content',
                                'cloride' => '% Chloride',
                                'spec' => 'Specific Gravity (25°C)',
                                'densi' => 'Density'
                            ];
                            
                            // Count for status summary
                            $passedCount = 0;
                            $notPassedCount = 0;
                            $notTestedCount = 0;
                            $totalFields = 0;
                        @endphp
                        
                        @foreach ($pengajuanchemical->getAttributes() as $key => $value)
                            @if (!empty($value) && !in_array($key, $excludedFields) && !str_ends_with($key, '_status'))
                                @php
                                    $totalFields++;
                                    $statusKey = $key . '_status';
                                    $status = $pengajuanchemical->$statusKey ?? null;
                                    
                                    if ($status === 'Passed') {
                                        $passedCount++;
                                    } elseif ($status === 'Not Passed') {
                                        $notPassedCount++;
                                    } else {
                                        $notTestedCount++;
                                    }
                                @endphp
                                
                                <tr>
                                    <td>{{ $displayNames[$key] ?? ucfirst(str_replace('_', ' ', $key)) }}</td>
                                    <td>{{ $value }}</td>
                                    <td>{!! getStatusBadge($status) !!}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
 
            </div>
        </div>
        
        <!-- Tombol Kembali - outside the row but inside card-body -->
        <div class="mt-3">
            <a href="{{ route('pengajuanchemical.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

@php
// Helper function for generating status badges in the status column
function getStatusBadge($status) {
    if($status == 'Passed') {
        return '<span class="validation-success"><i class="fas fa-check-circle"></i> Passed</span>';
    } elseif($status == 'Not Passed') {
        return '<span class="validation-error"><i class="fas fa-times-circle"></i> Not Passed</span>';
    } else {
        return '<span class="text-secondary"><i class="fas fa-minus-circle"></i> Not Tested</span>';
    }
}

// Helper function for status badge classes in the header
function getStatusBadgeClass($status) {
    switch ($status) {
        case 'Pengajuan':
            return 'bg-primary';
        case 'Proses Analisa':
            return 'bg-info';
        case 'Selesai Analisa':
            return 'bg-secondary';
        case 'Review Hasil':
            return 'bg-warning';
        case 'Approve':
            return 'bg-success';
        default:
            return 'bg-secondary';
    }
}
@endphp

@endsection
