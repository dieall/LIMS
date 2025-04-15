@extends('layouts.app')

@section('contents')
<style>
    /* Alert styling */
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

    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    /* Enhanced pagination */
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
        text-decoration: none;
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
    
    /* Table enhancements */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .table th {
        background-color: #f8f9fa;
    }
    
    /* Button and dropdown styling */
    .btn-group + .btn-group {
        margin-left: 5px;
    }
    
    .dropdown-menu {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .btn i {
        margin-right: 5px;
    }
    
    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .d-flex {
            margin-top: 10px;
            width: 100%;
        }
        
        .dropdown, .btn {
            margin-bottom: 5px;
        }
    }
</style>

<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Kondisi Instrument</li>
        </ol>
        <hr>
    </nav>
</div>

<!-- Alert Messages -->
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

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-tools me-2"></i> Data Kondisi Instrument
        </h6>
        <div class="d-flex gap-2">
            <!-- Dropdown Filter Data -->
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter"></i> Filter Data
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="{{ route('instruments', ['filter' => 'all', 'page_size' => request('page_size', 10)]) }}">Semua Data</a></li>
                    <li><a class="dropdown-item" href="{{ route('instruments', ['filter' => 'this_month', 'page_size' => request('page_size', 10)]) }}">Data Bulan Ini</a></li>
                    <li><a class="dropdown-item" href="{{ route('instruments', ['filter' => 'today', 'page_size' => request('page_size', 10)]) }}">Data Hari Ini</a></li>
                </ul>
            </div>

            <!-- Dropdown Page Size -->
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="pageSizeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-list-ol"></i> {{ request('page_size', 10) }} Data
                </button>
                <ul class="dropdown-menu" aria-labelledby="pageSizeDropdown">
                    <li><a class="dropdown-item" href="{{ route('instruments', array_merge(request()->except(['page']), ['page_size' => 10])) }}">10</a></li>
                    <li><a class="dropdown-item" href="{{ route('instruments', array_merge(request()->except(['page']), ['page_size' => 20])) }}">20</a></li>
                    <li><a class="dropdown-item" href="{{ route('instruments', array_merge(request()->except(['page']), ['page_size' => 50])) }}">50</a></li>
                    <li><a class="dropdown-item" href="{{ route('instruments', array_merge(request()->except(['page']), ['page_size' => 100])) }}">100</a></li>
                </ul>
            </div>

            <!-- Button Tambah -->
            <a href="{{ route('instrument.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
    </div>

    <div class="card-body">
        @if($instruments->isEmpty())
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i> Tidak ada data kondisi instrument yang tersedia.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="20%">Shift</th>
                            <th width="20%">Jam</th>
                            <th width="30%">Tanggal</th>    
                            <th width="25%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($instruments as $instrument)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">
                                    <span class="badge {{ $instrument->shift == 'Pagi' ? 'bg-primary' : ($instrument->shift == 'Siang' ? 'bg-warning text-dark' : 'bg-dark') }}">
                                        <i class="fas {{ $instrument->shift == 'Pagi' ? 'fa-sun' : ($instrument->shift == 'Siang' ? 'fa-cloud-sun' : 'fa-moon') }}"></i>
                                        {{ $instrument->shift }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <i class="fas fa-clock text-secondary me-1"></i>
                                    {{ \Carbon\Carbon::parse($instrument->jam)->format('H:i') }}
                                </td>
                                <td class="align-middle">
                                    <i class="fas fa-calendar-day text-secondary me-1"></i>
                                    {{ \Carbon\Carbon::parse($instrument->tgl)->locale('id')->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group">
                                        <a href="{{ route('instrument.show', $instrument->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </a>
                                        
                                        @if(Auth::user()->level === 'Admin' || Auth::user()->id === $instrument->user_id)
                                            <a href="{{ route('instrument.edit', $instrument->id) }}" class="btn btn-warning btn-sm mx-1">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            
                                            <form action="{{ route('instrument.destroy', $instrument->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Enhanced Pagination -->
            <div class="custom-pagination">
                @if ($instruments->currentPage() > 1)
                    <a href="{{ $instruments->appends(request()->except('page'))->previousPageUrl() }}" class="page-link">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                @else
                    <span class="page-link disabled">
                        <i class="fas fa-chevron-left"></i> Previous
                    </span>
                @endif

                @php
                    $startPage = max($instruments->currentPage() - 2, 1);
                    $endPage = min($startPage + 4, $instruments->lastPage());
                    $startPage = max(min($endPage - 4, $startPage), 1);
                @endphp

                @if($startPage > 1)
                    <a href="{{ $instruments->appends(request()->except('page'))->url(1) }}" class="page-link">1</a>
                    @if($startPage > 2)
                        <span class="page-link disabled">...</span>
                    @endif
                @endif

                @for ($i = $startPage; $i <= $endPage; $i++)
                    <a href="{{ $instruments->appends(request()->except('page'))->url($i) }}" 
                        class="page-link {{ $instruments->currentPage() == $i ? 'active' : '' }}">
                        {{ $i }}
                    </a>
                @endfor

                @if($endPage < $instruments->lastPage())
                    @if($endPage < $instruments->lastPage() - 1)
                        <span class="page-link disabled">...</span>
                    @endif
                    <a href="{{ $instruments->appends(request()->except('page'))->url($instruments->lastPage()) }}" 
                        class="page-link">{{ $instruments->lastPage() }}</a>
                @endif

                @if ($instruments->currentPage() < $instruments->lastPage())
                    <a href="{{ $instruments->appends(request()->except('page'))->nextPageUrl() }}" class="page-link">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="page-link disabled">
                        Next <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
            
            <div class="text-center mt-2 text-muted">
                <small>Showing {{ $instruments->firstItem() ?? 0 }} to {{ $instruments->lastItem() ?? 0 }} of {{ $instruments->total() }} entries</small>
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
