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

    /* Pagination styling */
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
    
    /* Table enhancements */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
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
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-thermometer-half me-1"></i> Data Thermohygrometer</li>
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
            <i class="fas fa-thermometer-half me-2"></i> Data Thermohygrometer
        </h6>
        <div class="d-flex gap-2">
            <!-- Dropdown Filter Data -->
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter me-1"></i> Filter Data
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="{{ route('datathermo', ['filter' => 'all', 'page_size' => request('page_size', 10)]) }}">Semua Data</a></li>
                    <li><a class="dropdown-item" href="{{ route('datathermo', ['filter' => 'this_month', 'page_size' => request('page_size', 10)]) }}">Data Bulan Ini</a></li>
                    <li><a class="dropdown-item" href="{{ route('datathermo', ['filter' => 'today', 'page_size' => request('page_size', 10)]) }}">Data Hari Ini</a></li>
                </ul>
            </div>

            <!-- Dropdown Page Size -->
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="pageSizeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-list-ol me-1"></i> {{ request('page_size', 10) }} Data
                </button>
                <ul class="dropdown-menu" aria-labelledby="pageSizeDropdown">
                    <li><a class="dropdown-item" href="{{ route('datathermo', array_merge(request()->except(['page']), ['page_size' => 10])) }}">10</a></li>
                    <li><a class="dropdown-item" href="{{ route('datathermo', array_merge(request()->except(['page']), ['page_size' => 20])) }}">20</a></li>
                    <li><a class="dropdown-item" href="{{ route('datathermo', array_merge(request()->except(['page']), ['page_size' => 50])) }}">50</a></li>
                    <li><a class="dropdown-item" href="{{ route('datathermo', array_merge(request()->except(['page']), ['page_size' => 100])) }}">100</a></li>
                </ul>
            </div>

            <!-- Button Tambah -->
            <a href="{{ route('datathermo.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah
            </a>
        </div>
    </div>

    <div class="card-body">
        @if($datathermo->isEmpty())
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i> Tidak ada data thermohygrometer yang tersedia.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="20%">Tanggal</th>
                            <th width="15%">Waktu</th>
                            <th width="30%">Nama</th>
                            <th width="30%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datathermo as $thermo)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">
                                    <i class="fas fa-calendar-day text-secondary me-1"></i>
                                    {{ \Carbon\Carbon::parse($thermo->tgl)->locale('id')->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td class="align-middle">
                                    <i class="fas fa-clock text-secondary me-1"></i>
                                    {{ \Carbon\Carbon::parse($thermo->waktu)->format('H:i') }}
                                </td>
                                <td class="align-middle">
                                    <i class="fas fa-user text-secondary me-1"></i>
                                    {{ $thermo->nama }}
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group">
                                        <a href="{{ route('datathermo.show', $thermo->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-info-circle me-1"></i> Detail
                                        </a>
                                        
                                        @if(Auth::user()->level === 'Admin' || Auth::user()->id === $thermo->user_id)
                                            <a href="{{ route('datathermo.edit', $thermo->id) }}" class="btn btn-warning btn-sm mx-1">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            
                                            <form action="{{ route('datathermo.destroy', $thermo->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash me-1"></i> Hapus
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
            
            <!-- Pagination -->
            @if($datathermo instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="custom-pagination">
                    @if ($datathermo->currentPage() > 1)
                        <a href="{{ $datathermo->appends(request()->except('page'))->previousPageUrl() }}" class="page-link">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    @else
                        <span class="page-link disabled">
                            <i class="fas fa-chevron-left"></i> Previous
                        </span>
                    @endif

                    @php
                        $startPage = max($datathermo->currentPage() - 2, 1);
                        $endPage = min($startPage + 4, $datathermo->lastPage());
                        $startPage = max(min($endPage - 4, $startPage), 1);
                    @endphp

                    @if($startPage > 1)
                        <a href="{{ $datathermo->appends(request()->except('page'))->url(1) }}" class="page-link">1</a>
                        @if($startPage > 2)
                            <span class="page-link disabled">...</span>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <a href="{{ $datathermo->appends(request()->except('page'))->url($i) }}" 
                            class="page-link {{ $datathermo->currentPage() == $i ? 'active' : '' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    @if($endPage < $datathermo->lastPage())
                        @if($endPage < $datathermo->lastPage() - 1)
                            <span class="page-link disabled">...</span>
                        @endif
                        <a href="{{ $datathermo->appends(request()->except('page'))->url($datathermo->lastPage()) }}" 
                            class="page-link">{{ $datathermo->lastPage() }}</a>
                    @endif

                    @if ($datathermo->currentPage() < $datathermo->lastPage())
                        <a href="{{ $datathermo->appends(request()->except('page'))->nextPageUrl() }}" class="page-link">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="page-link disabled">
                            Next <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
                
                <div class="text-center mt-2 text-muted">
                    <small>Showing {{ $datathermo->firstItem() ?? 0 }} to {{ $datathermo->lastItem() ?? 0 }} of {{ $datathermo->total() }} entries</small>
                </div>
            @endif
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
