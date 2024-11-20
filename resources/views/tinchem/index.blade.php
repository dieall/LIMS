@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data tinchem</li>
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
        <span>Data tinchem</span>
        <a href="{{ route('tinchem.create') }}" class="btn btn-success btn-sm">Tambah</a>
    </div>

    <div class="card-body">
        <!-- Filter Dropdown -->
        <div class="mb-3" style="width: 250px;">
            <label for="tinchemFilter" class="sr-only">Filter by ID</label>
            <select class="form-control form-control-sm" id="tinchemFilter">
                <option value="all">Show All</option>
                <option value="tinchem-98">tinchem-98</option>
                <option value="tinchemDCL-515">tinchemDCL-515</option>
                <option value="tinchemDCL-510">tinchemDCL-510</option>
            </select>
        </div>

        <!-- Table for Data tinchem -->
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
                    @if($tinchem->count() > 0)
                        @foreach($tinchem as $rs)
                            <tr class="tinchem-row" data-id="{{ $rs->id }}">
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $rs->id }}</td>
                                <td class="align-middle">{{ $rs->tgl }}</td>
                                <td class="align-middle">{{ $rs->category->nama_kategori ?? 'Kategori Tidak Ada' }}</td>
                                <td class="align-middle">{{ $rs->transaksi->tipe_sampel ?? 'Tipe Sampel Tidak Ada' }}</td>
                                <td class="align-middle">{{ $rs->transaksi->nama ?? 'Nama Tidak Ada' }}</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <a href="{{ route('tinchem.show', $rs->idx) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('tinchem.edit', $rs->idx) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('tinchem.destroy', $rs->idx) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
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
                            <td class="text-center" colspan="7">Data tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pie Chart -->


    </div>
</div>

@endsection


