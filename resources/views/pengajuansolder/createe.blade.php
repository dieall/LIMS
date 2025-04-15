@extends('layouts.app')

@section('contents')

<style>
    /* Gaya dasar untuk kotak validasi */
    .validation-box {
        position: relative;
        display: block;
        width: 100%;
        margin-top: 5px;
    }

    /* Kotak sukses */
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

    /* Kotak error */
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

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data | Pengajuan Solder</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('pengajuansolder.update', $pengajuansolder->id) }}" method="POST" enctype="multipart/form-data" id="solderForm">
            @csrf
            @method('PUT')
            
            <!-- Hidden status fields for DB storage -->
            <div style="display: none;">
                <!-- Status fields for each element -->
                <input type="hidden" name="sn_status" id="sn_status" value="{{ $pengajuansolder->sn_status ?? '' }}">
                <input type="hidden" name="ag_status" id="ag_status" value="{{ $pengajuansolder->ag_status ?? '' }}">
                <input type="hidden" name="cu_status" id="cu_status" value="{{ $pengajuansolder->cu_status ?? '' }}">
                <input type="hidden" name="pb_status" id="pb_status" value="{{ $pengajuansolder->pb_status ?? '' }}">
                <input type="hidden" name="sb_status" id="sb_status" value="{{ $pengajuansolder->sb_status ?? '' }}">
                <input type="hidden" name="zn_status" id="zn_status" value="{{ $pengajuansolder->zn_status ?? '' }}">
                <input type="hidden" name="fe_status" id="fe_status" value="{{ $pengajuansolder->fe_status ?? '' }}">
                <input type="hidden" name="as_status" id="as_status" value="{{ $pengajuansolder->as_status ?? '' }}">
                <input type="hidden" name="ni_status" id="ni_status" value="{{ $pengajuansolder->ni_status ?? '' }}">
                <input type="hidden" name="bi_status" id="bi_status" value="{{ $pengajuansolder->bi_status ?? '' }}">
                <input type="hidden" name="cd_status" id="cd_status" value="{{ $pengajuansolder->cd_status ?? '' }}">
                <input type="hidden" name="ai_status" id="ai_status" value="{{ $pengajuansolder->ai_status ?? '' }}">
                <input type="hidden" name="pe_status" id="pe_status" value="{{ $pengajuansolder->pe_status ?? '' }}">
                <input type="hidden" name="ga_status" id="ga_status" value="{{ $pengajuansolder->ga_status ?? '' }}">
            </div>
            
            <!-- Tanggal -->
            <div class="mb-3" style="display: none;">
                <label for="tgl" class="form-label">Tanggal</label>
                <input type="date" name="tgl" class="form-control" id="tgl" required readonly>
            </div>
            
            <div class="row">
                <!-- Kategori -->
                <div class="col-md-6 mb-3">
                    <label for="id_category" class="form-label">Kategori</label>
                    <select class="form-control select2" name="id_category" id="id_category" required>
                        <option disabled selected value="">Pilih Kategori</option>
                        @foreach ($categorysolder as $rs)
                            <option value="{{ $rs->id_category }}" 
                                @if($rs->id_category == $pengajuansolder->id_category) selected @endif>
                                {{ $rs->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Hidden Status Field -->
                <div class="col-md-6 mb-3" style="display: none;">
                    <label for="status" class="form-label">Status</label>
                    <input 
                        type="text" 
                        name="status" 
                        class="form-control 
                            {{ $pengajuansolder->status == 'Pengajuan' ? 'bg-primary text-white' : '' }} 
                            {{ $pengajuansolder->status == 'Proses Analisa' ? 'bg-info text-dark' : '' }} 
                            {{ $pengajuansolder->status == 'Selesai Analisa' ? 'bg-secondary text-white' : '' }} 
                            {{ $pengajuansolder->status == 'Review Hasil' ? 'bg-warning text-dark' : '' }} 
                            {{ $pengajuansolder->status == 'Approve' ? 'bg-success text-white' : '' }}" 
                        id="status" 
                        value="{{ $pengajuansolder->status }}" 
                        readonly>
                </div>
                
                <!-- Tipe Solder -->
                <div class="col-md-6 mb-3">
                    <label for="tipe_solder" class="form-label">Tipe Solder</label>
                    <select name="tipe_solder" class="form-control select2" id="tipe_solder" required>
                        <option value="{{ $pengajuansolder->tipe_solder }}">{{ $pengajuansolder->tipe_solder }}</option>
                        @foreach($tipesolder as $ts)
                            @if($ts->tipe_solder != $pengajuansolder->tipe_solder)
                                <option value="{{ $ts->tipe_solder }}">{{ $ts->tipe_solder }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Batch / Lot & Name Row -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="batch" class="form-label">Batch / Lot</label>
                    <input type="text" name="batch" class="form-control" id="batch" placeholder="Masukkan batch" value="{{ $pengajuansolder->batch }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama MecL" value="{{ Auth::user()->name }}" required readonly>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Masukkan deskripsi" required>{{ $pengajuansolder->deskripsi }}</textarea>
                </div>
            </div>

            <!-- Hidden Fields -->
            <div style="display: none;">
                <input type="text" name="previous_status" id="previous_status" value="{{ $pengajuansolder->status }}">
                <input type="text" name="previous_jam_masuk" id="previous_jam_masuk" value="{{ now()->format('H:i') }}">
                <input type="text" name="audit_trail" class="form-control" id="audit_trail" required readonly>
                <input type="time" name="jam_masuk" class="form-control" id="jam_masuk" required readonly>
            </div>

            <!-- Hidden Detail Data Table -->
            <div class="mb-1" id="dataTableContainer" style="display: none; text-align: center;">
                <h5 class="mb-3">Detail Data Tipe Solder</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered shadow-sm mx-auto" style="width: 100%;">
                        <thead class="thead-dark">
                            <tr>
                                <th>Spesifikasi</th>
                                <th>Sn</th>
                                <th>Ag</th>
                                <th>Cu</th>
                                <th>Pb</th>
                                <th>Zn</th>
                                <th>Fe</th>
                                <th>As</th>
                                <th>Ni</th>
                                <th>Bi</th>
                                <th>Cd</th>
                                <th>Al</th>
                                <th>P</th>
                                <th>Ga</th>
                            </tr>
                        </thead>
                        <tbody id="dataTableBody">
                            <!-- Data akan diisi melalui JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Main Data Input Table -->
            <table class="table table-bordered table-striped table-hover" id="data-table">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">Nama Unsur</th>
                        <th class="text-center">Spesifikasi</th>
                        <th class="text-center">Isi Kolom</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sn</td>
                        <td>-</td>
                        <td><input type="text" step="any" name="sn" class="form-control" id="sn" placeholder="Sn" value="{{ $pengajuansolder->sn }}"></td>
                        <td class="status" id="sn-status">
                            @if($pengajuansolder->sn_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->sn_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Ag</td>
                        <td>-</td>
                        <td><input type="number" step="any" name="ag" class="form-control element" id="ag" placeholder="Ag" value="{{ $pengajuansolder->ag }}"></td>
                        <td class="status" id="ag-status">
                            @if($pengajuansolder->ag_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->ag_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Cu</td>
                        <td>-</td>
                        <td><input type="number" step="any" name="cu" class="form-control element" id="cu" placeholder="Cu" value="{{ $pengajuansolder->cu }}"></td>
                        <td class="status" id="cu-status">
                            @if($pengajuansolder->cu_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->cu_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Pb</td>
                        <td>-</td>
                        <td><input type="text" step="any" name="pb" class="form-control element" id="pb" placeholder="Pb" value="{{ $pengajuansolder->pb }}"></td>
                        <td class="status" id="pb-status">
                            @if($pengajuansolder->pb_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->pb_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Sb</td>
                        <td>-</td>
                        <td><input type="number" step="any" name="sb" class="form-control element" id="sb" placeholder="Sb" value="{{ $pengajuansolder->sb }}"></td>
                        <td class="status" id="sb-status">
                            @if($pengajuansolder->sb_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->sb_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Zn</td>
                        <td>-</td>
                        <td><input type="number" step="any" name="zn" class="form-control element" id="zn" placeholder="Zn" value="{{ $pengajuansolder->zn }}"></td>
                        <td class="status" id="zn-status">
                            @if($pengajuansolder->zn_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->zn_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Fe</td>
                        <td>-</td>
                        <td><input type="number" step="any" name="fe" class="form-control element" id="fe" placeholder="Fe" value="{{ $pengajuansolder->fe }}"></td>
                        <td class="status" id="fe-status">
                            @if($pengajuansolder->fe_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->fe_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>As</td>
                        <td>-</td>
                        <td><input type="number" step="any" name="as" class="form-control element" id="as" placeholder="As" value="{{ $pengajuansolder->as }}"></td>
                        <td class="status" id="as-status">
                            @if($pengajuansolder->as_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->as_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Ni</td>
                        <td>-</td>
                        <td><input type="number" step="any" name="ni" class="form-control element" id="ni" placeholder="Ni" value="{{ $pengajuansolder->ni }}"></td>
                        <td class="status" id="ni-status">
                            @if($pengajuansolder->ni_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->ni_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Bi</td>
                        <td>-</td>
                        <td><input type="number" step="any" name="bi" class="form-control element" id="bi" placeholder="Bi" value="{{ $pengajuansolder->bi }}"></td>
                        <td class="status" id="bi-status">
                            @if($pengajuansolder->bi_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->bi_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Cd</td>
                        <td>-</td>
                        <td><input type="number" step="any" name="cd" class="form-control element" id="cd" placeholder="Cd" value="{{ $pengajuansolder->cd }}"></td>
                        <td class="status" id="cd-status">
                            @if($pengajuansolder->cd_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->cd_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Ai</td>
                        <td>-</td>
                        <td><input type="number" step="any" name="ai" class="form-control element" id="ai" placeholder="Ai" value="{{ $pengajuansolder->ai }}"></td>
                        <td class="status" id="ai-status">
                            @if($pengajuansolder->ai_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->ai_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Pe</td>
                        <td>-</td>
                        <td><input type="number" step="any" name="pe" class="form-control element" id="pe" placeholder="Pe" value="{{ $pengajuansolder->pe }}"></td>
                        <td class="status" id="pe-status">
                            @if($pengajuansolder->pe_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->pe_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Ga</td>
                        <td>-</td>
                        <td><input type="number" step="any" name="ga" class="form-control element" id="ga" placeholder="Ga" value="{{ $pengajuansolder->ga }}"></td>
                        <td class="status" id="ga-status">
                            @if($pengajuansolder->ga_status == 'Passed')
                                <div class="validation-success">✅ <strong>Passed</strong></div>
                            @elseif($pengajuansolder->ga_status == 'Not Passed')
                                <div class="validation-error">❌ <strong>Not Passed</strong></div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <a href="{{ route('pengajuansolder.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Set today's date in the 'tgl' input field
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tgl').value = today;

    // Set the audit trail
    const user = '{{ Auth::user()->name }}';
    const timestamp = new Date().toLocaleString();
    document.getElementById('audit_trail').value = 'Updated by: ' + user + ' at ' + timestamp;

    // Set the current time for the 'jam_masuk' field
    const jamMasukInput = document.getElementById('jam_masuk');
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    jamMasukInput.value = hours + ':' + minutes;

    // Data tipe solder
    const tipeSampelData = {
        '1': {!! json_encode($datasolder1->toArray() ?? []) !!},
        '2': {!! json_encode($datasolder2->toArray() ?? []) !!},
        '3': {!! json_encode($datasolder3->toArray() ?? []) !!},
        '4': {!! json_encode($datasolder4->toArray() ?? []) !!}
    };

    // Get the selected tipe_solder from $pengajuan (server-side data)
    const selectedTipeSolder = '{{ $pengajuansolder->tipe_solder }}'; 

    // Find the spesifikasi data based on the selected tipe_solder
    let spesifikasi = null;
    for (let categoryId in tipeSampelData) {
        let matchedTipe = tipeSampelData[categoryId].find(tipe => tipe.tipe_solder === selectedTipeSolder);
        if (matchedTipe) {
            spesifikasi = matchedTipe;
            break;  // Stop once we find the matching tipe_solder
        }
    }

    if (spesifikasi) {
        // Fill the specification columns based on the selected tipe_solder
        const fields = ['sn', 'ag', 'cu', 'pb', 'sb', 'zn', 'fe', 'as', 'ni', 'bi', 'cd', 'ai', 'pe', 'ga'];
        fields.forEach((field, index) => {
            const row = document.querySelector(`#data-table tbody tr:nth-child(${index + 1}) td:nth-child(2)`);
            if (row) {
                row.textContent = spesifikasi[field] || '-';
            }
        });

        // Store the specification data for validation
        window.currentSpesifikasi = spesifikasi;
        
        // Add input event listeners to all input fields
        fields.forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                // Add event listener for validation on input
                input.addEventListener('input', function() {
                    validateField(this, field);
                });
            }
        });
    } else {
        console.warn('Spesifikasi untuk tipe solder ini tidak ditemukan.');
    }
});

/**
 * Validates an input field against specifications and updates status
 * @param {HTMLElement} inputElement - The input element to validate
 * @param {string} fieldName - Field name (sn, ag, etc.)
 */
function validateField(inputElement, fieldName) {
    // Get the value and specifications
    const value = parseFloat(inputElement.value);
    const spesifikasi = window.currentSpesifikasi;
    
    if (!spesifikasi) return;
    
    const spesifikasiText = spesifikasi[fieldName];
    const statusCell = document.getElementById(`${fieldName}-status`);
    const statusField = document.getElementById(`${fieldName}_status`);
    
    // If there's no input value or no specification, don't show validation
    if (isNaN(value) || !spesifikasiText) {
        statusCell.innerHTML = '--';
        if (statusField) statusField.value = '';
        return;
    }
    
    // Validate based on specification format
    let isPassed = false;
    
    if (spesifikasiText.includes('<')) {
        // Format: "<0.1000"
        const max = parseFloat(spesifikasiText.replace('<', '').trim());
        isPassed = value < max;
    } else if (spesifikasiText.includes('-') || spesifikasiText.includes('~')) {
        // Format: "0.5-0.6" or "0.5~0.6"
        const delimiter = spesifikasiText.includes('-') ? '-' : '~';
        const [min, max] = spesifikasiText.split(delimiter).map(val => parseFloat(val.trim()));
        isPassed = value >= min && value <= max;
    } else if (spesifikasiText.includes('±')) {
        // Format: "2.9±0.05"
        const [patokan, toleransi] = spesifikasiText.split('±').map(val => parseFloat(val.trim()));
        const min = parseFloat((patokan - toleransi).toFixed(5));
        const max = parseFloat((patokan + toleransi).toFixed(5));
        isPassed = value >= min && value <= max;
    } else {
        // For formats we don't recognize
        statusCell.innerHTML = '--';
        if (statusField) statusField.value = '';
        return;
    }
    
    // Update the status cell and hidden field
    updateNotification(isPassed, statusCell, statusField);
}

/**
 * Updates the notification display for validation results
 * @param {boolean} isPassed - Whether validation passed
 * @param {HTMLElement} statusCell - The cell where status should be displayed
 * @param {HTMLElement} statusField - The hidden input field to store status
 */
function updateNotification(isPassed, statusCell, statusField) {
    if (isPassed) {
        statusCell.innerHTML = `
            <div class="validation-success">
                ✅ <strong>Passed</strong> 
            </div>
        `;
        // Update hidden field
        if (statusField) statusField.value = 'Passed';
    } else {
        statusCell.innerHTML = `
            <div class="validation-error">
                ❌ <strong>Not Passed</strong>
            </div>
        `;
        // Update hidden field
        if (statusField) statusField.value = 'Not Passed';
    }
}

/**
 * Calculate the balance for Sn based on the total of other elements.
 */
function calculateSnBalance() {
    const elements = document.querySelectorAll('.element');
    let total = 0;

    // Sum up all element values
    elements.forEach((element) => {
        const value = parseFloat(element.value) || 0;
        total += value;
    });

    // Calculate the balance for Sn
    const balance = (100 - total).toFixed(2);

    // Update the Sn input field
    const snInput = document.getElementById('sn');
    if (snInput) {
        snInput.value = balance;

        // Validate the Sn field
        validateField(snInput, 'sn');
    }
}

// Attach the Sn balance calculation to all element inputs
document.querySelectorAll('.element').forEach((input) => {
    input.addEventListener('input', calculateSnBalance);
}); 

// Run initial validation for all fields that have values
document.addEventListener('DOMContentLoaded', function() {
    const fields = ['sn', 'ag', 'cu', 'pb', 'sb', 'zn', 'fe', 'as', 'ni', 'bi', 'cd', 'ai', 'pe', 'ga'];
    fields.forEach(field => {
        const input = document.getElementById(field);
        if (input && input.value) {
            validateField(input, field);
        }
    });
    
    // Initial calculation of Sn balance
    calculateSnBalance();
});
</script>

@endsection
