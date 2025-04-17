@extends('layouts.app')

@section('contents')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Aktivitas User: {{ $user->name }}</h1>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Berdasarkan Bulan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('datainterval.show', $user->id) }}">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="month" class="form-label">Pilih Bulan:</label>
                        <select name="month" id="month" class="form-control" onchange="this.form.submit()">
                            @foreach(range(1, 12) as $month)
                                <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}" 
                                    {{ $selectedMonth == str_pad($month, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Tables Row -->
    <div class="row">
        <!-- Solder Data Table -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Analisa Sampel Solder (Analisa Selesai)</h6>
                </div>
                <div class="card-body">
                    @if($solderData->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Status</th>
                                        <th>Batch</th>
                                        <th>Solder</th>
                                        <th>Interval</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($solderData as $key => $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($data->status == 'Pengajuan')
                                                    <span class="badge badge-primary">{{ $data->status }}</span>
                                                @elseif($data->status == 'Proses Analisa')
                                                    <span class="badge badge-info">{{ $data->status }}</span>
                                                @elseif(in_array($data->status, ['Analisa Selesai', 'Selesai Analisa']))
                                                    <span class="badge badge-secondary">{{ $data->status }}</span>
                                                @elseif($data->status == 'Review Hasil')
                                                    <span class="badge badge-warning">{{ $data->status }}</span>
                                                @elseif($data->status == 'Approve')
                                                    <span class="badge badge-success">{{ $data->status }}</span>
                                                @elseif($data->status == 'CoA Approved')
                                                    <span class="badge badge-success">{{ $data->status }}</span>
                                                @elseif(str_contains($data->status, 'CoA'))
                                                    <span class="badge badge-info">{{ $data->status }}</span>
                                                @else
                                                    <span class="badge badge-dark">{{ $data->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $data->pengajuanSolder->batch ?? 'N/A' }}</td>
                                            <td>{{ $data->pengajuanSolder->tipe_solder ?? 'N/A' }}</td>
                                            <td>{{ round(floatval($data->interval)) }} menit</td>
                                            <td>{{ \Carbon\Carbon::parse($data->changed_at)->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada data solder yang selesai dianalisa.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Chemical Data Table -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Analisa Sampel Chemical (Analisa Selesai)</h6>
                </div>
                <div class="card-body">
                    @if($chemicalData->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Status</th>
                                        <th>Batch</th>
                                        <th>Sampel</th>
                                        <th>Interval</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chemicalData as $key => $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($data->status == 'Pengajuan')
                                                    <span class="badge badge-primary">{{ $data->status }}</span>
                                                @elseif($data->status == 'Proses Analisa')
                                                    <span class="badge badge-info">{{ $data->status }}</span>
                                                @elseif(in_array($data->status, ['Analisa Selesai', 'Selesai Analisa']))
                                                    <span class="badge badge-secondary">{{ $data->status }}</span>
                                                @elseif($data->status == 'Review Hasil')
                                                    <span class="badge badge-warning">{{ $data->status }}</span>
                                                @elseif($data->status == 'Approve')
                                                    <span class="badge badge-success">{{ $data->status }}</span>
                                                @elseif($data->status == 'CoA Approved')
                                                    <span class="badge badge-success">{{ $data->status }}</span>
                                                @elseif(str_contains($data->status, 'CoA'))
                                                    <span class="badge badge-info">{{ $data->status }}</span>
                                                @else
                                                    <span class="badge badge-dark">{{ $data->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $data->pengajuanChemical->batch ?? 'N/A' }}</td>
                                            <td>{{ $data->pengajuanChemical->nama ?? 'N/A' }}</td> 
                                            <td>{{ round(floatval($data->interval)) }} menit</td>
                                            <td>{{ \Carbon\Carbon::parse($data->changed_at)->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada data chemical yang selesai dianalisa.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Card -->
    <style>
    /* Card styling enhancements */
    .stats-card {
        border-radius: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
        overflow: hidden;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
    }
    
    /* Customized left borders with gradients */
    .border-left-primary {
        border-left: 0;
        background: linear-gradient(to right, #4e73df 8px, white 8px);
    }
    .border-left-info {
        border-left: 0;
        background: linear-gradient(to right, #36b9cc 8px, white 8px);
    }
    .border-left-warning {
        border-left: 0;
        background: linear-gradient(to right, #f6c23e 8px, white 8px);
    }
    .border-left-success {
        border-left: 0;
        background: linear-gradient(to right, #1cc88a 8px, white 8px);
    }
    
    /* Card header with subtle background */
    .main-card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    /* Improved icon styling */
    .stats-icon {
        padding: 15px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 0.9;
    }
    .icon-primary { background-color: #4e73df; }
    .icon-info { background-color: #36b9cc; }
    .icon-warning { background-color: #f6c23e; }
    .icon-success { background-color: #1cc88a; }
    
    /* Value styling */
    .stats-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #5a5c69;
    }
    
    /* Title styling */
    .stats-title {
        font-size: 0.7rem;
        font-weight: bold;
        letter-spacing: 0.05em;
    }
    
    /* Count styling */
    .stats-count {
        font-size: 0.75rem;
        color: #858796;
        font-weight: 500;
        padding-top: 4px;
    }
    
    /* Add subtle background to the main card */
    .summary-card {
        background-color: #fcfcfc;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
</style>

<div class="card shadow mb-4 summary-card">
    <div class="card-header py-3 main-card-header">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-chart-line mr-2"></i> Ringkasan Aktivitas & Rata-rata Waktu Analisa
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Total Time Accumulation -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2 stats-card border-left-primary">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="stats-title text-primary text-uppercase mb-2">
                                    Total Akumulasi Waktu
                                </div>
                                <div class="stats-value">
                                    {{ $hours }} Jam {{ $minutes }} Menit
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stats-icon icon-primary">
                                    <i class="fas fa-clock fa-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Average Solder Analysis Time -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2 stats-card border-left-info">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="stats-title text-info text-uppercase mb-2">
                                    Rata-rata Analisa Solder
                                </div>
                                <div class="stats-value">
                                    @if($avgSolderMinutes > 0 || $solderData->count() > 0)
                                        {{ floor($avgSolderMinutes / 60) }} Jam {{ $avgSolderMinutes % 60 }} Menit
                                    @else
                                        - 
                                    @endif
                                </div>
                                <div class="stats-count">
                                    <i class="fas fa-layer-group mr-1"></i> {{ $solderData->count() }} sampel
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stats-icon icon-info">
                                    <i class="fas fa-tools fa-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Average Chemical Analysis Time -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2 stats-card border-left-warning">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="stats-title text-warning text-uppercase mb-2">
                                    Rata-rata Analisa Chemical
                                </div>
                                <div class="stats-value">
                                    @if($avgChemicalMinutes > 0 || $chemicalData->count() > 0)
                                        {{ floor($avgChemicalMinutes / 60) }} Jam {{ $avgChemicalMinutes % 60 }} Menit
                                    @else
                                        -
                                    @endif
                                </div>
                                <div class="stats-count">
                                    <i class="fas fa-layer-group mr-1"></i> {{ $chemicalData->count() }} sampel
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stats-icon icon-warning">
                                    <i class="fas fa-flask fa-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Overall Average -->
        <div class="row">
            <div class="col-lg-8 col-md-12 mb-4">
                <div class="card shadow h-100 py-2 stats-card border-left-success">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="stats-title text-success text-uppercase mb-2">
                                    Rata-rata Keseluruhan (Per Sampel)
                                </div>
                                <div class="stats-value">
                                    @if(($solderData->count() + $chemicalData->count()) > 0)
                                        {{ floor($avgOverallMinutes / 60) }} Jam {{ $avgOverallMinutes % 60 }} Menit
                                    @else
                                        Belum ada data analisa
                                    @endif
                                </div>
                                <div class="stats-count">
                                    <i class="fas fa-layer-group mr-1"></i> Total {{ $solderData->count() + $chemicalData->count() }} sampel
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stats-icon icon-success">
                                    <i class="fas fa-chart-line fa-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card shadow h-100 py-3" style="background-color: #f8f9fc;">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <a href="{{ route('datainterval') }}" class="btn btn-secondary mr-3">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <a href="{{ route('export.data.interval', ['user_id' => $user->id, 'month' => $selectedMonth]) }}" 
                           class="btn btn-success">
                            <i class="fas fa-file-excel mr-1"></i> Export
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

<style>
/* Fix for Bootstrap 4 badges */
.badge {
    display: inline-block;
    padding: 0.25em 0.4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
    color: #fff;
}
.badge-primary {
    background-color: #4e73df;
}
.badge-secondary {
    background-color: #858796;
}
.badge-success {
    background-color: #1cc88a;
}
.badge-danger {
    background-color: #e74a3b;
}
.badge-warning {
    background-color: #f6c23e;
    color: #000;
}
.badge-info {
    background-color: #36b9cc;
}
.badge-light {
    background-color: #f8f9fc;
    color: #000;
}
.badge-dark {
    background-color: #5a5c69;
}

/* Fix for spacing */
.mr-2 {
    margin-right: 0.5rem !important;
}
</style>
