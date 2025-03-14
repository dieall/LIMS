@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Chemical</li>
        </ol>
        <hr>
    </nav>
</div>

<!-- Success Alert -->
@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
    {{ Session::get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Main Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Data Chemical</h6>
        <div class="d-flex gap-3 align-items-center">
            <!-- Filter Options -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Filter Data
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="{{ route('datachemical.index', ['filter' => 'all']) }}">Semua Data</a></li>
                    <li><a class="dropdown-item" href="{{ route('datachemical.index', ['filter' => 'today']) }}">Data Hari Ini</a></li>
                </ul>
            </div>

            <!-- Dropdown for Page Size -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="pageSizeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Tampilkan: {{ request('page_size', 10) }} Data
                </button>
                <ul class="dropdown-menu" aria-labelledby="pageSizeDropdown">
                    <li><a class="dropdown-item" href="{{ route('datachemical.index', array_merge(request()->all(), ['page_size' => 10])) }}">10</a></li>
                    <li><a class="dropdown-item" href="{{ route('datachemical.index', array_merge(request()->all(), ['page_size' => 20])) }}">20</a></li>
                    <li><a class="dropdown-item" href="{{ route('datachemical.index', array_merge(request()->all(), ['page_size' => 30])) }}">30</a></li>
                </ul>
            </div>

            <!-- Button Tambah -->
            <a href="{{ route('datachemical.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light text-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama Category</th>
                        <th>Nama Sampel</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Nama</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($datachemical->count() > 0)
                        @foreach($datachemical as $index => $rs)
                            <tr>
                                <td class="text-center align-middle">{{ $index + 1 + (($datachemical->currentPage() - 1) * $datachemical->perPage()) }}</td>
                                <td class="align-middle">{{ $rs->kategori }}</td>
                                <td class="align-middle">{{ $rs->nama }}</td>
                                <td class="align-middle">{{ $rs->tgl }}</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($rs->created_at)->format('H:i:s') }}</td>
                                <td class="align-middle">{{ $rs->orang }}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('datachemical.show', $rs->id) }}" class="dropdown-item"><i class="fas fa-eye"></i> Detail</a></li>
                                            <li><a href="{{ route('datachemical.edit', $rs->id) }}" class="dropdown-item"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                            <li>
                                                <form action="{{ route('datachemical.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="7">Data tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination -->
        <div class="pagination-container">
            <a href="{{ $datachemical->previousPageUrl() }}" class="pagination-link {{ $datachemical->onFirstPage() ? 'disabled' : '' }}">&laquo;</a>
            @for($i = 1; $i <= $datachemical->lastPage(); $i++)
                <a href="{{ $datachemical->url($i) }}" class="pagination-link {{ $datachemical->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
            @endfor
            <a href="{{ $datachemical->nextPageUrl() }}" class="pagination-link {{ $datachemical->currentPage() == $datachemical->lastPage() ? 'disabled' : '' }}">&raquo;</a>
        </div>
    </div>
</div>

<style>
    .pagination-container {
        text-align: center;
        margin-top: 20px;
    }

    .pagination-link {
        display: inline-block;
        padding: 8px 12px;
        margin: 0 5px;
        text-decoration: none;
        color: #007bff;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .pagination-link:hover {
        background-color: #f1f1f1;
    }

    .pagination-link.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination-link.disabled {
        color: #ccc;
        pointer-events: none;
    }
</style>
@endsection
