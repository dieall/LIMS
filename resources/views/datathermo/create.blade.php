@extends('layouts.app')

@section('contents')
<style>
    /* Form styling */
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    /* Required field indicator */
    .required::after {
        content: " *";
        color: #dc3545;
    }
    
    /* Table styling */
    .table th {
        background-color: #f8f9fa;
    }
    
    /* Input field focus styling */
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
</style>

<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home me-1"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('datathermo') }}"><i class="fas fa-thermometer-half me-1"></i> Data Thermohygrometer</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-plus me-1"></i> Tambah Data</li>
        </ol>
        <hr>
    </nav>
</div>

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ Session::get('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-gradient-primary text-white">
        <h6 class="m-0 font-weight-bold"><i class="fas fa-plus-circle me-2"></i> Tambah Data Thermohygrometer</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('datathermo.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <!-- Date and Time Column -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal" class="form-label required">Tanggal</label>
                        <input type="date" name="tgl" class="form-control @error('tgl') is-invalid @enderror" id="tgl" required>
                        @error('tgl')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="waktu" class="form-label required">Waktu</label>
                        <input type="time" name="waktu" class="form-control @error('waktu') is-invalid @enderror" id="waktu" required>
                        @error('waktu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Changed from user_id dropdown to nama text input -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nama" class="form-label required">Nama Operator</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" id="nama" 
                               placeholder="Masukkan nama operator" 
                               value="{{ old('nama', auth()->user()->name ?? '') }}" 
                               list="operator-suggestions" required>
                        <!-- Datalist for name suggestions -->
                        <datalist id="operator-suggestions">
                            @foreach($users as $user)
                                <option value="{{ $user->name }}">
                            @endforeach
                        </datalist>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <hr class="my-4">

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light text-dark">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 45%;">Lokasi Pengukuran</th>
                            <th style="width: 25%;">Suhu (°C)</th>
                            <th style="width: 25%;">Kelembapan (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($thermodata as $index => $thermo)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <input type="hidden" name="nama_thermo[{{ $index }}]" value="{{ $thermo->nama_thermo }}">
                                    <span>{{ $thermo->nama_thermo }}</span>
                                </td>
                                <!-- Kolom Suhu -->
                                <td>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="suhu[{{ $index }}]" id="suhu_{{ $index }}" 
                                              class="form-control @error('suhu.'.$index) is-invalid @enderror" 
                                              value="{{ old('suhu.'.$index) }}" 
                                              placeholder="0.0" required>
                                        <span class="input-group-text">°C</span>
                                        @error('suhu.'.$index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </td>

                                <!-- Kolom Kelembapan -->
                                <td>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="kelembapan[{{ $index }}]" id="kelembapan_{{ $index }}" 
                                              class="form-control @error('kelembapan.'.$index) is-invalid @enderror" 
                                              value="{{ old('kelembapan.'.$index) }}" 
                                              placeholder="0.0" required>
                                        <span class="input-group-text">%</span>
                                        @error('kelembapan.'.$index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('datathermo') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tgl').value = today;

    // Set default time to current time
    const currentTime = new Date();
    const hours = String(currentTime.getHours()).padStart(2, '0');
    const minutes = String(currentTime.getMinutes()).padStart(2, '0');
    const formattedTime = `${hours}:${minutes}`;
    document.getElementById('waktu').value = formattedTime;
});
</script>
@endsection
