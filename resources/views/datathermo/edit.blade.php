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
    
    /* Card styling */
    .card-form {
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    /* Input field focus */
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    /* Temperature and humidity display */
    .temp-value {
        color: #e74a3b;
    }
    
    .humid-value {
        color: #4e73df;
    }
    
    /* Buttons */
    .btn-group-sm > .btn, .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
    
    /* Table */
    .table th {
        background-color: #f8f9fa;
    }

    /* Required field indicator */
    .required::after {
        content: " *";
        color: #dc3545;
    }
</style>

<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('datathermo') }}"><i class="fas fa-thermometer-half"></i> Data Thermohygrometer</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Data Thermohygrometer</li>
        </ol>
        <hr>
    </nav>
</div>

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
            <i class="fas fa-edit me-2"></i> Edit Data Thermohygrometer
        </h6>
    </div>

    <div class="card-body">
        <form action="{{ route('datathermo.update', $dataThermo->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <!-- Tanggal -->
                    <div class="form-group">
                        <label for="tgl" class="required"><i class="fas fa-calendar-day me-1"></i> Tanggal</label>
                        <input type="date" class="form-control @error('tgl') is-invalid @enderror" 
                            name="tgl" id="tgl" value="{{ old('tgl', $dataThermo->tgl) }}" required>
                        @error('tgl')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Waktu -->
                    <div class="form-group">
                        <label for="waktu" class="required"><i class="fas fa-clock me-1"></i> Waktu</label>
                        <input type="time" class="form-control @error('waktu') is-invalid @enderror" 
                            name="waktu" id="waktu" value="{{ old('waktu', $dataThermo->waktu) }}" required>
                        @error('waktu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Right Column - Changed from user_id to nama -->
                <div class="col-md-6">
                    <!-- Operator (nama) -->
                    <div class="form-group">
                        <label for="nama" class="required"><i class="fas fa-user me-1"></i> Operator</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                               name="nama" id="nama" 
                               value="{{ old('nama', $dataThermo->nama) }}"
                               list="operator-suggestions" required>
                        <!-- Datalist for name suggestions -->
                        <datalist id="operator-suggestions">
                            @foreach(App\Models\User::where('level', 'Operator Lab')->get() as $user)
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
            
            <!-- Thermohygrometer Readings Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-temperature-high me-2"></i> Data Pengukuran
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $nama_thermo = json_decode($dataThermo->nama_thermo, true) ?? [];
                        $suhu = json_decode($dataThermo->suhu, true) ?? [];
                        $kelembapan = json_decode($dataThermo->kelembapan, true) ?? [];
                        $counter = 0;
                    @endphp

                    <div class="table-responsive">
                        <table class="table table-hover border" id="thermo-table">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="40%">Lokasi Pengukuran</th>
                                    <th width="25%">Suhu (°C)</th>
                                    <th width="25%">Kelembapan (%)</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nama_thermo as $index => $name)
                                    <tr>
                                        <td class="align-middle">{{ $counter + 1 }}</td>
                                        <td>
                                            <input type="text" class="form-control" name="nama_thermo[{{ $counter }}]" 
                                                value="{{ old('nama_thermo.'.$counter, $name) }}" required>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" step="0.1" class="form-control" name="suhu[{{ $counter }}]" 
                                                    value="{{ old('suhu.'.$counter, $suhu[$index] ?? '') }}" required>
                                                <span class="input-group-text">°C</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" step="0.1" class="form-control" name="kelembapan[{{ $counter }}]" 
                                                    value="{{ old('kelembapan.'.$counter, $kelembapan[$index] ?? '') }}" required>
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @php $counter++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        <button type="button" class="btn btn-outline-primary" id="add-row">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Lokasi Pengukuran
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('datathermo') }}" class="btn btn-secondary">
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
            const table = document.getElementById('thermo-table').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            
            newRow.innerHTML = `
                <td class="align-middle">${rowCount + 1}</td>
                <td>
                    <input type="text" class="form-control" name="nama_thermo[${rowCount}]" required>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" step="0.1" class="form-control" name="suhu[${rowCount}]" required>
                        <span class="input-group-text">°C</span>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" step="0.1" class="form-control" name="kelembapan[${rowCount}]" required>
                        <span class="input-group-text">%</span>
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            
            rowCount++;
            
            // Attach event listener to the new remove button
            attachRemoveRowEvent(newRow.querySelector('.remove-row'));
        });
        
        // Function to attach remove row event
        function attachRemoveRowEvent(button) {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                row.remove();
                updateRowNumbers();
            });
        }
        
        // Attach event listeners to existing remove buttons
        document.querySelectorAll('.remove-row').forEach(button => {
            attachRemoveRowEvent(button);
        });
        
        // Update row numbers
        function updateRowNumbers() {
            const rows = document.getElementById('thermo-table').getElementsByTagName('tbody')[0].rows;
            for (let i = 0; i < rows.length; i++) {
                rows[i].cells[0].textContent = i + 1;
            }
        }
    });
</script>
@endsection
