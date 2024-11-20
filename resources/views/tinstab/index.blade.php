@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Solar</li>
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
        <h6 class="m-0 font-weight-bold">
            Data Tinstab
        </h6>
        <div class="d-flex align-items-center">
            <!-- Filter Dropdown -->
            <div class="mr-3 mb-0" style="width: 250px;">
                <label for="tinstabFilter" class="sr-only">Filter by ID</label>
                <select class="form-control form-control-sm" id="tinstabFilter">
                    <option value="all" {{ $selectedTable === 'all' ? 'selected' : '' }}>Show All</option>
                    <option value="MT-620" {{ $selectedTable === 'MT-620' ? 'selected' : '' }}>MT-620</option>
                    <option value="MT-630" {{ $selectedTable === 'MT-630' ? 'selected' : '' }}>MT-630</option>
                </select>

            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode BQR</th>
                        <th>Tanggal</th>
                        <th>Category</th>
                        <th>Tipe Sampel</th>
                        <th>Nama</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($tinstab->count() > 0)
                        @foreach($tinstab as $rs)
                        
                            <tr class="tinstab-row" data-id="{{ $rs->id }}">
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $rs->id }}</td>
                                <td class="align-middle">{{ $rs->tgl }}</td>
                                <td class="align-middle">{{ $rs->category->nama_kategori ?? 'Kategori Tidak Ada' }}</td>
                                <td class="align-middle">{{ $rs->transaksi->tipe_sampel ?? 'Tipe Sampel Tidak Ada' }}</td>
                                <td class="align-middle">{{ $rs->transaksi->nama ?? 'Nama Tidak Ada' }}</td>

                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('tinstab.show', $rs->idx) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('tinstab.edit', $rs->idx) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('tinstab.destroy', $rs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="15">Data tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>



<script>
    // Filter logic for the table
    document.getElementById('tinstabFilter').addEventListener('change', function() {
        const filterValue = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('table', filterValue);
        window.location.href = url; // Redirect to the updated URL
    });
</script>

@endsection
