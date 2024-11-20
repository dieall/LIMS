@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data solar</li>
        </ol><hr>
    </nav>
</div>
<!-- Akhir Tambah Dan Print -->



@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data solar</h6>
        <a href="{{ route('solar.create') }}" class="btn btn-success btn-sm">Tambah</a>
    </div>


    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama solar</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($solar->count() > 0)
                        @foreach($solar as $rs)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $rs->id }}</td>
                                <td class="align-middle">{{ $rs->nama_solar }}</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic example">

                                        <a href="{{ route('solar.show', $rs->id) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('solar.edit', $rs->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('solar.destroy', $rs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
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
                            <td class="text-center" colspan="4">Product not found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
