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
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data | Pengajuan Chemical</h6>
    </div>

    <div class="card-body">
    <form action="{{ isset($pengajuanchemical) ? route('pengajuanchemical.update', $pengajuanchemical->id) : route('pengajuanchemical.store') }}" method="POST">
    @csrf
    @if(isset($pengajuanchemical))
        @method('PUT')
    @endif
    <!-- Form fields here -->
            
            <div class="card-body">
<div class="mb-3">
    <label for="select_transaksi" class="form-label">
        <i class="fas fa-exchange-alt"></i> Pilih Data Pengajuan Sampel Hari Ini
        <span class="badge bg-info">{{ Carbon\Carbon::now()->format('d M Y') }}</span>
    </label>
    <select class="form-control stylish-select" name="select_transaksi" id="select_transaksi" required>
        <option disabled selected value="">Pengajuan Sampel Hari Ini</option>
        @forelse($transaksi as $trx)
            <option value="{{ $trx->id }}"
                data-nama="{{ $trx->nama }}"
                data-nama_chemical="{{ $trx->nama_chemical }}"
                data-orang="{{ $trx->orang }}"
                data-batch="{{ $trx->batch }}"
                data-desc="{{ $trx->desc }}"
                data-created_at="{{ $trx->created_at }}"
                {{ isset($pengajuanchemical) && $pengajuanchemical->id == $trx->id ? 'selected' : '' }}>
                ⌚ {{ Carbon\Carbon::parse($trx->created_at)->format('H:i') }} | 🏷️ {{ $trx->nama_chemical }} | 🧪 {{ $trx->nama }} | 👤 {{ $trx->orang }}
            </option>
        @empty
            <option disabled>Tidak ada pengajuan sampel hari ini</option>
        @endforelse
    </select>
</div>



                <div id="transaksi-details" class="mt-3" style="display:none;">
                    <h5>Detail Pengajuan Sampel</h5>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Chemical</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td id="detail-tgl"></td>
                                <td id="detail-nama_chemical"></td>
                                <td id="detail-nama"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_chemical" class="form-label">Chemical</label>
                        <select class="form-control select2" name="nama_chemical" id="id_chemical" required>
                            <option disabled selected value="">Nama Chemical</option>
                            @foreach ($transaksi as $rs)
                                <option value="{{ $rs->nama_chemical }}" {{ isset($pengajuanchemical) && $pengajuanchemical->nama_chemical == $rs->nama_chemical ? 'selected' : '' }}>
                                    {{ $rs->nama_chemical }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama Sampel</label>
                        <select name="nama" class="form-control select2" id="nama" required>
                            <option disabled selected value="">Nama Sampel</option>
                            @if(isset($pengajuanchemical))
                                <option value="{{ $pengajuanchemical->nama }}" selected>{{ $pengajuanchemical->nama }}</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="row">
    <div class="col-md-6 mb-3">
        <label for="tgl" class="form-label">Tanggal</label>
        <input type="date" name="tgl" class="form-control" id="tgl" value="{{ isset($pengajuanchemical) ? $pengajuanchemical->tgl : '' }}" required>
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="orang" class="form-label">Orang</label>
        <input type="text" name="orang" class="form-control" id="orang" value="{{ isset($pengajuanchemical) ? $pengajuanchemical->orang : Auth::user()->name ?? 'Default User' }}" required readonly>
    </div>
</div>
<input type="hidden" name="jam_masuk" id="jam_masuk" value="{{ isset($pengajuanchemical) ? date('H:i', strtotime($pengajuanchemical->jam_masuk)) : '' }}">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="batch" class="form-label">Batch</label>
                        <input type="text" name="batch" class="form-control" id="batch" placeholder="Batch" 
                               value="{{ isset($pengajuanchemical) ? $pengajuanchemical->batch : '' }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="desc" class="form-label">Deskripsi</label>
                        <input type="text" name="desc" class="form-control" id="desc" placeholder="Deskripsi" 
                               value="{{ isset($pengajuanchemical) ? $pengajuanchemical->desc : '' }}" required>
                    </div>
                </div>

                <div class="row mt-4" id="detailTableContainer" style="display: block;">
                    <div class="col-md-12">
                        <h5 class="mb-3">Detail Data</h5>
                        <table class="table table-striped table-bordered" id="detailTable">
                            <thead>
                                <tr>
                                    <th>Nama Unsur</th>
                                    <th>Spesifikasi</th>
                                    <th>Isi Kolom</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($pengajuanchemical) ? 'Update' : 'Simpan' }}</button>
            </div>
        </form>
    </div>
</div>

<script>
// Data from backend
const tipeSampelData = {
    'DMT': {!! json_encode($datasolder1->toArray() ?? []) !!},
    'Tinstab': {!! json_encode($datasolder2->toArray() ?? []) !!},
    'Tinchem': {!! json_encode($datasolder3->toArray() ?? []) !!},
    'DMTDCL-515': {!! json_encode($datasolder4->toArray() ?? []) !!},
    'datachemical': {!! json_encode($datachemical->toArray() ?? []) !!}
};

// Store all chemical specifications from database
const allChemicalSpecs = {!! json_encode($all_chemical_specs ?? []) !!};

// Existing chemical data if in edit mode
const existingChemical = {!! isset($pengajuanchemical) ? json_encode($pengajuanchemical) : 'null' !!};

// Field display names mapping
const fieldDisplayNames = {
    'clarity': 'Clarity',
    'transmission': '% Transmission',
    'ape': 'Appearance',
    'dimet': 'Dimethyltin Dichloride',
    'trime': 'Trimethyltin Monochloride',
    'tin': '% Tin',
    'solid': '% Solid Content',
    'ri': 'RI @ 25°C',
    'sg': 'SG @ 25°C',
    'acid': 'Acid Value',
    'sulfur': '% Sulfur',
    'water': 'Water Content',
    'mono': 'Monomethyltin',
    'yellow': 'Yellowish Index',
    'eh': '2-EH',
    'visco': 'Viscosity @ 25°C',
    'pt': 'Pt-Co',
    'moisture': 'Moisture Content',
    'cloride': '% Chloride',
    'spec': 'Specific Gravity (25°C)',
    'cla': 'Clarity',
    'densi': 'Density'
};

// Handle transaction selection change - FIXED THE BACKTICK ISSUE
document.getElementById('select_transaksi')?.addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];

    if (selectedOption.value) {
        const nama = selectedOption.getAttribute('data-nama');
        const nama_chemical = selectedOption.getAttribute('data-nama_chemical');
        const createdAt = selectedOption.getAttribute('data-created_at');
        const batch = selectedOption.getAttribute('data-batch');
        const deskripsi = selectedOption.getAttribute('data-desc');
        const orang = selectedOption.getAttribute('data-orang');

        document.getElementById('transaksi-details').style.display = 'block';
        document.getElementById('detail-tgl').innerText = createdAt || '-';
        document.getElementById('detail-nama_chemical').innerText = nama_chemical || '-';
        document.getElementById('detail-nama').innerText = nama || '-';

        const idChemicalSelect = document.getElementById('id_chemical');
        const namaSelect = document.getElementById('nama');
        const batchInput = document.getElementById('batch');
        const descInput = document.getElementById('desc');
        const orangInput = document.getElementById('orang');
        const tglInput = document.getElementById('tgl');
        
        if (idChemicalSelect) idChemicalSelect.value = nama_chemical;
        if (batchInput) batchInput.value = batch || '';
        if (descInput) descInput.value = deskripsi || '';
        if (orangInput) orangInput.value = orang || '';
        if (tglInput) tglInput.value = createdAt ? createdAt.split(' ')[0] : '';

        updateNamaChemical(nama_chemical, nama);
        updateDetailTable(nama_chemical, nama);
    }
});

function updateNamaChemical(nama_chemical, selectedNama = null) {
    const namaSelect = document.getElementById('nama');
    if (!namaSelect) return;
    
    namaSelect.innerHTML = '';
    
    // Add default option
    const defaultOption = document.createElement('option');
    defaultOption.value = "";
    defaultOption.textContent = "Nama Sampel";
    defaultOption.disabled = true;
    defaultOption.selected = !selectedNama;
    namaSelect.appendChild(defaultOption);
    
    if (nama_chemical && tipeSampelData[nama_chemical]) {
        tipeSampelData[nama_chemical].forEach(function (item) {
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
document.getElementById('nama')?.addEventListener('change', function() {
    const selectedNama = this.value;
    const nama_chemical = document.getElementById('id_chemical')?.value || '';
    updateDetailTable(nama_chemical, selectedNama);
});

function updateDetailTable(nama_chemical, selectedNama = null) {
    const detailTableBody = document.getElementById('detailTable')?.querySelector('tbody');
    if (!detailTableBody) return;
    
    detailTableBody.innerHTML = ''; // Clear the table
    
    // First, try to find the chemical specification by exact name match
    let chemicalSpec = null;
    
    if (selectedNama) {
        chemicalSpec = allChemicalSpecs.find(spec => spec && spec.nama === selectedNama);
    }
    
    // If we didn't find a spec by name, try to find by category
    if (!chemicalSpec && nama_chemical) {
        chemicalSpec = allChemicalSpecs.find(spec => spec && spec.nama_chemical === nama_chemical);
    }
    
    if (chemicalSpec) {
        // List all possible chemical fields
        const fieldList = [
            'clarity', 'transmission', 'ape', 'dimet', 'trime', 'tin', 'solid', 
            'ri', 'sg', 'acid', 'sulfur', 'water', 'mono', 'yellow', 'eh', 
            'visco', 'pt', 'moisture', 'cloride', 'spec', 'cla', 'densi'
        ];
        
        // Only display fields that have values in the database
        fieldList.forEach(field => {
            if (chemicalSpec[field] && chemicalSpec[field].toString().trim() !== '') {
                const row = document.createElement('tr');
                
                // Get existing value if we're in edit mode
                const existingValue = existingChemical && existingChemical[field] ? existingChemical[field] : '';
                
                // Get existing status if available
                const statusField = field + '_status';
                const existingStatus = existingChemical && existingChemical[statusField] ? existingChemical[statusField] : '';
                
                row.innerHTML = `
                    <td>${fieldDisplayNames[field] || field}</td>
                    <td>${chemicalSpec[field]}</td>
                    <td><input type="text" name="fields[${field}]" class="form-control" 
                         value="${existingValue}" placeholder="Isi nilai"></td>
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
                const input = row.querySelector(`input[name="fields[${field}]"]`);
                if (input) {
                    input.addEventListener('input', function() {
                        validateInput(this, chemicalSpec[field], document.getElementById(`status-${field}`), field);
                    });
                    
                    // Trigger validation if there's an existing value
                    if (existingValue) {
                        input.dispatchEvent(new Event('input'));
                    }
                }
            }
        });
    } else {
        // If no chemical spec found, use the original behavior with datachemical
        const dataChemical = tipeSampelData['datachemical'].filter(item => item.nama_chemical === nama_chemical);
        
        dataChemical.forEach((item, index) => {
            // Only add rows if nama_unsur is not empty
            if (item.nama_unsur && item.nama_unsur.trim() !== '') {
                const row = document.createElement('tr');
                
                // Get existing value if we're in edit mode
                const existingValue = existingChemical && existingChemical.isi_kolom ? 
                    existingChemical.isi_kolom.split(',')[index] || '' : '';
                
                // Field ID for status tracking
                const fieldId = `chemical_${index}`;
                
                // Get existing status if available
                const statusField = fieldId + '_status';
                const existingStatus = existingChemical && existingChemical[statusField] ? existingChemical[statusField] : '';
                
                row.innerHTML = `
                    <td>${item.nama_unsur}</td>
                    <td>${item.spesifikasi || '-'}</td>
                    <td><input type="text" name="isi_kolom[${index}]" class="form-control" value="${existingValue}"></td>
                    <td id="status-${fieldId}">
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
                    hiddenField.id = `${fieldId}_status`;
                    hiddenField.name = `${fieldId}_status`;
                    hiddenField.value = existingStatus;
                    document.querySelector('form').appendChild(hiddenField);
                }
                
                // Add input validation
                const input = row.querySelector(`input[name="isi_kolom[${index}]"]`);
                if (input) {
                    input.addEventListener('input', function() {
                        validateInput(this, item.spesifikasi, document.getElementById(`status-${fieldId}`), fieldId);
                    });
                    
                    // Trigger validation if there's an existing value
                    if (existingValue) {
                        input.dispatchEvent(new Event('input'));
                    }
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
    if (specification && specification.includes('<')) {
        if (isNumeric) {
            const max = parseFloat(specification.replace(/[^0-9.]/g, ''));
            isPassed = numValue < max;
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
    } else if (specification && specification.includes('>')) {
        if (isNumeric) {
            const min = parseFloat(specification.replace(/[^0-9.]/g, ''));
            isPassed = numValue > min;
        }
    } else {
        // For text-based specifications, assume it's valid
        isPassed = true;
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
    if (existingChemical) {
        const idChemicalSelect = document.getElementById('id_chemical');
        if (idChemicalSelect) {
            updateNamaChemical(existingChemical.nama_chemical, existingChemical.nama);
            updateDetailTable(existingChemical.nama_chemical, existingChemical.nama);
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
