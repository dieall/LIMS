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
    background-color: #d4edda; /* Hijau muda */
    color: #155724; /* Hijau gelap */
    border: 2px solid #c3e6cb; /* Border hijau terang */
    border-radius: 8px;
    padding: 10px;
    font-size: 14px;
    font-weight: bold;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Kotak error */
.validation-error {
    background-color: #f8d7da; /* Merah muda */
    color: #721c24; /* Merah gelap */
    border: 2px solid #f5c6cb; /* Border merah terang */
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
        <form action="{{ route('pengajuanchemical.store') }}" method="POST">
            @csrf
            <div class="card-body">
        <!-- Dropdown Pilih Data -->
        <div class="mb-3">
    <label for="select_transaksi" class="form-label">
        <i class="fas fa-exchange-alt"></i> Pilih Data Pengajuan Sampel Hari Ini
    </label>
    <select class="form-control stylish-select" name="select_transaksi" id="select_transaksi" required>
        <option disabled selected value="">Pengajuan Sampel Hari Ini</option>
        @foreach($transaksi as $trx)
            <option value="{{ $trx->id }}"
                    data-nama="{{ $trx->nama }}"
                    data-kategori="{{ $trx->kategori }}"
                    data-orang="{{ $trx->orang }}"
                    data-batch="{{ $trx->batch }}"
                    data-desc="{{ $trx->desc }}"
                    data-created_at="{{ $trx->created_at }}">
                📅 {{ $trx->created_at }} | 🏷️ {{ $trx->kategori }} | 🧪 {{ $trx->nama }} | 👤 {{ $trx->orang }}  
            </option>
        @endforeach
    </select>
</div>
        <!-- Detail Pengajuan Sampel -->
        <div id="transaksi-details" class="mt-3" style="display:none;">
            <h5>Detail Pengajuan Sampel</h5>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Kategori</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td id="detail-tgl"></td>
                        <td id="detail-nama_kategori"></td>
                        <td id="detail-nama"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
            <!-- Form Inputs -->
            <div class="row">
                <!-- Kategori -->
                <div class="col-md-6 mb-3">
                    <label for="id_chemical" class="form-label">Kategori</label>
                    <select class="form-control select2" name="nama_chemical" id="id_chemical" required readonly>
                        <option disabled selected value="">Nama Kategori</option>
                        @foreach ($datachemical as $rs)
                            <option value="{{ $rs->kategori }}">{{ $rs->kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama -->
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label">Nama Sampel</label>
                    <select name="nama" class="form-control select2" id="nama" required readonly>

                        <option disabled selected value="">Nama Sampel</option>
                    </select>
                </div>
            </div>

            <div class="row">
            <!-- Tanggal -->
            <div class="col-md-6 mb-3" style="display: none;">
                <label for="tgl" class="form-label">Tanggal</label>
                <input type="date" name="tgl" class="form-control" id="tgl" placeholder="Tanggal" required readonly>
            </div>

                <!-- Jam Masuk -->
                <div class="form-group mb-3" style="display: none;">
                    <label for="orang">Orang</label>
                    <input type="text" class="form-control" id="orang" name="orang" readonly>
                </div>
  
                <div class="col-md-6 mb-3" style="display: none;">
                    <label for="jam_masuk" class="form-label">Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="form-control" id="jam_masuk" placeholder="Jam Masuk" required readonly>
                </div>
            </div>

            <div class="row">
                <!-- Batch -->
                <div class="col-md-6 mb-3">
                <label for="batch" class="form-label">Batch</label>
                <input type="text" name="batch" class="form-control" id="batch" placeholder="Batch" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="desc" class="form-label">Deskripsi</label>
                <input type="text" name="desc" class="form-control" id="desc" placeholder="Deskripsi" required>
            </div>
            </div>

     
            <tr>
        <td hidden>
            <input type="hidden" name="status" id="status" value="">
        </td>
    </tr>

        

            <!-- Tabel Detail Data -->
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

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<script>
    // Data dari backend
    const tipeSampelData = {
        'DMT': {!! json_encode($datasolder1->toArray() ?? []) !!},
        'Tinstab': {!! json_encode($datasolder2->toArray() ?? []) !!},
        'Tinchem': {!! json_encode($datasolder3->toArray() ?? []) !!},
    };

    // Inisialisasi Select2
    $(document).ready(function() {
        $('.select2').select2();
    });

    document.getElementById('select_transaksi').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];

        if (selectedOption.value) {
            // Ambil atribut dari option yang dipilih
            const nama = selectedOption.getAttribute('data-nama');
            const kategori = selectedOption.getAttribute('data-kategori');
            const createdAt = selectedOption.getAttribute('data-created_at');
            const batch = selectedOption.getAttribute('data-batch');
            const deskripsi = selectedOption.getAttribute('data-desc');

            // Tampilkan detail transaksi
            document.getElementById('transaksi-details').style.display = 'block';
            document.getElementById('detail-tgl').innerText = createdAt || '-';
            document.getElementById('detail-nama_kategori').innerText = kategori || '-';
            document.getElementById('detail-nama').innerText = nama || '-';

            // Isi input "Kategori", "Nama Sampel", "Batch", dan "Deskripsi" secara otomatis
            const idChemicalSelect = document.getElementById('id_chemical');
            const namaSelect = document.getElementById('nama');
            const batchInput = document.getElementById('batch');
            const descInput = document.getElementById('desc');

            // Set nilai dropdown "Kategori"    
            for (let i = 0; i < idChemicalSelect.options.length; i++) {
                if (idChemicalSelect.options[i].value === kategori) {
                    idChemicalSelect.selectedIndex = i;
                    break;
                }
            }

            // Kosongkan dan isi dropdown "Nama Sampel"
            namaSelect.innerHTML = ''; // Bersihkan opsi sebelumnya
            const newOption = document.createElement('option');
            newOption.value = nama;
            newOption.textContent = nama;
            newOption.selected = true;
            namaSelect.appendChild(newOption);

            // Isi input "Batch" dan "Deskripsi"
            batchInput.value = batch || '';
            descInput.value = deskripsi || '';

            // Trigger event "change" pada dropdown untuk menampilkan data tabel (jika ada logic lain)
            const event = new Event('change');
            namaSelect.dispatchEvent(event);
        }
    });

    // Handle perubahan nama
    document.getElementById('nama').addEventListener('change', function () {
        const namaValue = this.value;
        const chemicalId = document.getElementById('id_chemical').value;
        const detailTableBody = document.getElementById('detailTable').querySelector('tbody');

        detailTableBody.innerHTML = ''; // Bersihkan tabel sebelum mengisi ulang

        if (tipeSampelData[chemicalId]) {
            const selectedData = tipeSampelData[chemicalId].find(item => item.nama === namaValue);

            if (selectedData) {
                const fields = [
                    { name: 'Clarity', key: 'clarity' },
                    { name: '% Transmission', key: 'transmission' },
                    { name: 'Appreance', key: 'ape' },
                    { name: 'Dimethyltin Dichloride', key: 'dimet' },
                    { name: 'Trimethyltin Monochloride', key: 'trime' },
                    { name: '% Tin', key: 'tin' },
                    { name: '% Solid Content', key: 'solid' },
                    { name: 'RI @ 25°C', key: 'ri' },
                    { name: 'SG @ 25°C', key: 'sg' },
                    { name: 'Acid Value', key: 'acid' },
                    { name: '% Sulfur', key: 'sulfur' },
                    { name: 'Water Content', key: 'water' },
                    { name: 'Monomethylthin', key: 'mono' },
                    { name: 'Yellowish Index', key: 'yellow' },
                    { name: '2-EH', key: 'eh' },    
                    { name: 'Viscosity @ 25°C', key: 'visco' },
                    { name: 'Pt-Co', key: 'pt' },
                    { name: 'Moisture Content', key: 'moisture' },
                    { name: '% Cloride', key: 'cloride' },
                    { name: 'Specific Gravity (25°C)', key: 'spec' },
                    { name: 'Density', key: 'densi' },
                ];

                fields.forEach(field => {
                    const value = selectedData[field.key];
                    if (value && value.trim() !== '') { // Tampilkan hanya jika nilai tidak kosong
                        detailTableBody.innerHTML += `
                            <tr>
                                <td>${field.name}</td>
                                <td>${value}</td>
                                <td><input type="text" class="form-control" name="${field.key}" placeholder="Isi ${field.name}" value=""></td>
                                <td id="status-${field.key}">--</td>
                            </tr>
                        `;
                    }
                });

                // Add event listeners for input validation on each row
                document.querySelectorAll('input[type="text"]').forEach(input => {
                    input.addEventListener('input', function () {
                        const spesifikasi = selectedData[this.name];
                        const value = parseFloat(this.value);

                        const statusCell = this.closest('tr').querySelector('td:nth-child(4)');
                        statusCell.innerHTML = ''; // Reset status cell

            // Validasi sesuai spesifikasi
            if (spesifikasi.includes('<')) {
                const max = parseFloat(spesifikasi.replace('<', '').trim());
                updateNotification(value < max, statusCell);
            } else if (spesifikasi.includes('-') || spesifikasi.includes('~')) {
                const delimiter = spesifikasi.includes('-') ? '-' : '~';
                const [min, max] = spesifikasi.split(delimiter).map(val => parseFloat(val.trim()));
                updateNotification(value >= min && value <= max, statusCell);
            } else if (spesifikasi.includes('±')) {
                // Format toleransi, contoh "1.505 ± 0.005"
                const [patokan, toleransi] = spesifikasi.split('±').map(val => parseFloat(val.trim()));
                const min = patokan - toleransi; // Hitung batas bawah
                const max = patokan + toleransi; // Hitung batas atas
                updateNotification(value >= min && value <= max, statusCell); // Passed jika dalam rentang min - max
            } else if (spesifikasi.includes('≤')) {
                const max = parseFloat(spesifikasi.replace('≤', '').trim());
                updateNotification(value <= max, statusCell); // Passed jika value <= max
            } else if (spesifikasi.includes('≥')) {
                const min = parseFloat(spesifikasi.replace('≥', '').trim());
                updateNotification(value >= min, statusCell); // Not passed jika value < min (misal < 90)
            }


                    });
                });
            } else {
                console.warn('No matching data found for name:', namaValue);
            }
        } else {
            console.warn('No data available for the selected chemical ID:', chemicalId);
        }
    });

    // Fungsi untuk memperbarui status validasi
    function updateNotification(isPassed, statusCell) {
        if (isPassed) {
            statusCell.innerHTML = `
                <div class="validation-success">
                    ✅ <strong>Passed</strong>
                </div>
            `;
        } else {
            statusCell.innerHTML = `
                <div class="validation-error">
                    ❌ <strong>Not Passed</strong>
                </div>
            `;
        }
    }
</script>

<script>
        document.getElementById('select_transaksi').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];

        if (selectedOption.value) {
            // Tampilkan detail transaksi
            document.getElementById('transaksi-details').style.display = 'block';

            // Ambil atribut dari option yang dipilih
            const nama = selectedOption.getAttribute('data-nama');
            const kategori = selectedOption.getAttribute('data-kategori');
            const orang = selectedOption.getAttribute("data-orang") || "Tidak ada data";
            const batch = selectedOption.getAttribute('data-batch') || ''; // Batch
            const desc = selectedOption.getAttribute('data-desc') || ''; // Deskripsi
            const createdAt = selectedOption.getAttribute('data-created_at');

            // Set nilai ke table detail
            document.getElementById('detail-tgl').innerText = createdAt || '-';
            document.getElementById('detail-nama_kategori').innerText = kategori || '-';
            document.getElementById('detail-nama').innerText = nama || '-';
            document.getElementById("orang_display").innerText = `Orang: ${orang}`;
        }
    });

    // Inisialisasi Select2
    $(document).ready(function() {
        $('.select2').select2();
    });
document.addEventListener("DOMContentLoaded", function () {
    // Input tanggal otomatis
    const dateInput = document.getElementById("tgl");
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    dateInput.value = formattedDate;
});


</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Automatically set the current time if it's readonly
        if (document.getElementById("jam_masuk").readOnly) {
            const currentTime = new Date().toTimeString().split(' ')[0]; // Get HH:MM:SS format
            document.getElementById("jam_masuk").value = currentTime;
        }
        const namaPengguna = "{{ Auth::user()->name ?? 'User Default' }}"; // Ambil dari Laravel Auth atau nilai default
        document.getElementById('orang').value = namaPengguna;
    });
</script>

@endsection
