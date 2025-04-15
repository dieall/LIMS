@extends('layouts.app')

@section('contents')
<style>
    /* Card styling */
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
    }
    
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        padding: 1rem 1.25rem;
    }
    
    /* Table styling */
    .table-detail th {
        background-color: #f8f9fc;
        vertical-align: middle;
    }
    
    .table-detail td {
        vertical-align: middle;
    }
    
    /* Section styling */
    .section-header {
        border-bottom: 1px solid #e3e6f0;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
    }
    
    /* Info box styling */
    .info-box {
        background-color: #f8f9fc;
        border-radius: 0.35rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .info-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #4e73df;
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        font-size: 1.1rem;
        font-weight: 500;
    }
    
    /* Button styling */
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
    }
    
    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .info-row {
            flex-direction: column;
        }
        
        .info-col {
            width: 100%;
            margin-bottom: 1rem;
        }
    }
    
    /* Result status indicators */
    .status-passed {
        color: #1cc88a;
        font-weight: 600;
    }
    
    .status-failed {
        color: #e74a3b;
        font-weight: 600;
    }
    
    /* Print-friendly styles */
    @media print {
        .breadcrumb, .btn-action {
            display: none;
        }
        
        .card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
        
        body {
            padding: 1cm;
        }
    }
</style>

<div class="panel-body mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home me-1"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengajuanrawmat.index') }}"><i class="fas fa-boxes me-1"></i> Pengajuan Raw Material</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-file-alt me-1"></i> Detail Pengajuan</li>
        </ol>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-info-circle me-2"></i> Detail Pengajuan Raw Material
        </h6>
        <div>
            <a href="{{ route('pengajuanrawmat.print', $pengajuanrawmat->id) }}" class="btn btn-sm btn-outline-primary btn-action" target="_blank">
                <i class="fas fa-print"></i> Print
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Summary information section -->
        <div class="row mb-4 info-row">
            <div class="col-md-4 mb-3 info-col">
                <div class="info-box">
                    <div class="info-title"><i class="fas fa-tag me-1"></i> Nama Raw Material</div>
                    <div class="info-value">{{ $pengajuanrawmat->nama }}</div>
                </div>
            </div>
            <div class="col-md-4 mb-3 info-col">
                <div class="info-box">
                    <div class="info-title"><i class="fas fa-building me-1"></i> Supplier</div>
                    <div class="info-value">{{ $pengajuanrawmat->supplier }}</div>
                </div>
            </div>
            <div class="col-md-4 mb-3 info-col">
                <div class="info-box">
                    <div class="info-title"><i class="fas fa-calendar-alt me-1"></i> Tanggal</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($pengajuanrawmat->tgl)->format('d F Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Details table section -->
        <h6 class="text-primary font-weight-bold section-header">
            <i class="fas fa-clipboard-list me-2"></i> Detail Spesifikasi & Hasil
        </h6>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-detail">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th style="width: 30%;">Spesifikasi</th>
                        <th style="width: 15%;">Satuan</th>
                        <th style="width: 25%;">COA</th>
                        <th style="width: 25%;">Result</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        try {
                            $spesifikasi = json_decode($pengajuanrawmat['spesifikasi'], true) ?? [];
                            $satuan = json_decode($pengajuanrawmat['satuan'], true) ?? [];
                            $coa = json_decode($pengajuanrawmat['coa'], true) ?? [];
                            $result = json_decode($pengajuanrawmat['result'], true) ?? [];
                            
                            // Find maximum row length
                            $maxLength = max(count($spesifikasi), count($satuan), count($coa), count($result));
                        } catch (\Exception $e) {
                            $spesifikasi = $satuan = $coa = $result = [];
                            $maxLength = 0;
                        }
                    @endphp

                    @if($maxLength > 0)
                        @for ($i = 0; $i < $maxLength; $i++)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $spesifikasi[$i] ?? '-' }}</td>
                                <td>{{ $satuan[$i] ?? '-' }}</td>
                                <td>{{ $coa[$i] ?? '-' }}</td>
                                <td>
                                    @php
                                        $resultValue = $result[$i] ?? '-';
                                        $coaValue = $coa[$i] ?? '-';
                                        $passed = !empty($resultValue) && !empty($coaValue) && 
                                                  (strtolower($resultValue) == strtolower($coaValue) || 
                                                   strpos(strtolower($coaValue), strtolower($resultValue)) !== false);
                                    @endphp
                                    <span class="{{ $passed ? 'status-passed' : 'status-failed' }}">
                                        {{ $resultValue }}
                                        @if($passed)
                                            <i class="fas fa-check-circle ms-1"></i>
                                        @else
                                            <i class="fas fa-times-circle ms-1"></i>
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @endfor
                    @else
                        <tr>
                            <td colspan="5" class="text-center py-3">
                                <i class="fas fa-exclamation-circle text-warning me-1"></i>
                                Tidak ada data detail yang tersedia
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Meta information section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="alert alert-light">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i> Dibuat: {{ $pengajuanrawmat->created_at->format('d F Y H:i') }}
                        @if($pengajuanrawmat->created_at != $pengajuanrawmat->updated_at)
                            <span class="mx-2">|</span>
                            <i class="fas fa-edit me-1"></i> Diperbarui: {{ $pengajuanrawmat->updated_at->format('d F Y H:i') }}
                        @endif
                    </small>
                </div>
            </div>
        </div>
        
        <!-- Action buttons -->
        <div class="d-flex mt-3 gap-2">
            <a href="{{ route('pengajuanrawmat.index') }}" class="btn btn-secondary btn-action">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('pengajuanrawmat.edit', $pengajuanrawmat->id) }}" class="btn btn-primary btn-action">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Print functionality
        document.querySelectorAll('.btn-print').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                window.print();
            });
        });
    });
</script>
@endsection
