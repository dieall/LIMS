@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Thermohygrometer</li>
        </ol>
        <hr>
    </nav>
</div>

@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
    {{ Session::get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Data Thermohygrometer</h6>
        <div class="d-flex gap-3 align-items-center">
            <!-- Button Tambah -->
            <a href="{{ route('datathermo.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Tanggal</th>
                        <th style="width: 25%;">Waktu</th>
                        <th style="width: 30%;">Nama</th>
                        <th style="width: 20%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datathermo as $thermo)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($thermo->tgl)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                        <td>{{ \Carbon\Carbon::parse($thermo->waktu)->format('H:i') }}</td>
                        <td>{{ $thermo->user->name }}</td>
                        <td>
                            <a href="{{ route('datathermo.show', $thermo->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('datathermo.edit', $thermo->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('datathermo.destroy', $thermo->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
