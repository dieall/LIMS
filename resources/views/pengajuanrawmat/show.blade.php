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
    
    /* Bootstrap 4 badges */
    .bg-primary { background-color: #007bff !important; color: white; }
    .bg-success { background-color: #28a745 !important; color: white; }
    .bg-info { background-color: #17a2b8 !important; color: white; }
    .bg-warning { background-color: #ffc107 !important; color: #212529; }
    .bg-secondary { background-color: #6c757d !important; color: white; }
    
    /* Progress bar */
    .progress {
        height: 25px;
        margin-bottom: 1rem;
    }
    .progress-bar {
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    /* Utility classes for spacing */
    .mr-1 { margin-right: 0.25rem !important; }
    .mr-2 { margin-right: 0.5rem !important; }
    .mt-2 { margin-top: 0.5rem !important; }
    .mt-3 { margin-top: 1rem !important; }
    .mb-4 { margin-bottom: 1.5rem !important; }
</style>

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengajuanrawmat.index') }}">Data Raw Material</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Raw Material</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Detail Data Raw Material | {{ $pengajuanrawmat->nama }}</h6>
        <span class="badge {{ getStatusBadgeClass($pengajuanrawmat->status) }}">{{ $pengajuanrawmat->status }}</span>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Column 1: Basic Information & Status History -->
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ \Carbon\Carbon::parse($pengajuanrawmat->tgl)->format('d F Y') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $pengajuanrawmat->nama_rawmat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama Sampel</th>
                        <td>{{ $pengajuanrawmat->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Batch</th>
                        <td>{{ $pengajuanrawmat->batch ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Supplier</th>
                        <td>{{ $pengajuanrawmat->supplier ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. Mobil/Container</th>
                        <td>{{ $pengajuanrawmat->no_mobil ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $pengajuanrawmat->desc ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($pengajuanrawmat->status == 'Pengajuan')
                                <span class="badge bg-primary">{{ $pengajuanrawmat->status }}</span>
                            @elseif ($pengajuanrawmat->status == 'Proses Analisa')
                                <span class="badge bg-info">{{ $pengajuanrawmat->status }}</span>
                            @elseif ($pengajuanrawmat->status == 'Selesai Analisa' || $pengajuanrawmat->status == 'Analisa Selesai')
                                <span class="badge bg-secondary">{{ $pengajuanrawmat->status }}</span>
                            @elseif ($pengajuanrawmat->status == 'Review Hasil')
                                <span class="badge bg-warning">{{ $pengajuanrawmat->status }}</span>
                            @elseif ($pengajuanrawmat->status == 'Approve')
                                <span class="badge bg-success">{{ $pengajuanrawmat->status }}</span>
                            @else
                                {{ $pengajuanrawmat->status ?? '-' }}
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
                                $hasCoaApprovedStatus = false;
                            @endphp

                            @forelse($pengajuanrawmat->statusHistory as $history)
                                @php
                                    // Save the last status we find in history
                                    $lastStatusInHistory = $history->status;
                                    
                                    // Check if we have a CoA Approved status
                                    if ($history->status === 'CoA Approved') {
                                        $hasCoaApprovedStatus = true;
                                    }
                                    
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
                                    <td>
                                        @if ($history->status === 'CoA Approved')
                                            <span class="badge bg-success">{{ $history->status }}</span>
                                        @else
                                            {{ $history->status }}
                                        @endif
                                    </td>
                                    <td>{{ $history->rejection_reason ?? '-' }}</td>
                                    <td>{{ $interval }}</td>
                                    <td>{{ ucwords($history->user_name ?? $history->user->name ?? 'Tidak Diketahui') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada riwayat status</td>
                                </tr>
                            @endforelse

                            <!-- Only add the current status if it's not already the last status in history -->
                            <!-- AND we don't have a CoA Approved status -->
                            @if($pengajuanrawmat->statusHistory->count() > 0 && $lastStatusInHistory !== $pengajuanrawmat->status && !$hasCoaApprovedStatus)
                                <tr>
                                    @php
                                        // Menghitung interval waktu dari status terakhir hingga status saat ini
                                        $lastDate = \Carbon\Carbon::parse($pengajuanrawmat->jam_masuk);
                                        $interval = $previousDate ? round($previousDate->diffInMinutes($lastDate), 0) . ' menit' : '-';
                                        
                                        // Get the last user who modified this record
                                        $lastUserName = $pengajuanrawmat->statusHistory->last() ? 
                                            ($pengajuanrawmat->statusHistory->last()->user_name ?? 
                                             $pengajuanrawmat->statusHistory->last()->user->name ?? 'Tidak Diketahui') : 
                                            'Tidak Diketahui';
                                    @endphp
                                    <td>{{ $no }}</td>
                                    <td>{{ $lastDate->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $pengajuanrawmat->status }}</td>
                                    <td>{{ $pengajuanrawmat->rejection_reason ?? '-' }}</td>
                                    <td>{{ $interval }}</td>
                                    <td>{{ ucwords($lastUserName) }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <!-- Form Penolakan for Foreman -->
                @if (Auth::user()->level === 'Foreman' && $pengajuanrawmat->status === 'Review Hasil')
                    <form action="{{ route('pengajuanrawmat.tolak', $pengajuanrawmat->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="rejection_reason">Alasan Penolakan</label>
                            <textarea id="rejection_reason" name="rejection_reason" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger mt-2">Tolak</button>
                    </form>
                @endif
            </div>

            <!-- Column 2: Raw Material Properties with Status -->
            <div class="col-md-6">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Value</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $excludedFields = [
                                'id', 'nama_rawmat', 'nama', 'tgl', 'batch', 'desc', 'status',
                                'created_at', 'updated_at', 'jam_masuk', 'supplier', 'no_mobil',
                                'coa', 'user_id'
                            ];
                            
                            $displayNames = [
                                'sn' => 'Tin (Sn)',
                                'purity' => 'Purity',
                                'purity_tmac' => 'Purity TMAC',
                                'appreance' => 'Appearance',
                                'sg' => 'Specific Gravity',
                                'fe_amo' => 'Fe Amount',
                                'si_amo' => 'Si Amount',
                                'sh' => 'SH',
                                'acid' => 'Acid Value',
                                'ri' => 'Refractive Index',
                                'free' => 'Free Content',
                                'ph' => 'pH Value',
                                'fe' => 'Iron (Fe)',
                                'si' => 'Silicon (Si)',
                                'sulfur' => 'Sulfur Content',
                                'visual' => 'Visual',
                                'water' => 'Water Content',
                                'color' => 'Color',
                                'acidity' => 'Acidity',
                                'lodine' => 'Iodine Value',
                                'ag' => 'Silver (Ag)',
                                'cu' => 'Copper (Cu)',
                                'pb' => 'Lead (Pb)',
                                'sb' => 'Antimony (Sb)',
                                'zn' => 'Zinc (Zn)',
                                'as' => 'Arsenic (As)',
                                'ni' => 'Nickel (Ni)',
                                'bi' => 'Bismuth (Bi)',
                                'cd' => 'Cadmium (Cd)',
                                'ai' => 'Aluminum (Al)',
                                'pe' => 'Petroleum',
                                'ga' => 'Gallium (Ga)',
                                'densi' => 'Density',
                                'clarity' => 'Clarity',
                                'apha' => 'APHA Color'
                            ];
                            
                            // Count for status summary
                            $passedCount = 0;
                            $notPassedCount = 0;
                            $notTestedCount = 0;
                            $totalFields = 0;
                        @endphp
                        
                        @foreach ($pengajuanrawmat->getAttributes() as $key => $value)
                            @if (!empty($value) && !in_array($key, $excludedFields) && !str_ends_with($key, '_status'))
                                @php
                                    $totalFields++;
                                    $statusKey = $key . '_status';
                                    $status = $pengajuanrawmat->$statusKey ?? null;
                                    
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
                        
                        @if($totalFields == 0)
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data parameter yang tersedia</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

              
            </div>
        </div>
        
        <!-- Tombol Kembali - outside the row but inside card-body -->
        <div class="mt-3">
            <a href="{{ route('pengajuanrawmat.index') }}" class="btn btn-secondary">Kembali</a>
            @if (Auth::user()->level === 'Admin' || Auth::user()->level === 'Supervisor')
                <a href="{{ route('pengajuanrawmat.edit', $pengajuanrawmat->id) }}" class="btn btn-primary ml-2">Edit</a>
            @endif
            @if ($pengajuanrawmat->status === 'Approve')
                <a href="{{ route('pengajuanrawmat.print', $pengajuanrawmat->id) }}" class="btn btn-success ml-2">
                    <i class="fas fa-print mr-1"></i> Print
                </a>
            @endif
        </div>
    </div>
</div>

@php
// Helper function for generating status badges in the status column
function getStatusBadge($status) {
    if($status == 'Passed') {
        return '<span class="validation-success"><i class="fas fa-check-circle mr-1"></i> Passed</span>';
    } elseif($status == 'Not Passed') {
        return '<span class="validation-error"><i class="fas fa-times-circle mr-1"></i> Not Passed</span>';
    } else {
        return '<span class="text-secondary"><i class="fas fa-minus-circle mr-1"></i> Not Tested</span>';
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
        case 'Analisa Selesai':
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
