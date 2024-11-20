
@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data DMT</li>
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
        <span>Data DMT</span>
        <div class="d-flex align-items-center">
            <!-- Filter Dropdown -->
            <div class="mr-3 mb-0" style="width: 250px;">
                <label for="dmtFilter" class="sr-only">Filter by ID</label>
                <select class="form-control form-control-sm" id="dmtFilter">
                    <option value="all">Show All</option>
                    <option value="DMT-98">DMT-98</option>
                    <option value="DMTDCL-515">DMTDCL-515</option>
                    <option value="DMTDCL-510">DMTDCL-510</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card-body">
        <!-- Table for Data DMT -->
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode BQR</th>
                        <th>Tanggal</th>
                        <th>Category</th>
                        <th>Tipe Sampel</th>
                        <th>Jam Pengajuan</th>
                        <th>Nama</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($dmt->count() > 0)
                        @foreach($dmt as $rs)
                            <tr class="dmt-row" data-id="{{ $rs->id }}">
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $rs->id }}</td>
                                <td class="align-middle">{{ $rs->tgl }}</td>
                                <td class="align-middle">{{ $rs->category->nama_kategori ?? 'Kategori Tidak Ada' }}</td>
                                <td class="align-middle">{{ $rs->transaksi->tipe_sampel ?? 'Tipe Sampel Tidak Ada' }}</td>
                                <td class="align-middle">{{ $rs->transaksi->jam_masuk ?? 'Tipe Sampel Tidak Ada' }}</td>
                                <td class="align-middle">{{ $rs->transaksi->nama ?? 'Nama Tidak Ada' }}</td>
                                <td class="align-middle">
                                <div class="btn-group">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-cogs"></i> Actions
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('dmt.create', $rs->id) }}" class="dropdown-item">
                <i class="fas fa-plus-circle"></i> Add
            </a>
        </li>
        <li>
            <a href="{{ route('dmt.show', $rs->idx) }}" class="dropdown-item">
                <i class="fas fa-info-circle"></i> Detail
            </a>
        </li>
        <li>
            <button type="button" class="dropdown-item btn-edit" data-id="{{ $rs->id }}" data-bs-toggle="modal" data-bs-target="#floatingFormModal">
                <i class="fas fa-edit"></i> Edit
            </button>
        </li>
        <li>
            <form action="{{ route('transaksi.destroy', $rs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item text-danger">
                    <i class="fas fa-trash-alt"></i> Delete
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
                            <td class="text-center" colspan="7">Data tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Filter logic
    document.getElementById('dmtFilter').addEventListener('change', function() {
        const filterId = this.value;
        console.log('Filter ID:', filterId); // Debugging line
        document.querySelectorAll('.dmt-row').forEach(function(row) {
            if (filterId === 'all' || row.getAttribute('data-id') === filterId) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>


@endsection
