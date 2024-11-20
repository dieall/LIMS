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
    <h1 class="mb-0 text-dark">List Product</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">Add Transaksi</a>
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
                        <th>Date</th>
                        <th>Category</th>
                        <th>Tipe Sampel</th>
                        <th>Batch/Lot</th>
                        <th>Deskripsi</th>
                        <th>Nama</th>
                        <th>Timestamp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($product->count() > 0)
                        @foreach($product as $rs)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ Carbon\Carbon::parse($rs->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</td>
                                <td>a</td>
                                <td class="align-middle">{{ $rs->title }}</td>
                                <td class="align-middle">{{ $rs->price }}</td>
                                <td class="align-middle">{{ $rs->product_code }}</td>
                                <td class="align-middle">{{ $rs->description }}</td>
                                <td>a</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('products.show', $rs->id) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('products.edit', $rs->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('products.destroy', $rs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
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
                            <td class="text-center" colspan="6">Product not found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
