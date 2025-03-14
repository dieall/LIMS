@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Data Rawmat</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detail Data Raw Material
            </li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Detail Data Pegawai</h6>

    </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Nama:</strong>
                            <p class="form-control-plaintext">{{ $dataRawmat->nama }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Supplier:</strong>
                            <p class="form-control-plaintext">{{ $dataRawmat->supplier }}</p>
                        </div>
                    </div>

  
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('datarawmat') }}" class="btn btn-secondary">Back</a>
    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
