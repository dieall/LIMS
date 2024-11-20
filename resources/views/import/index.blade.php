<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Export Data</li>
        </ol>
        <hr>
    </nav>
</div>

@if(Session::has('success'))
    <div class="alert alert-success" role="alert" id="success-alert">
        {{ Session::get('success') }}
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-2 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold">Export Data</h5>
        <a href="{{ route('export.data') }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export ke Excel
        </a>
    </div>
    <div class="card-body">
        <!-- Konten tambahan atau deskripsi tentang proses export -->
        <p>Gunakan tombol di atas untuk mengekspor data ke dalam file Excel.</p>
    </div>
</div>

<!-- Script untuk Bootstrap dan Font Awesome -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

@endsection
