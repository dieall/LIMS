@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data trial</li>
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
        <h6 class="m-0 font-weight-bold text-primary">Data trial</h6>
        <a href="{{ route('trial.create') }}" class="btn btn-success btn-sm">Tambah</a>
    </div>


    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama trial</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($trial->count() > 0)
                        @foreach($trial as $rs)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $rs->id }}</td>
                                <td class="align-middle">{{ $rs->nama_trial }}</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic example">

                                        <a href="{{ route('trial.show', $rs->id) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('trial.edit', $rs->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('trial.destroy', $rs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
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
