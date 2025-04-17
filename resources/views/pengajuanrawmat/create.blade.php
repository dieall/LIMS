@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengajuanrawmat.index') }}">Raw Material</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
        </ol>
        <hr>
    </nav>
</div>

<!-- Alert Messages -->
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-plus-circle mr-2"></i> Tambah Data Raw Material
        </h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pengajuanrawmat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <!-- Dropdown untuk Nama nama_rawmat -->
                    <div class="form-group mb-3">
                        <label for="nama_rawmat" class="form-label">Kategori</label>
                        <select name="nama_rawmat" class="form-control @error('nama_rawmat') is-invalid @enderror" id="nama_rawmat" required>
                            <option disabled selected value="">Pilih Kategori</option>
                            <option value="Raw Mat Tin Chemical" {{ old('nama_rawmat') == 'Raw Mat Tin Chemical' ? 'selected' : '' }}>Raw Mat Tin Chemical</option>
                            <option value="Raw Mat Tin Chemical Varian" {{ old('nama_rawmat') == 'Raw Mat Tin Chemical Varian' ? 'selected' : '' }}>Raw Mat Tin Chemical Varian</option>
                            <option value="Raw Mat Tin Solder" {{ old('nama_rawmat') == 'Raw Mat Tin Solder' ? 'selected' : '' }}>Raw Mat Tin Solder</option>
                            <option value="Bahan Bakar" {{ old('nama_rawmat') == 'Bahan Bakar' ? 'selected' : '' }}>Bahan Bakar</option>
                        </select>
                        @error('nama_rawmat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Container untuk Dropdown Dynamic -->
                    <div class="form-group mb-3" id="dynamic-dropdown-container">
                        @if(old('nama'))
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Repopulate dropdown on form validation error
                                    document.getElementById('nama_rawmat').dispatchEvent(new Event('change'));
                                    setTimeout(function() {
                                        document.getElementById('data-rawmat').value = "{{ old('nama') }}";
                                    }, 100);
                                });
                            </script>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="date">Tanggal</label>
                        <input type="date" class="form-control @error('tgl') is-invalid @enderror" 
                               id="date" name="tgl" value="{{ old('tgl') }}" required>
                        @error('tgl')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- FIXED: Moved jam_masuk field here and made it visible -->
                    <div class="mb-3" id="jamMasukContainer">
                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                <input type="time" name="jam_masuk" class="form-control" id="jam_masuk" required readonly>
            </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="supplier">Supplier</label>
                        <input type="text" class="form-control @error('supplier') is-invalid @enderror" 
                               id="supplier" name="supplier" value="{{ old('supplier') }}" 
                               placeholder="Masukkan Nama Supplier" required>
                        @error('supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="coa">CoA</label>
                        <select class="form-control @error('coa') is-invalid @enderror" 
                                id="coa" name="coa" required>
                            <option value="">-- Pilih CoA --</option>
                            <option value="Ada" {{ old('coa') == 'Ada' ? 'selected' : '' }}>Ada</option>
                            <option value="Tidak Ada" {{ old('coa') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('coa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="batch">Batch / Lot</label>
                        <input type="text" class="form-control @error('batch') is-invalid @enderror" 
                               id="batch" name="batch" value="{{ old('batch') }}" 
                               placeholder="Masukkan Batch" required>
                        @error('batch')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="no_mobil">Nomor Mobil/Container</label>
                        <input type="text" class="form-control @error('no_mobil') is-invalid @enderror" 
                               id="no_mobil" name="no_mobil" value="{{ old('no_mobil') }}" 
                               placeholder="Masukkan Nomor Mobil/Container" required>
                        @error('no_mobil')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="desc">Deskripsi</label>
                <textarea class="form-control @error('desc') is-invalid @enderror" id="desc" name="desc" 
                        rows="3" placeholder="Masukkan deskripsi atau informasi tambahan" required>{{ old('desc') }}</textarea>
                @error('desc')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="mt-2 small text-muted">
                    <i class="fas fa-info-circle mr-1"></i> Tambahkan informasi detail mengenai raw material yang diajukan.
                </div>
            </div>

            <!-- Hidden fields -->
            <input type="hidden" name="status" value="Pengajuan">
            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::id() }}">

            <div class="mt-4">
                <a href="{{ route('pengajuanrawmat.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                    <i class="fas fa-save mr-1"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let selectedRawMat = '';
    
    // Dropdown Dinamis
    document.getElementById('nama_rawmat').addEventListener('change', function () {
        const container = document.getElementById('dynamic-dropdown-container');
        const selectedValue = this.value;

        container.innerHTML = ''; // Reset container
        document.getElementById('submitBtn').disabled = true; // Disable the button initially

        // Menghasilkan dropdown berdasarkan nama_rawmat
        if (selectedValue === 'Raw Mat Tin Chemical') {
            container.innerHTML = generateDropdown([ 
                "Methyl Chloride (MeCl)", 
                "Tetramethyl Ammonium Chloride (TMAC)",
                "Ammonia Liquid",
                "2-Ethylhexyl Thioglicolate (2-EHTG)",
                "Diphenyl Isodecyl Phospite (DPDP)"

            ]);
        } else if (selectedValue === 'Raw Mat Tin Chemical Varian') {
            container.innerHTML = generateDropdown([
                "Epoxidized Soybean Oil (ESBO)", 
                "Ecosoft P5025",
                "DOP"
            ]);
        } else if (selectedValue === 'Raw Mat Tin Solder') {
            container.innerHTML = generateDropdown([
                "Logam Timah Grade 99.85%",
                "Logam Timbal Grade 99.9%", 
                "Logam Tembaga Grade 99.9%",
                "Logam Perak Grade 99.9%"
                
            ]);
        } else if (selectedValue === 'Bahan Bakar') {
            container.innerHTML = generateDropdown(["Solar"]);
        } else if (selectedValue === 'Tinchem' || selectedValue === 'Tinstab') {
            container.innerHTML = generateDropdown([
                "Sample 1", 
                "Sample 2", 
                "Sample 3"
            ]);
        }
        
        // Add listener after creating dropdown
        addDataRawmatChangeListener();
    });

    // Fungsi untuk membuat dropdown dinamis
    function generateDropdown(options) {
        let html = `
            <label for="data-rawmat" class="form-label">Pilih Data Rawmat</label>
            <select name="nama" class="form-control @error('nama') is-invalid @enderror" id="data-rawmat" required>
                <option disabled selected value="">Pilih</option>`;
                
        options.forEach(option => {
            html += `<option value="${option}">${option}</option>`;
        });
        
        html += `</select>`;
        
        // Add error message if validation failed
        html += `@error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror`;
        
        return html;
    }

    // Function to add event listener to the dynamically created dropdown
    function addDataRawmatChangeListener() {
        const dataRawmat = document.getElementById('data-rawmat');
        if (dataRawmat) {
            dataRawmat.addEventListener('change', function() {
                selectedRawMat = this.value;
                validateForm();
            });
        }
    }
    
    // Function to validate all required fields before enabling submit button
    function validateForm() {
        const nama_rawmat = document.getElementById('nama_rawmat').value;
        const rawmat = document.getElementById('data-rawmat')?.value;
        const tgl = document.getElementById('date').value;
        const supplier = document.getElementById('supplier').value;
        const jamMasuk = document.getElementById('jam_masuk').value;
        
        // Only enable submit if all required fields have values
        if (nama_rawmat && rawmat && tgl && supplier && jamMasuk) {
            document.getElementById('submitBtn').disabled = false;
        } else {
            document.getElementById('submitBtn').disabled = true;
        }
    }
    
    // Add event listeners to validate form on input change
    document.getElementById('nama_rawmat').addEventListener('change', validateForm);
    document.getElementById('date').addEventListener('change', validateForm);
    document.getElementById('supplier').addEventListener('input', validateForm);
    document.getElementById('jam_masuk').addEventListener('change', validateForm);

    document.addEventListener("DOMContentLoaded", function () {
        // Set Tanggal Otomatis
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];
        if (!document.getElementById('date').value) {
            document.getElementById('date').value = formattedDate;
        }

        // Set Jam Masuk Otomatis
        const hours = today.getHours().toString().padStart(2, '0');
        const minutes = today.getMinutes().toString().padStart(2, '0');
        const formattedTime = `${hours}:${minutes}`;
        document.getElementById('jam_masuk').value = formattedTime;
        
        // Run validation after setting default values
        setTimeout(validateForm, 100);
    });
</script>
@endsection
