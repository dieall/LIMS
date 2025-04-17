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
        color: #e74a3b;
    }
    
    /* Table styling */
    .table th {
        background-color: #f8f9fa;
    }
    
    /* Radio button group styling */
    .radio-group {
        display: flex;
        gap: 1.5rem;
    }
    
    .radio-item {
        display: flex;
        align-items: center;
    }
    
    .radio-item input[type="radio"] {
        margin-right: 0.5rem;
    }
    
    /* Error message styling */
    .error-text {
        color: #e74a3b;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('instruments') }}"><i class="fas fa-tools"></i> Data Kondisi Instrumen</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-plus"></i> Tambah Instrumen</li>
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

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> Terdapat kesalahan dalam form:
        <ul class="mb-0">
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
            <i class="fas fa-plus-circle me-2"></i> Tambah Instrumen Baru
        </h6>
    </div>

    <div class="card-body">
        <form action="{{ route('instrument.store') }}" method="POST">
            @csrf

            <div class="row mb-4">
                <!-- Kolom Kiri 1 -->
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="shift" class="form-label required">Shift</label>
                        <select name="shift" class="form-select @error('shift') is-invalid @enderror" id="shift" required>
                            <option value="Pagi" {{ old('shift', $shift) == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                            <option value="Siang" {{ old('shift', $shift) == 'Siang' ? 'selected' : '' }}>Siang</option>
                            <option value="Malam" {{ old('shift', $shift) == 'Malam' ? 'selected' : '' }}>Malam</option>
                        </select>
                        @error('shift')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="tgl" class="form-label required">Tanggal</label>
                        <input type="date" name="tgl" class="form-control @error('tgl') is-invalid @enderror" id="tgl" value="{{ old('tgl', date('Y-m-d')) }}" required>
                        @error('tgl')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Kolom Kiri 2 -->
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="jam" class="form-label required">Jam</label>
                        <input type="time" name="jam" class="form-control @error('jam') is-invalid @enderror" id="jam" value="{{ old('jam', date('H:i')) }}" required>
                        @error('jam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="user_id" class="form-label required">Nama</label>
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" id="user_id" required>
                            <option value="">Pilih Nama</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                    {{ old('user_id', auth()->user()->id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light text-dark">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 40%;">Nama Instrumen</th>
                            <th style="width: 20%;">Kondisi</th>
                            <th style="width: 35%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($instruments as $index => $instrument)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <!-- Store instrument ID and name as hidden fields -->
                                    <input type="hidden" name="nama_instrument[{{ $index }}]" value="{{ $instrument->nama_instrument }}">
                                    <span>{{ $instrument->nama_instrument }}</span>
                                </td>
                                <td>
                                    <div class="radio-group">
                                        <label class="radio-item">
                                            <input type="radio" name="kondisi[{{ $index }}]" value="Baik" 
                                                {{ old('kondisi.'.$index) == 'Baik' ? 'checked' : 'checked' }} required> 
                                            Baik
                                        </label>
                                        <label class="radio-item">
                                            <input type="radio" name="kondisi[{{ $index }}]" value="Rusak" 
                                                {{ old('kondisi.'.$index) == 'Rusak' ? 'checked' : '' }}> 
                                            Rusak
                                        </label>
                                    </div>
                                    @error('kondisi.'.$index)
                                        <div class="error-text">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <textarea name="keterangan[{{ $index }}]" class="form-control @error('keterangan.'.$index) is-invalid @enderror" rows="1" 
                                        placeholder="Keterangan (wajib diisi jika kondisi rusak)">{{ old('keterangan.'.$index, '') }}</textarea>
                                    <div class="form-text">Wajib diisi jika kondisi rusak</div>
                                    @error('keterangan.'.$index)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>  

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('instruments') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Instrumen
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide keterangan field based on kondisi selection
    document.querySelectorAll('input[type="radio"][name^="kondisi"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            let index = this.name.match(/\d+/)[0];
            let textarea = document.querySelector(`textarea[name="keterangan[${index}]"]`);
            
            if (this.value === 'Rusak') {
                textarea.required = true;
                textarea.nextElementSibling.innerHTML = '<strong>Wajib diisi karena kondisi rusak</strong>';
            } else {
                textarea.required = false;
                textarea.nextElementSibling.innerHTML = 'Wajib diisi jika kondisi rusak';
            }
        });
    });
});
</script>
@endsection
