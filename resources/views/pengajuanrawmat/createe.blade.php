@extends('layouts.app')

@section('contents')
<style>
    .validation-box {
        position: relative;
        display: block;
        width: 100%;
        margin-top: 5px;
    }

    .validation-success {
        background-color: #d4edda;
        color: #155724;
        border: 2px solid #c3e6cb;
        border-radius: 8px;
        padding: 10px;
        font-size: 14px;
        font-weight: bold;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .validation-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 2px solid #f5c6cb;
        border-radius: 8px;
        padding: 10px;
        font-size: 14px;
        font-weight: bold;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
</style>

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengajuanrawmat.index') }}">Data Raw Material</a></li>
            <li class="breadcrumb-item active" aria-current="page">Analisa Raw Material</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-flask mr-2"></i> Analisa Data | Raw Material
        </h6>
    </div>

    <div class="card-body">
        <form action="{{ isset($pengajuanrawmat) ? route('pengajuanrawmat.update', $pengajuanrawmat->id) : route('pengajuanrawmat.store') }}" method="POST">
            @csrf
            @if(isset($pengajuanrawmat))
                @method('PUT')
            @endif
            
            <div class="card-body">
                <div class="mb-3">
                    <label for="select_transaksi" class="form-label">
                        <i class="fas fa-exchange-alt"></i> Pilih Data Pengajuan Raw Material Hari Ini
                        <span class="badge badge-info">{{ Carbon\Carbon::now()->format('d M Y') }}</span>
                    </label>
                    <select class="form-control" name="select_transaksi" id="select_transaksi" required readonly>
                        <option disabled selected value="">Pengajuan Raw Material Hari Ini</option>
                        @forelse($transaksi as $trx)
                            <option value="{{ $trx->id }}"
                                data-nama="{{ $trx->nama }}"
                                data-nama_rawmat="{{ $trx->nama_rawmat }}"
                                data-batch="{{ $trx->batch }}"
                                data-supplier="{{ $trx->supplier }}"
                                data-no_mobil="{{ $trx->no_mobil }}"
                                data-desc="{{ $trx->desc }}"
                                data-created_at="{{ $trx->created_at }}"
                                {{ isset($pengajuanrawmat) && $pengajuanrawmat->id == $trx->id ? 'selected' : '' }}>
                                ⌚ {{ Carbon\Carbon::parse($trx->created_at)->format('H:i') }} | 
                                🏷️ {{ $trx->nama_rawmat }} | 
                                🧪 {{ $trx->nama }} | 
                                📦 {{ $trx->batch }}
                            </option>
                        @empty
                            <option disabled>Tidak ada pengajuan raw material hari ini</option>
                        @endforelse
                    </select>
                </div>

                <div id="transaksi-details" class="mt-3" style="display:none;">
                    <h5>Detail Pengajuan Raw Material</h5>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Nama</th>
                                <th>Batch/Lot</th>
                                <th>Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td id="detail-tgl"></td>
                                <td id="detail-nama_rawmat"></td>
                                <td id="detail-nama"></td>
                                <td id="detail-batch"></td>
                                <td id="detail-supplier"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_rawmat" class="form-label">Kategori Raw Material</label>
                        <select class="form-control" name="nama_rawmat" id="nama_rawmat" required readonly>
                            <option disabled selected value="">Pilih Kategori</option>
                            @foreach ($datarawmat_categories as $category)
                                <option value="{{ $category->nama_rawmat }}" {{ isset($pengajuanrawmat) && $pengajuanrawmat->nama_rawmat == $category->nama_rawmat ? 'selected' : '' }}>
                                    {{ $category->nama_rawmat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama Raw Material</label>
                        <select name="nama" class="form-control" id="nama" required>
                            <option disabled selected value="">Pilih Raw Material</option>
                            @if(isset($pengajuanrawmat))
                                <option value="{{ $pengajuanrawmat->nama }}" selected>{{ $pengajuanrawmat->nama }}</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tgl" class="form-label">Tanggal</label>
                        <input type="date" name="tgl" class="form-control" id="tgl" value="{{ isset($pengajuanrawmat) ? $pengajuanrawmat->tgl : '' }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="user_id" class="form-label">Dianalisa Oleh</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name ?? 'Default User' }}" readonly>
                        <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}">
                    </div>
                </div>
                
                <input type="hidden" name="jam_masuk" id="jam_masuk" value="{{ isset($pengajuanrawmat) ? date('H:i', strtotime($pengajuanrawmat->jam_masuk)) : '' }}">

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="batch" class="form-label">Batch / Lot</label>
                        <input type="text" name="batch" class="form-control" id="batch" placeholder="Batch/Lot" 
                               value="{{ isset($pengajuanrawmat) ? $pengajuanrawmat->batch : '' }}" required readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input type="text" name="supplier" class="form-control" id="supplier" placeholder="Supplier" 
                               value="{{ isset($pengajuanrawmat) ? $pengajuanrawmat->supplier : '' }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="no_mobil" class="form-label">Nomor Mobil</label>
                        <input type="text" name="no_mobil" class="form-control" id="no_mobil" placeholder="No. Mobil" 
                               value="{{ isset($pengajuanrawmat) ? $pengajuanrawmat->no_mobil : '' }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="desc" class="form-label">Deskripsi</label>
                        <input type="text" name="desc" class="form-control" id="desc" placeholder="Deskripsi" 
                               value="{{ isset($pengajuanrawmat) ? $pengajuanrawmat->desc : '' }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="coa" class="form-label">CoA</label>
                        <input type="text" name="coa" class="form-control" id="coa" placeholder="Certificate of Analysis" 
                               value="{{ isset($pengajuanrawmat) ? $pengajuanrawmat->coa : '' }}" required>
                    </div>
                </div>

                <div class="row mt-4" id="detailTableContainer">
                    <div class="col-md-12">
                        <h5 class="mb-3">Parameter Analisa Raw Material</h5>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i> Isi nilai parameter sesuai dengan hasil analisa. Status akan otomatis muncul sesuai dengan spesifikasi yang telah ditentukan.
                        </div>
                        <table class="table table-striped table-bordered" id="detailTable">
                            <thead>
                                <tr>
                                    <th width="25%">Parameter</th>
                                    <th width="25%">Spesifikasi</th>
                                    <th width="25%">Hasil Analisa</th>
                                    <th width="25%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('pengajuanrawmat.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> {{ isset($pengajuanrawmat) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Data from backend
const rawMatTypeData = {
    'Raw Mat Tin Chemical': {!! json_encode($rawmat_tin_chemical->toArray() ?? []) !!},
    'Raw Mat Tin Chemical Varian': {!! json_encode($rawmat_tin_chemical_varian->toArray() ?? []) !!},
    'Raw Mat Tin Solder': {!! json_encode($rawmat_tin_solder->toArray() ?? []) !!},
    'Bahan Bakar': {!! json_encode($bahan_bakar->toArray() ?? []) !!}
};

// Store all raw material specifications from database
const allRawMatSpecs = {!! json_encode($all_rawmat_specs ?? []) !!};

// Existing raw material data if in edit mode
const existingRawMat = {!! isset($pengajuanrawmat) ? json_encode($pengajuanrawmat) : 'null' !!};

// Field display names mapping
const fieldDisplayNames = {
    'sn': 'Tin (Sn)',
    'purity': 'Purity',
    'purity_tmac': 'Purity TMAC',
    'appreance': 'Appearance',
    'sg': 'Specific Gravity',
    'fe_amo': 'Fe Amount',
    'si_amo': 'Si Amount',
    'sh': 'SH',
    'acid': 'Acid Value',
    'ri': 'Refractive Index',
    'free': 'Free Content',
    'ph': 'pH Value',
    'fe': 'Iron (Fe)',
    'si': 'Silicon (Si)',
    'sulfur': 'Sulfur Content',
    'visual': 'Visual',
    'water': 'Water Content',
    'color': 'Color',
    'acidity': 'Acidity',
    'lodine': 'Iodine Value',
    'ag': 'Silver (Ag)',
    'cu': 'Copper (Cu)',
    'pb': 'Lead (Pb)',
    'sb': 'Antimony (Sb)',
    'zn': 'Zinc (Zn)',
    'as': 'Arsenic (As)',
    'ni': 'Nickel (Ni)',
    'bi': 'Bismuth (Bi)',
    'cd': 'Cadmium (Cd)',
    'ai': 'Aluminum (Al)',
    'pe': 'Petroleum',
    'ga': 'Gallium (Ga)',
    'densi': 'Density',
    'clarity': 'Clarity',
    'apha': 'APHA Color'
};

// Handle transaction selection change
document.getElementById('select_transaksi')?.addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];

    if (selectedOption.value) {
        const nama = selectedOption.getAttribute('data-nama');
        const nama_rawmat = selectedOption.getAttribute('data-nama_rawmat');
        const batch = selectedOption.getAttribute('data-batch');
        const supplier = selectedOption.getAttribute('data-supplier');
        const no_mobil = selectedOption.getAttribute('data-no_mobil');
        const deskripsi = selectedOption.getAttribute('data-desc');
        const createdAt = selectedOption.getAttribute('data-created_at');

        document.getElementById('transaksi-details').style.display = 'block';
        document.getElementById('detail-tgl').innerText = createdAt ? new Date(createdAt).toLocaleDateString() : '-';
        document.getElementById('detail-nama_rawmat').innerText = nama_rawmat || '-';
        document.getElementById('detail-nama').innerText = nama || '-';
        document.getElementById('detail-batch').innerText = batch || '-';
        document.getElementById('detail-supplier').innerText = supplier || '-';

        const rawmatSelect = document.getElementById('nama_rawmat');
        const namaSelect = document.getElementById('nama');
        const batchInput = document.getElementById('batch');
        const supplierInput = document.getElementById('supplier');
        const no_mobilInput = document.getElementById('no_mobil');
        const descInput = document.getElementById('desc');
        const tglInput = document.getElementById('tgl');
        
        if (rawmatSelect) rawmatSelect.value = nama_rawmat;
        if (batchInput) batchInput.value = batch || '';
        if (supplierInput) supplierInput.value = supplier || '';
        if (no_mobilInput) no_mobilInput.value = no_mobil || '';
        if (descInput) descInput.value = deskripsi || '';
        if (tglInput) tglInput.value = createdAt ? createdAt.split(' ')[0] : '';

        updateNamaRawMat(nama_rawmat, nama);
        updateDetailTable(nama_rawmat, nama);
    }
});

function updateNamaRawMat(nama_rawmat, selectedNama = null) {
    const namaSelect = document.getElementById('nama');
    if (!namaSelect) return;
    
    namaSelect.innerHTML = '';
    
    // Add default option
    const defaultOption = document.createElement('option');
    defaultOption.value = "";
    defaultOption.textContent = "Pilih Raw Material";
    defaultOption.disabled = true;
    defaultOption.selected = !selectedNama;
    namaSelect.appendChild(defaultOption);
    
    if (nama_rawmat && rawMatTypeData[nama_rawmat]) {
        rawMatTypeData[nama_rawmat].forEach(function (item) {
            const option = document.createElement('option');
            option.value = item.nama;
            option.textContent = item.nama;
            if (item.nama === selectedNama) {
                option.selected = true;
            }
            namaSelect.appendChild(option);
        });
    }
}

// Listen for changes to the nama dropdown
document.getElementById('nama_rawmat')?.addEventListener('change', function() {
    const selectedCategory = this.value;
    updateNamaRawMat(selectedCategory);
});

document.getElementById('nama')?.addEventListener('change', function() {
    const selectedNama = this.value;
    const nama_rawmat = document.getElementById('nama_rawmat')?.value || '';
    updateDetailTable(nama_rawmat, selectedNama);
});

function updateDetailTable(nama_rawmat, selectedNama = null) {
    const detailTableBody = document.getElementById('detailTable')?.querySelector('tbody');
    if (!detailTableBody) return;
    
    detailTableBody.innerHTML = ''; // Clear the table
    
    // First, try to find the raw material specification by exact name match
    let rawMatSpec = null;
    
    if (selectedNama) {
        rawMatSpec = allRawMatSpecs.find(spec => spec && spec.nama === selectedNama);
    }
    
    // If we didn't find a spec by name, try to find by category
    if (!rawMatSpec && nama_rawmat) {
        rawMatSpec = allRawMatSpecs.find(spec => spec && spec.nama_rawmat === nama_rawmat);
    }
    
    if (rawMatSpec) {
        // List all possible raw material fields
        const fieldList = [
            'sn', 'purity', 'purity_tmac', 'appreance', 'sg', 'fe_amo', 'si_amo', 
            'sh', 'acid', 'ri', 'free', 'ph', 'fe', 'si', 'sulfur', 'visual', 
            'water', 'color', 'acidity', 'lodine', 'ag', 'cu', 'pb', 'sb', 'zn', 
            'as', 'ni', 'bi', 'cd', 'ai', 'pe', 'ga', 'densi', 'clarity', 'apha'
        ];
        
        // Only display fields that have specifications for this raw material type
        fieldList.forEach(field => {
            // Check if this field is relevant for this raw material (has a specification)
            if (rawMatSpec[field] && rawMatSpec[field].toString().trim() !== '') {
                const row = document.createElement('tr');
                
                // Get existing value if we're in edit mode
                const existingValue = existingRawMat && existingRawMat[field] ? existingRawMat[field] : '';
                
                // Get existing status if available
                const statusField = field + '_status';
                const existingStatus = existingRawMat && existingRawMat[statusField] ? existingRawMat[statusField] : '';
                
                row.innerHTML = `
                    <td>${fieldDisplayNames[field] || field}</td>
                    <td>${rawMatSpec[field]}</td>
                    <td><input type="text" name="${field}" class="form-control" 
                         value="${existingValue}" placeholder="Masukkan hasil analisa"></td>
                    <td id="status-${field}">
                        ${existingStatus === 'Passed' ? 
                            '<div class="validation-success">✓ Passed</div>' : 
                            (existingStatus === 'Not Passed' ? 
                                '<div class="validation-error">✗ Not Passed</div>' : '--')}
                    </td>
                `;
                
                detailTableBody.appendChild(row);
                
                // Add hidden status field if we have existing status
                if (existingStatus) {
                    const hiddenField = document.createElement('input');
                    hiddenField.type = 'hidden';
                    hiddenField.id = `${field}_status`;
                    hiddenField.name = `${field}_status`;
                    hiddenField.value = existingStatus;
                    document.querySelector('form').appendChild(hiddenField);
                }
                
                // Add input validation
                const input = row.querySelector(`input[name="${field}"]`);
                if (input) {
                    input.addEventListener('input', function() {
                        validateInput(this, rawMatSpec[field], document.getElementById(`status-${field}`), field);
                    });
                    
                    // Trigger validation if there's an existing value
                    if (existingValue) {
                        input.dispatchEvent(new Event('input'));
                    }
                }
            }
        });
    } else {
        // If no specific raw material specification is found, display generic fields for the category
        const genericFields = getGenericFieldsForCategory(nama_rawmat);
        
        genericFields.forEach((field, index) => {
            const row = document.createElement('tr');
            
            // Get existing value if we're in edit mode
            const fieldName = field.key;
            const existingValue = existingRawMat && existingRawMat[fieldName] ? existingRawMat[fieldName] : '';
            
            // Get existing status if available
            const statusField = fieldName + '_status';
            const existingStatus = existingRawMat && existingRawMat[statusField] ? existingRawMat[statusField] : '';
            
            row.innerHTML = `
                <td>${field.display}</td>
                <td>${field.spec || '-'}</td>
                <td><input type="text" name="${fieldName}" class="form-control" value="${existingValue}"></td>
                <td id="status-${fieldName}">
                    ${existingStatus === 'Passed' ? 
                        '<div class="validation-success">✓ Passed</div>' : 
                        (existingStatus === 'Not Passed' ? 
                            '<div class="validation-error">✗ Not Passed</div>' : '--')}
                </td>
            `;
            
            detailTableBody.appendChild(row);
            
            // Add hidden status field if we have existing status
            if (existingStatus) {
                const hiddenField = document.createElement('input');
                hiddenField.type = 'hidden';
                hiddenField.id = `${fieldName}_status`;
                hiddenField.name = `${fieldName}_status`;
                hiddenField.value = existingStatus;
                document.querySelector('form').appendChild(hiddenField);
            }
            
            // Add input validation
            const input = row.querySelector(`input[name="${fieldName}"]`);
            if (input && field.spec) {
                input.addEventListener('input', function() {
                    validateInput(this, field.spec, document.getElementById(`status-${fieldName}`), fieldName);
                });
                
                // Trigger validation if there's an existing value
                if (existingValue) {
                    input.dispatchEvent(new Event('input'));
                }
            }
        });
    }
}



function validateInput(inputElement, specification, statusCell, field) {
    if (!inputElement || !statusCell) return;
    
    const value = inputElement.value.trim();
    
    // Skip validation if input is empty
    if (!value) {
        statusCell.textContent = '--';
        // Clear status field if it exists
        const statusField = document.getElementById(`${field}_status`);
        if (statusField) statusField.value = '';
        return;
    }
    
    // Try to parse as float if possible
    const numValue = parseFloat(value);
    const isNumeric = !isNaN(numValue);
    
    // Initialize result
    let isPassed = false;
    
    // Validate according to specification format
    if (specification && specification.includes('≥')) {
    if (isNumeric) {
        const min = parseFloat(specification.replace(/[^0-9.]/g, ''));
        isPassed = numValue >= min;
    }
} else if (specification && specification.includes('≤')) {
    if (isNumeric) {
        const max = parseFloat(specification.replace(/[^0-9.]/g, ''));
        isPassed = numValue <= max;
    }
} else if (specification && specification.includes('<')) {
    if (isNumeric) {
        const max = parseFloat(specification.replace(/[^0-9.]/g, ''));
        isPassed = numValue < max;
    }
} else if (specification && specification.includes('>')) {
    if (isNumeric) {
        const min = parseFloat(specification.replace(/[^0-9.]/g, ''));
        isPassed = numValue > min;
    }
} else if (specification && specification.includes('Max')) {
    if (isNumeric) {
        const max = parseFloat(specification.replace(/[^0-9.]/g, ''));
        isPassed = numValue <= max;
    }
} else if (specification && specification.includes('±')) {
    if (isNumeric) {
        const parts = specification.split('±');
        const base = parseFloat(parts[0].replace(/[^0-9.]/g, ''));
        const tolerance = parseFloat(parts[1].replace(/[^0-9.]/g, ''));
        const min = base - tolerance;
        const max = base + tolerance;
        isPassed = numValue >= min && numValue <= max;
    }
} else if (specification && specification.includes('-') && !specification.includes('±')) {
    if (isNumeric) {
        const parts = specification.split('-');
        const min = parseFloat(parts[0].replace(/[^0-9.]/g, ''));
        const max = parseFloat(parts[1].replace(/[^0-9.]/g, ''));
        isPassed = numValue >= min && numValue <= max;
    }
} else if (isNumeric && !isNaN(parseFloat(specification))) {
    // angka eksak
    const exact = parseFloat(specification.replace(/[^0-9.]/g, ''));
    isPassed = numValue === exact;
} else {
    // Text-based match (e.g. "Clear Liquid")
    isPassed = value.toLowerCase() === specification.toLowerCase();
}
    
    // Update the validation notification with field name
    updateNotification(isPassed, statusCell, field);
}

function updateNotification(isPassed, statusCell, field) {
    if (!statusCell) return;
    
    // Create or update the hidden status field
    let statusField = document.getElementById(`${field}_status`);
    if (!statusField) {
        statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.id = `${field}_status`;
        statusField.name = `${field}_status`;
        document.querySelector('form').appendChild(statusField);
    }
    
    // Update the status value
    statusField.value = isPassed ? 'Passed' : 'Not Passed';
    
    // Update the visual indicator
    if (isPassed) {
        statusCell.innerHTML = `
            <div class="validation-success">
                ✓ Passed
            </div>
        `;
    } else {
        statusCell.innerHTML = `
            <div class="validation-error">
                ✗ Not Passed
            </div>
        `;
    }
}

// Initialize the form when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Set date and time if needed
    if (!document.getElementById('tgl').value) {
        const today = new Date();
        document.getElementById('tgl').value = today.toISOString().split('T')[0];
    }
    
    if (!document.getElementById('jam_masuk').value) {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('jam_masuk').value = `${hours}:${minutes}`;
    }

    // Initialize with existing data in edit mode
    if (existingRawMat) {
        const rawmatSelect = document.getElementById('nama_rawmat');
        if (rawmatSelect) {
            updateNamaRawMat(existingRawMat.nama_rawmat, existingRawMat.nama);
            updateDetailTable(existingRawMat.nama_rawmat, existingRawMat.nama);
        }
    }
    // Otherwise initialize from selection if available
    else {
        const selectTransaksi = document.getElementById('select_transaksi');
        if (selectTransaksi && selectTransaksi.options.length > 1) {
            selectTransaksi.dispatchEvent(new Event('change'));
        }
    }
});
</script>
@endsection