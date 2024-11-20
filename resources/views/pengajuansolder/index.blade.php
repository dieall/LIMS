@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Pengajuan Solder</li>
        </ol>
        <hr>
    </nav>
</div>

@if(Session::has('success'))
    <div class="alert alert-s   uccess" role="alert" id="success-alert">
        {{ Session::get('success') }}
    </div>
@endif

<div class="card shadow mb-4">
<div class="card-header py-2">
    Data Pengajuan Solder
    
    <hr>
    <div class="d-flex justify-content-between align-items-center mb-1">
    <a href="{{ route('pengajuansolder.create') }}" class="btn btn-success btn-sm">Tambah</a>
    <a href="" class="btn btn-success btn-sm">Export to Excel</a>
    </div>
</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="auto" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Category</th>
                        <th>Tipe Sampel</th>
                        <th>Batch</th>
                        <th>Jam Pengajuan</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($pengajuansolder->count() > 0)
                        @foreach($pengajuansolder as $rs)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle text-category">{{ $rs->categorysolder->nama_kategori }}</td>
                                <td class="align-middle text-tipe-sampel">{{ $rs->tipe_solder }}</td>
                                <td class="align-middle">{{ $rs->batch }}</td>
                                <td class="align-middle">{{ $rs->jam_masuk }}</td>
                                <td class="align-middle">{{ $rs->nama }}</td>
                                <td class="align-middle">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('pengajuansolder.show', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-info-circle"></i> Detail
                                                </a>
                                            </li>


                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <!-- Tombol Edit -->
                                            <li>
                                                <a href="{{ route('pengajuansolder.edit', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </li>

                                            <!-- Separator -->
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>

                                            <!-- Tombol Delete -->
                                            <li>
                                                <form action="{{ route('pengajuansolder.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                    @endif
                    </tbody>
            </table>
        </div>
    </div>
</div>

@endsection