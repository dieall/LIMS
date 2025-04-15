@extends('layouts.app')

@section('contents')
<style>
    /* Form styling */
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-group label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    /* Card styling enhancement */
    .card-form {
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    /* Input field focus */
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    /* Button hover effect */
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
    }
    
    .btn-danger:hover {
        background-color: #e02d1b;
        border-color: #d52a1a;
    }
    
    /* Status badge styling */
    .badge-condition {
        font-size: 0.85rem;
        padding: 0.25rem 0.5rem;
        margin-left: 0.5rem;
        border-radius: 0.25rem;
    }
    
    .badge-baik {
        background-color: #28a745;
        color: white;
    }
    
    .badge-rusak {
        background-color: #dc3545;
        color: white;
    }
    
    /* Custom toggle switch */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .toggle-slider {
        background-color: #28a745;
    }
    
    input:focus + .toggle-slider {
        box-shadow: 0 0 1px #28a745;
    }
    
    input:checked + .toggle-slider:before {
        transform: translateX(26px);
    }
</style>

<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('instruments') }}"><i class="fas fa-tools"></i> Data Kondisi Instrument</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Kondisi Instrument</li>
        </ol>
        <hr>
    </nav>
</div>

<!-- Alert Messages -->
@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ Session::get('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> Ada kesalahan dalam pengisian form:
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-gradient-primary text-white">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-edit me-2"></i> Edit Data Kondisi Instrument
        </h6>
    </div>

    <div class="card-body">
        <form action="{{ route('instrument.update', $instrument->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <!-- Shift -->
                    <div class="form-group">
                        <label for="shift"><i class="fas fa-user-clock me-1"></i> Shift</label>
                        <select class="form-select @error('shift') is-invalid @enderror" name="shift" id="shift" required>
                            <option value="Pagi" {{ old('shift', $instrument->shift) == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                            <option value="Siang" {{ old('shift', $instrument->shift) == 'Siang' ? 'selected' : '' }}>Siang</option>
                            <option value="Malam" {{ old('shift', $instrument->shift) == 'Malam' ? 'selected' : '' }}>Malam</option>
                        </select>
                        @error('shift')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- User (Operator) -->
                    <div class="form-group">
                        <label for="user_id"><i class="fas fa-user me-1"></i> Operator</label>
                        <select class="form-select @error('user_id') is-invalid @enderror" name="user_id" id="user_id" required>
                            <option value="" disabled>Pilih Operator</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $instrument->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="col-md-6">
                    <!-- Tanggal -->
                    <div class="form-group">
                        <label for="tgl"><i class="fas fa-calendar-day me-1"></i> Tanggal</label>
                        <input type="date" class="form-control @error('tgl') is-invalid @enderror" 
                            name="tgl" id="tgl" value="{{ old('tgl', $instrument->tgl) }}" required>
                        @error('tgl')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Jam -->
                    <div class="form-group">
                        <label for="jam"><i class="fas fa-clock me-1"></i> Waktu</label>
                        <input type="time" class="form-control @error('jam') is-invalid @enderror" 
                            name="jam" id="jam" value="{{ old('jam', $instrument->jam) }}" required>
                        @error('jam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <!-- Instrument Condition Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clipboard-check me-2"></i>Data Kondisi Instrument
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover border" id="instrument-table">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="40%">Nama Instrument</th>
                                    <th width="25%">Kondisi</th>
                                    <th width="30%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 0; @endphp
                                @foreach($nama_instrument as $index => $name)
                                    <tr>
                                        <td>{{ $counter + 1 }}</td>
                                        <td>
                                            <input type="text" class="form-control" name="nama_instrument[{{ $counter }}]" 
                                                value="{{ old('nama_instrument.'.$counter, $name) }}" required>
                                        </td>
                                        <td>
                                            <select class="form-select" name="kondisi[{{ $counter }}]" 
                                                onchange="toggleKeteranganField(this, 'keterangan-{{ $counter }}')">
                                                <option value="Baik" {{ old('kondisi.'.$counter, $kondisi[$index] ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="Rusak" {{ old('kondisi.'.$counter, $kondisi[$index] ?? '') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="keterangan-{{ $counter }}" 
                                                name="keterangan[{{ $counter }}]" 
                                                value="{{ old('keterangan.'.$counter, $keterangan[$index] ?? '') }}"
                                                {{ (old('kondisi.'.$counter, $kondisi[$index] ?? '') == 'Baik') ? 'disabled' : '' }}>
                                        </td>
                                    </tr>
                                    @php $counter++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        <button type="button" class="btn btn-outline-primary" id="add-row">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Instrument
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('instruments') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Keep references to index counter
        let rowCount = {{ $counter }};
        
        // Add new row
        document.getElementById('add-row').addEventListener('click', function() {
            const table = document.getElementById('instrument-table').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            
            newRow.innerHTML = `
                <td>${rowCount + 1}</td>
                <td>
                    <input type="text" class="form-control" name="nama_instrument[${rowCount}]" required>
                </td>
                <td>
                    <select class="form-select" name="kondisi[${rowCount}]" 
                        onchange="toggleKeteranganField(this, 'keterangan-${rowCount}')">
                        <option value="Baik" selected>Baik</option>
                        <option value="Rusak">Rusak</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control" id="keterangan-${rowCount}" 
                        name="keterangan[${rowCount}]" disabled>
                </td>
            `;
            
            rowCount++;
        });
    });
    
    // Toggle keterangan field based on kondisi selection
    function toggleKeteranganField(selectElement, keteranganId) {
        const keteranganField = document.getElementById(keteranganId);
        if (selectElement.value === 'Rusak') {
            keteranganField.disabled = false;
            keteranganField.focus();
        } else {
            keteranganField.disabled = true;
            keteranganField.value = '';
        }
    }
</script>

@endsection
