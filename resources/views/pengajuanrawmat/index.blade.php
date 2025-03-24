@extends('layouts.app')

@section('contents')
<style>
    /* Styling untuk alert */
    .alert {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        font-weight: bold;
        transition: opacity 1s ease-out; /* Efek transisi saat hilang */
    }

    .alert-success {
        background-color: #d4edda; /* Warna latar belakang hijau */
        color: #155724; /* Warna teks hijau gelap */
        border: 1px solid #c3e6cb; /* Border hijau muda */
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

    .card-body {
        position: relative;
        overflow: hidden;
    }

    .dropdown-menu a {
        font-size: 14px;
    }
</style>

<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Sampel Raw Materiall</li>
        </ol>
        <hr>
    </nav>
</div>

<!-- Alert Section -->
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Main Card -->
<div class="card shadow mb-4">
<div class="card-header py-2 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold">Data Sampel Raw Material</h6>
    <div class="d-flex gap-2">
        <!-- Dropdown Filter Data -->
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Filter Data
            </button>
            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', ['filter' => 'all']) }}">Semua Data</a></li>
                <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', ['filter' => 'this_month']) }}">Data Bulan Ini</a></li>
                <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', ['filter' => 'today']) }}">Data Hari Ini</a></li>
            </ul>
        </div>

        <!-- Dropdown for Page Size -->
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="pageSizeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Tampilkan: {{ request('page_size', 10) }} Data
            </button>
            <ul class="dropdown-menu" aria-labelledby="pageSizeDropdown">
                <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', array_merge(request()->all(), ['page_size' => 10])) }}">10</a></li>
                <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', array_merge(request()->all(), ['page_size' => 20])) }}">20</a></li>
                <li><a class="dropdown-item" href="{{ route('pengajuanrawmat.index', array_merge(request()->all(), ['page_size' => 30])) }}">30</a></li>
            </ul>
        </div>

        <!-- Button Tambah -->
        <a href="{{ route('pengajuanrawmat.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> Tambah
        </a>

    </div>
</div>


    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light text-dark">
                    <tr>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th>Nama Rawmat</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th class="text-center" style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($pengajuanrawmat->count() > 0)
                        @foreach($pengajuanrawmat as $rs)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $rs->nama }}</td>
                                <td class="align-middle">{{ $rs->tgl }}</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($rs->created_at)->format('H:i:s') }}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('pengajuanrawmat.show', $rs->id) }}" class="dropdown-item"><i class="fas fa-info-circle"></i> Detail</a></li>
                                            <li>
                                                <a href="{{ route('pengajuanrawmat.print', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                            </li>
                                            <li><a href="{{ route('pengajuanrawmat.edit', $rs->id) }}" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a></li>
                                            <li>
                                                <form action="{{ route('pengajuanrawmat.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data pengajuan raw material yang tersedia.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination -->
        <div class="custom-pagination">
            @if ($pengajuanrawmat->currentPage() > 1)
                <a href="{{ $pengajuanrawmat->previousPageUrl() }}" class="page-link">« Previous</a>
            @endif

            @for ($i = 1; $i <= $pengajuanrawmat->lastPage(); $i++)
                <a href="{{ $pengajuanrawmat->url($i) }}" class="page-link {{ $pengajuanrawmat->currentPage() == $i ? 'active' : '' }}">
                    {{ $i }}
                </a>
            @endfor

            @if ($pengajuanrawmat->currentPage() < $pengajuanrawmat->lastPage())
                <a href="{{ $pengajuanrawmat->nextPageUrl() }}" class="page-link">Next »</a>
            @endif
        </div>
    </div>
</div>
@endsection
