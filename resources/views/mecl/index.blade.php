@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data MecL</li>
        </ol><hr>
    </nav>
</div>

@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Data MecL</h6>
        <a href="{{ route('mecl.create') }}" class="btn btn-success btn-sm">Tambah</a>
    </div>

    <div class="card-body">
        <!-- Dropdown untuk memilih jumlah data per halaman -->
        <form method="GET" action="{{ route('mecl') }}" class="mb-3"> <!-- Update di sini -->
            <div class="d-flex align-items-center">
                <label for="per_page" class="me-2">Show:</label>
                <select name="per_page" id="per_page" class="form-control w-auto" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <!-- <th>ID</th> -->
                        <th>Nama Mecl</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($mecl->count() > 0)
                        @foreach($mecl as $rs)
                            <tr>
                                <td class="align-middle">{{ ($mecl->currentPage() - 1) * $mecl->perPage() + $loop->iteration }}</td>
                                <!-- <td class="align-middle">{{ $rs->id }}</td> -->
                                <td class="align-middle">{{ $rs->nama_mecl }}</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('mecl.show', $rs->id) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('mecl.edit', $rs->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('mecl.destroy', $rs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
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
