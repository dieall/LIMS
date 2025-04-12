@extends('layouts.app')

@section('contents')
<style>
    /* Styling Alert */
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

    #success-alert {
        opacity: 1;
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
</style>
<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Kondisi Instrument</li>
        </ol>
        <hr>
    </nav>
</div>

@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

<div class="card shadow mb-4">
<div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold">Data Kondisi Instrument</h6>
    <div class="d-flex align-items-center">
        <div class="dropdown me-2">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Filter Data
            </button>
            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                <li><a class="dropdown-item" href="{{ route('instruments', ['filter' => 'all', 'page_size' => request('page_size', 10)]) }}">Semua Data</a></li>
                <li><a class="dropdown-item" href="{{ route('instruments', ['filter' => 'this_month', 'page_size' => request('page_size', 10)]) }}">Data Bulan Ini</a></li>
                <li><a class="dropdown-item" href="{{ route('instruments', ['filter' => 'today', 'page_size' => request('page_size', 10)]) }}">Data Hari Ini</a></li>
            </ul>
        </div>

        <div class="dropdown me-2">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="pageSizeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Tampilkan: {{ request('page_size', 10) }} Data
            </button>
            <ul class="dropdown-menu" aria-labelledby="pageSizeDropdown">
                <li><a class="dropdown-item" href="{{ route('instruments', array_merge(request()->all(), ['page_size' => 10])) }}">10</a></li>
                <li><a class="dropdown-item" href="{{ route('instruments', array_merge(request()->all(), ['page_size' => 20])) }}">20</a></li>
                <li><a class="dropdown-item" href="{{ route('instruments', array_merge(request()->all(), ['page_size' => 50])) }}">50</a></li>
                <li><a class="dropdown-item" href="{{ route('instruments', array_merge(request()->all(), ['page_size' => 100])) }}">100</a></li>
            </ul>
        </div>

        <a href="{{ route('instrument.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>
</div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-light text-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th style="width: 20%;">Shift</th>
                        <th style="width: 20%;">Jam</th>
                        <th style="width: 30%;">Tanggal</th>    
                        <th style="width: 20%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instruments as $instrument)
                        <tr>
                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                            <td>{{ $instrument->shift }}</td>
                            <td>{{ \Carbon\Carbon::parse($instrument->jam)->format('H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($instrument->tgl)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                            <td>
                                <a href="{{ route('instrument.show', $instrument->id) }}" class="btn btn-info">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="custom-pagination">
            @if ($instruments->currentPage() > 1)
                <a href="{{ $instruments->previousPageUrl() }}" class="page-link">« Previous</a>
            @endif

            @for ($i = 1; $i <= $instruments->lastPage(); $i++)
                <a href="{{ $instruments->url($i) }}" class="page-link {{ $instruments->currentPage() == $i ? 'active' : '' }}">
                    {{ $i }}
                </a>
            @endfor

            @if ($instruments->currentPage() < $instruments->lastPage())
                <a href="{{ $instruments->nextPageUrl() }}" class="page-link">Next »</a>
            @endif
        </div>
    </div>
</div> <!-- <div class="card shadow mb-4"> sudah ditutup di sini -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
