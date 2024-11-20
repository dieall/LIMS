
@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Sn/Cu Series</li>
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

    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">
            Data tin
        </h6>
        <div class="d-flex align-items-center">
            <!-- Filter Dropdown -->
            <div class="d-flex justify-content-between align-items-center mb-1">
    <a href="{{ route('tin.create') }}" class="btn btn-success btn-sm">Tambah</a>
</div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Type Solder</th>
                        <th>Spesification</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($tin->count() > 0)
                        @foreach($tin as $rs)
                        
                            <tr class="tin-row" data-id="{{ $rs->id }}">
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $rs->tipe_solder  }}</td>
                                <td class="align-middle">{{ $rs->spesification }}</td>
                                <td class="align-middle">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-cogs"></i> Actions
        </button>
        <ul class="dropdown-menu">
            <!-- Tombol Detail -->
            <li>
                <button type="button" class="dropdown-item btn-detail">
                    <i class="fas fa-eye"></i> Detail
                </button>
            </li>

            <!-- Tombol Edit -->
            <li>
                <button type="button" class="dropdown-item btn-edit">
                    <i class="fas fa-pencil-alt"></i> Edit
                </button>
            </li>

            <!-- Tombol Delete -->
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
    document.getElementById('tinFilter').addEventListener('change', function() {
        const filterValue = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('table', filterValue);
        window.location.href = url; // Redirect to the updated URL
    });
</script>

@endsection
