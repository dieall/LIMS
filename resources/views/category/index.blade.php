@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Category</li>
        </ol>
    </nav>
</div>

<div class="d-flex align-items-center justify-content-between mb-2">
    <h1 class="mb-0 text-dark">List Category</h1>
    <a href="{{ route('category.create') }}" class="btn btn-primary btn-lg">Add Category</a>
</div>

@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>

                        <th>Nama Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($category->count() > 0)
                        @foreach($category as $rs)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <!-- <td class="align-middle">{{ $rs->id_category }}</td> -->
                                <td class="align-middle">{{ $rs->nama_kategori }}</td>
                                <td class="align-middle">.</td>
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
