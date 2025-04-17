@extends('layouts.app')

@section('contents')
<style>
    /* Alert styling */
    .alert {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        font-weight: bold;
        transition: opacity 1s ease-out;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* Enhanced pagination styling */
    .custom-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        gap: 8px;
    }

    .page-link {
        display: inline-block;
        padding: 8px 12px;
        color: #007bff;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .page-link:hover {
        background-color: #f1f1f1;
        color: #0056b3;
    }

    .page-link.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .page-link.disabled {
        color: #6c757d;
        pointer-events: none;
    }
    
    /* Badge styling */
    .badge {
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    
    /* Button spacing */
    .btn-group + .btn-group {
        margin-left: 5px;
    }
    
    /* Table hover effect */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    /* Dropdown menu enhancement */
    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
    }
    
    .dropdown-item i {
        margin-right: 0.5rem;
        width: 16px;
        text-align: center;
    }
    
    /* Divider for dropdown */
    .dropdown-divider {
        margin: 0.5rem 0;
    }
</style>
<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Sampel Chemical</li>
        </ol>
        <hr>
    </nav>
</div>

<!-- Alert Section -->
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" id="success-alert" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ Session::get('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Card Wrapper -->
<div class="card shadow mb-4">
    <div class="card-header py-2 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-vial me-2"></i> Data Sampel Chemical
        </h6>
        <div class="d-flex gap-2">
            <!-- Dropdown Filter Data -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter me-1"></i> Filter Data
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', ['filter' => 'all']) }}">Semua Data</a></li>
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', ['filter' => 'this_month']) }}">Data Bulan Ini</a></li>
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', ['filter' => 'today']) }}">Data Hari Ini</a></li>
                </ul>
            </div>

            <!-- Dropdown Page Size -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="pageSizeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-list-ol me-1"></i> {{ request('page_size', 10) }} Data
                </button>
                <ul class="dropdown-menu" aria-labelledby="pageSizeDropdown">
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', array_merge(request()->except(['page']), ['page_size' => 10])) }}">10</a></li>
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', array_merge(request()->except(['page']), ['page_size' => 20])) }}">20</a></li>
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', array_merge(request()->except(['page']), ['page_size' => 50])) }}">50</a></li>
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', array_merge(request()->except(['page']), ['page_size' => 100])) }}">100</a></li>
                </ul>
            </div>

            <!-- Button Tambah -->
            <a href="{{ route('pengajuanrawmat.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah
            </a>
            <a href="" class="btn btn-primary btn-sm">
                <i class="fas fa-file-excel me-1"></i> Export Excel
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="15%">Category</th>
                        <th width="20%">Nama Sampel</th>
                        <th width="10%">Batch</th>
                        <th width="10%">Jam Pengajuan</th>
                        <th width="15%">Nama</th>
                        <th class="text-center" width="10%">Status</th>
                        <th class="text-center" width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuanrawmat as $rs)
                        <tr>
                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $rs->nama_rawmat }}</td>
                            <td class="align-middle">{{ $rs->nama }}</td>
                            <td class="align-middle">{{ $rs->batch }}</td>
                            <td class="align-middle">{{ \Carbon\Carbon::parse($rs->jam_masuk)->format('H:i') }}</td>
                            <td class="align-middle">{{ $rs->user->name }}</td>
                            <td class="align-middle text-center">
                                @php
                                    $statusClass = [
                                        'Pengajuan' => 'primary',
                                        'Proses Analisa' => 'info',
                                        'Selesai Analisa' => 'secondary',
                                        'Review Hasil' => 'warning',
                                        'Approve' => 'success'
                                    ][$rs->status] ?? 'secondary';
                                    
                                    $statusIcon = [
                                        'Pengajuan' => 'file-alt',
                                        'Proses Analisa' => 'sync',
                                        'Selesai Analisa' => 'check',
                                        'Review Hasil' => 'eye',
                                        'Approve' => 'thumbs-up'
                                    ][$rs->status] ?? 'question-circle';
                                @endphp
                                
                                <span class="badge bg-{{ $statusClass }}">
                                    <i class="fas fa-{{ $statusIcon }} me-1"></i> {{ $rs->status }}
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-cogs"></i> Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <!-- Tombol Detail -->
                                        <li>
                                            <a href="{{ route('pengajuanrawmat.show', $rs->id) }}" class="dropdown-item">
                                                <i class="fas fa-info-circle fa-fw me-1"></i> Detail
                                            </a>
                                        </li>
                                        
                                        <!-- Tombol Print -->
                                        <li>
                                            <a href="{{ route('pengajuanrawmat.print', $rs->id) }}" class="dropdown-item">
                                                <i class="fas fa-print fa-fw me-1"></i> Print
                                            </a>
                                        </li>
                                        
                                        <!-- Tombol Edit -->
                                        <li>
                                            <a href="{{ route('pengajuanrawmat.edit', $rs->id) }}" class="dropdown-item">
                                                <i class="fas fa-edit fa-fw me-1"></i> Edit
                                            </a>
                                        </li>
                                        
                                        <!-- Dynamic action buttons based on user role and status -->
                                        @if (Auth::user()->level === 'Admin' || Auth::user()->level === 'Operator QC')                                 
                                            <li>
                                                <form action="{{ route('pengajuanrawmat.pengajuan', $rs->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-file-alt fa-fw me-1"></i> Pengajuan
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        
                                        <!-- Tombol untuk Proses Analisa -->
                                        @if ((Auth::user()->level === 'Operator Lab' || Auth::user()->level === 'Admin') && 
                                            (!$rs->statusHistory()->where('status', 'Proses Analisa')->exists()))
                                            <li>
                                                <form action="{{ route('pengajuanrawmat.proses-analisa', $rs->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-cogs fa-fw me-1"></i> Proses Analisa
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        <!-- Tombol untuk Lanjutkan Menganalisa - Only show if already in process -->
                                        @if ($rs->statusHistory()->where('status', 'Proses Analisa')->exists() && 
                                            $rs->status === 'Proses Analisa')
                                            <li>
                                                <a href="{{ route('pengajuanrawmat.createe', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-flask fa-fw me-1"></i> Lanjutkan Menganalisa
                                                </a>
                                            </li>
                                        @endif
                                        
                                        <!-- Tombol Analisa Selesai (Operator Lab atau Admin) -->
                                        @if (Auth::user()->level === 'Operator Lab' || Auth::user()->level === 'Admin')
                                            <li>
                                                <form action="{{ route('pengajuanrawmat.analisaSelesai', $rs->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-check-circle fa-fw me-1"></i> Analisa Selesai
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        
                                        <!-- Tombol Review Hasil (Foreman atau Admin) -->
                                        @if (Auth::user()->level === 'Foreman' || Auth::user()->level === 'Admin')
                                            <li>
                                                <form action="{{ route('pengajuanrawmat.reviewHasil', $rs->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-eye fa-fw me-1"></i> Review Hasil
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        
                                        <!-- Tombol Approve (Supervisor atau Admin) -->
                                        @if (Auth::user()->level === 'Supervisor' || Auth::user()->level === 'Admin')
                                            <li>
                                                <form action="{{ route('pengajuanrawmat.approve', $rs->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-thumbs-up fa-fw me-1"></i> Approve
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        
                                        <!-- Tombol Delete (Admin only) -->
                                        @if (Auth::user()->level === 'Admin') 
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('pengajuanrawmat.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-trash fa-fw me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>


                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-exclamation-circle fa-3x text-secondary mb-2"></i>
                                    <span>Tidak ada data tersedia.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Enhanced Pagination with Query Parameters -->
        @if($pengajuanrawmat->count() > 0)
            <div class="custom-pagination">
                @if ($pengajuanrawmat->currentPage() > 1)
                    <a href="{{ $pengajuanrawmat->appends(request()->except('page'))->previousPageUrl() }}" class="page-link">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                @else
                    <span class="page-link disabled">
                        <i class="fas fa-chevron-left"></i> Previous
                    </span>
                @endif

                @php
                    $startPage = max($pengajuanrawmat->currentPage() - 2, 1);
                    $endPage = min($startPage + 4, $pengajuanrawmat->lastPage());
                    $startPage = max(min($endPage - 4, $startPage), 1);
                @endphp

                @if($startPage > 1)
                    <a href="{{ $pengajuanrawmat->appends(request()->except('page'))->url(1) }}" class="page-link">1</a>
                    @if($startPage > 2)
                        <span class="page-link disabled">...</span>
                    @endif
                @endif

                @for ($i = $startPage; $i <= $endPage; $i++)
                    <a href="{{ $pengajuanrawmat->appends(request()->except('page'))->url($i) }}" 
                        class="page-link {{ $pengajuanrawmat->currentPage() == $i ? 'active' : '' }}">
                        {{ $i }}
                    </a>
                @endfor

                @if($endPage < $pengajuanrawmat->lastPage())
                    @if($endPage < $pengajuanrawmat->lastPage() - 1)
                        <span class="page-link disabled">...</span>
                    @endif
                    <a href="{{ $pengajuanrawmat->appends(request()->except('page'))->url($pengajuanrawmat->lastPage()) }}" 
                        class="page-link">{{ $pengajuanrawmat->lastPage() }}</a>
                @endif

                @if ($pengajuanrawmat->currentPage() < $pengajuanrawmat->lastPage())
                    <a href="{{ $pengajuanrawmat->appends(request()->except('page'))->nextPageUrl() }}" class="page-link">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="page-link disabled">
                        Next <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
            
            <div class="text-center mt-2 text-muted">
                <small>Showing {{ $pengajuanrawmat->firstItem() ?? 0 }} to {{ $pengajuanrawmat->lastItem() ?? 0 }} of {{ $pengajuanrawmat->total() }} entries</small>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alert after 3 seconds
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.opacity = '0';
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 1000);
            }, 3000);
        }
        
        // Initialize tooltips if Bootstrap 5 is used
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        }
    });
</script>
@endsection
