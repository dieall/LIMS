
@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Export Data</li>
        </ol>
        <hr>
    </nav>
</div>



    <!-- Filter Form -->
    <div class="card shadow mb-4">
<div class="card-header py-2 d-flex justify-content-between align-items-center">
        <div class="card-body">
        <h2 class="fw-bold">Export Data</h2>
        <p class="text-muted">Pilih rentang tanggal untuk mengekspor data ke Excel</p>
        <hr>
            <form method="GET" action="" id="filter-form" class="row g-3">
                <div class="col-md-5">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-5">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-primary w-100" onclick="applyFilter()">
                        <i class="fas fa-filter"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">
            <p class="text-muted mb-4">Klik salah satu tombol di bawah untuk mengunduh data yang difilter.</p>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('export.pengajuan-solder') }}" class="btn btn-success w-100 solder-btn">
                        <i class="fas fa-file-excel"></i> Export Pengajuan Solder
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('export.pengajuan-chemical') }}" class="btn btn-success w-100 chemical-btn">
                        <i class="fas fa-file-excel"></i> Export Pengajuan Chemical
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('export.pengajuan-rawmat') }}" class="btn btn-success w-100 rawmat-btn">
                        <i class="fas fa-file-excel"></i> Export Pengajuan Rawmat
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>

<!-- Scripts -->
<script>
    function applyFilter() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        document.querySelectorAll('a.solder-btn, a.chemical-btn, a.rawmat-btn').forEach(function (btn) {
            const baseUrl = btn.href.split('?')[0];
            btn.href = `${baseUrl}?start_date=${startDate}&end_date=${endDate}`;
        });
    }
</script>
@endsection
