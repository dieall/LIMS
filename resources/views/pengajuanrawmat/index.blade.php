@extends('layouts.app')

@section('contents')
<style>
    /* Styling untuk alert */
    .alert {
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 5px;
        font-weight: 500;
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

    /* Styling untuk pagination */
    .custom-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        gap: 8px;
    }

    .custom-pagination .page-link {
        display: inline-block;
        padding: 8px 12px;
        color: #007bff;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .custom-pagination .page-link:hover {
        background-color: #f1f1f1;
        text-decoration: none;
    }

    .custom-pagination .active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .custom-pagination .disabled {
        color: #6c757d;
        pointer-events: none;
    }

    /* Styling untuk tabel */
    .table-responsive {
        margin-bottom: 20px;
    }
    
    .table th {
        background-color: #f8f9fa;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    /* Button and dropdown styling */
    .btn-group + .btn-group {
        margin-left: 5px;
    }
    
    .dropdown-menu {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        min-width: 10rem;
    }
    
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
    
    /* Empty state styling */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 2rem 0;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .d-flex.gap-2 {
            margin-top: 10px;
            width: 100%;
            justify-content: space-between;
        }
    }
</style>

<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Sampel Raw Material</li>
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

<!-- Main Card -->
<div class="card shadow mb-4">
    <div class="card-header py-2 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-boxes me-2"></i> Data Sampel Raw Material
        </h6>
        <div class="d-flex gap-2">
            <!-- Dropdown Filter Data -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter me-1"></i> Filter Data
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', ['filter' => 'all', 'page_size' => request('page_size', 10)]) }}">Semua Data</a></li>
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', ['filter' => 'this_month', 'page_size' => request('page_size', 10)]) }}">Data Bulan Ini</a></li>
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', ['filter' => 'today', 'page_size' => request('page_size', 10)]) }}">Data Hari Ini</a></li>
                </ul>
            </div>

            <!-- Dropdown for Page Size -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="pageSizeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-list-ol me-1"></i> {{ request('page_size', 10) }} Data
                </button>
                <ul class="dropdown-menu" aria-labelledby="pageSizeDropdown">
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', array_merge(request()->except('page'), ['page_size' => 10])) }}">10</a></li>
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', array_merge(request()->except('page'), ['page_size' => 20])) }}">20</a></li>
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', array_merge(request()->except('page'), ['page_size' => 50])) }}">50</a></li>
                    <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', array_merge(request()->except('page'), ['page_size' => 100])) }}">100</a></li>
                </ul>
            </div>

            <!-- Button Tambah -->
            <a href="{{ route('pengajuanrawmat.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th style="width: 35%;">Nama Raw Material</th>
                        <th style="width: 25%;">Tanggal</th>
                        <th style="width: 20%;">Jam Masuk</th>
                        <th class="text-center" style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($pengajuanrawmat->count() > 0)
                        @foreach($pengajuanrawmat as $rs)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $rs->nama }}</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($rs->tgl)->format('d F Y') }}</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($rs->created_at)->format('H:i:s') }}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs me-1"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="{{ route('pengajuanrawmat.show', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-info-circle"></i> Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('pengajuanrawmat.print', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('pengajuanrawmat.edit', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('pengajuanrawmat.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-box-open"></i>
                                    <p>Tidak ada data pengajuan raw material yang tersedia.</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Enhanced Pagination -->
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
        // Auto-hide success alert after 3 seconds
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.opacity = '0';
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 1000);
            }, 3000);
        }
    });
</script>
@endsection
