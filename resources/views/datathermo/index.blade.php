@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Thermohygrometer</li>
        </ol>
        <hr>
    </nav>
</div>

@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
    {{ Session::get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow mb-4">
<div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold">Data Thermohgyrometer</h6>
    <div class="d-flex align-items-center">
        <div class="dropdown me-2">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Filter Data
            </button>
            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                <li><a class="dropdown-item" href="{{ route('datathermo', ['filter' => 'all', 'page_size' => request('page_size', 10)]) }}">Semua Data</a></li>
                <li><a class="dropdown-item" href="{{ route('datathermo', ['filter' => 'this_month', 'page_size' => request('page_size', 10)]) }}">Data Bulan Ini</a></li>
                <li><a class="dropdown-item" href="{{ route('datathermo', ['filter' => 'today', 'page_size' => request('page_size', 10)]) }}">Data Hari Ini</a></li>
            </ul>
        </div>

        <div class="dropdown me-2">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="pageSizeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Tampilkan: {{ request('page_size', 10) }} Data
            </button>
            <ul class="dropdown-menu" aria-labelledby="pageSizeDropdown">
                <li><a class="dropdown-item" href="{{ route('datathermo', array_merge(request()->all(), ['page_size' => 10])) }}">10</a></li>
                <li><a class="dropdown-item" href="{{ route('datathermo', array_merge(request()->all(), ['page_size' => 20])) }}">20</a></li>
                <li><a class="dropdown-item" href="{{ route('datathermo', array_merge(request()->all(), ['page_size' => 50])) }}">50</a></li>
                <li><a class="dropdown-item" href="{{ route('datathermo', array_merge(request()->all(), ['page_size' => 100])) }}">100</a></li>
            </ul>
        </div>

        <a href="{{ route('datathermo.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>
</div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th style="width: 20%;">Tanggal</th>
                        <th style="width: 25%;">Waktu</th>
                        <th style="width: 30%;">Nama</th>
                        <th style="width: 20%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datathermo as $thermo)
                    <tr>
                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($thermo->tgl)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                        <td>{{ \Carbon\Carbon::parse($thermo->waktu)->format('H:i') }}</td>
                        <td>{{ $thermo->user->name }}</td>
                        <td>
                            <a href="{{ route('datathermo.show', $thermo->id) }}" class="btn btn-info btn-sm">Detail</a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
