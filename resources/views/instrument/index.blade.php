@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Kondisi Instrument</li>
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
        <h6 class="m-0 font-weight-bold">Data Interval</h6>
        <a href="{{ route('instrument.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Shift</th>
                        <th>Jam</th>
                        <th>Tanggal</th>    
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instruments as $instrument)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $instrument->shift }}</td>
                            <td>{{ \Carbon\Carbon::parse($instrument->jam)->format('H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($instrument->tgl)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                            <td>
                                <a href="{{ route('instrument.show', $instrument->id) }}" class="btn btn-info">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> <!-- <div class="card shadow mb-4"> sudah ditutup di sini -->

@endsection
