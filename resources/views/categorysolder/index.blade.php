@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Category Solder</li>
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
            Data Category Solder
        </h6>

    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($categorysolder->count() > 0)
                        @foreach($categorysolder as $rs)
                        
                            <tr class="categorysolder-row" data-id="{{ $rs->id_category }}">
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $rs->nama_kategori }}</td>
                               
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('categorysolder.show', $rs->id_category) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('categorysolder.edit', $rs->id_category) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('categorysolder.destroy', $rs->id_category) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
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
    document.getElementById('categorysolderFilter').addEventListener('change', function() {
        const filterValue = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('table', filterValue);
        window.location.href = url; // Redirect to the updated URL
    });
</script>

@endsection
