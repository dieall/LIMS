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

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card shadow mb-4">
<div class="card-header py-2">
    Data Pengajuan Solder
    
    <hr>
    <div class="d-flex justify-content-between align-items-center mb-1">
    <a href="{{ route('rtinchemical.create') }}" class="btn btn-success btn-sm">Tambah</a>
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
                        <th>Tipe Rawmat</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($rtinchemical->count() > 0)
                        @foreach($rtinchemical as $rs)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle text-category">{{ $rs->nama_kategori }}</td>
                                <td class="align-middle text-tipe-sampel">{{ $rs->tipe_rawmat }}</td>
                                <td class="align-middle">{{ $rs->nama }}</td>

  
                                <td class="align-middle">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <!-- Tombol Detail -->
                                            <li>
                                                <a href="{{ route('rtinchemical.show', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-info-circle"></i> Detail
                                                </a>
                                            </li>

                                            <!-- Tombol Edit -->
                                            <li>
                                                <a href="{{ route('rtinchemical.edit', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </li>

                                            <!-- Tombol Delete -->
                                            <li>
                                                <form action="{{ route('rtinchemical.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display: inline;">
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