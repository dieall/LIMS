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
        <h6 class="m-0 font-weight-bold">Tambah Data | Pengajuan Solder</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('pengajuansolder.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                        <option value="{{ $rs->id_category }}">{{ $rs->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tipe Solder -->
            <div class="col-md-6 mb-3">
                <label for="tipe_solder" class="form-label">Tipe Solder</label>
                <select name="tipe_solder" class="form-control select2" id="tipe_solder" required>
                    <option disabled selected value="">Pilih Tipe Solder</option>
                </select>
            </div>

            </div>
            <!-- Tabel untuk menampilkan detail tipe solder -->



            <!-- Batch / Lot -->
            <div class="row">
            <div class="col-md-6 mb-3">
                <label for="batch" class="form-label">Batch / Lot</label>
                <input type="text" name="batch" class="form-control" id="batch" placeholder="Masukkan batch" required>
            </div>

            <!-- Nama -->
            <div class="col-md-6 mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama MecL" value="{{ Auth::user()->name }}" required readonly>
            </div>

            <div style="display: none;">
                <input type="text" name="previous_status" id="previous_status" value="Pengajuan">
                <input type="text" name="previous_jam_masuk" id="previous_jam_masuk" value="{{ now()->format('H:i') }}">
            </div>
            </div>
            <!-- Audit Trail (Tersembunyi) -->
            <div class="mb-3" style="display: none;">
                <label for="audit_trail" class="form-label">Audit Trail</label>
                <input type="text" name="audit_trail" class="form-control" id="audit_trail" required readonly>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Masukkan deskripsi" required></textarea>
            </div>

            <!-- Jam Masuk (Tersembunyi) -->
            <div class="mb-3" id="jamMasukContainer" style="display: none;">
                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                <input type="time" name="jam_masuk" class="form-control" id="jam_masuk" required readonly>
            </div>

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
<table class="table table-bordered table-striped table-hover" id="data-table" style="display: none;">
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
        <td><input type="text" step="any" name="sn" class="form-control" id="sn" placeholder="Sn"></td>
        <td class="status" id="sn-status">--</td>
    </tr>
    <tr>
        <td>Ag</td>
        <td>-</td>
        <td><input type="number" step="any" name="ag" class="form-control element" id="ag" placeholder="Ag"></td>
        <td class="status">--</td>
    </tr>
    <tr>
        <td>Cu</td>
        <td>-</td>
        <td><input type="number" step="any" name="cu" class="form-control element" id="cu" placeholder="Cu"></td>
        <td class="status">--</td>
    </tr>
    <tr>
        <td>Pb</td>
        <td>-</td>
        <td><input type="text" step="any" name="pb" class="form-control element" id="pb" placeholder="Pb"></td>
        <td class="status">--</td>
    </tr>
    <tr>
        <td>Sb</td>
        <td>-</td>
        <td><input type="number" step="any" name="sb" class="form-control element" id="sb" placeholder="Sb"></td>
        <td class="status">--</td>
    </tr>
    <tr>
        <td>Zn</td>
        <td>-</td>
        <td><input type="number" step="any" name="zn" class="form-control element" id="zn" placeholder="Zn"></td>
        <td class="status">--</td>
    </tr>
    <tr>
        <td>Fe</td>
        <td>-</td>
        <td><input type="number" step="any" name="fe" class="form-control element" id="fe" placeholder="Fe"></td>
        <td class="status">--</td>
    </tr>
    <tr>
        <td>As</td>
        <td>-</td>
        <td><input type="number" step="any" name="as" class="form-control element" id="as" placeholder="As"></td>
        <td class="status">--</td>
    </tr>
    <tr>
        <td>Ni</td>
        <td>-</td>
        <td><input type="number" step="any" name="ni" class="form-control element" id="ni" placeholder="Ni"></td>
        <td class="status">--</td>
    </tr>
    <tr>
        <td>Bi</td>
        <td>-</td>
        <td><input type="number" step="any" name="bi" class="form-control element" id="bi" placeholder="Bi"></td>
        <td class="status">--</td>
    </tr>
    <tr>
        <td>Cd</td>
        <td>-</td>
        <td><input type="number" step="any" name="cd" class="form-control element" id="cd" placeholder="Cd"></td>
        <td class="status">--</td>
    </tr>
    <tr>
        <td>Ai</td>
        <td>-</td>
        <td><input type="number" step="any" name="ai" class="form-control element" id="ai" placeholder="Ai"></td>
        <td class="status">--</td>
    </tr>
    <tr>
        <td>Pe</td>
        <td>-</td>
        <td><input type="number" step="any" name="pe" class="form-control element" id="pe" placeholder="Pe"></td>
        <td class="status">--</td>
    </tr>
    <tr>
        <td>Ga</td>
        <td>-</td>
        <td><input type="number" step="any" name="ga" class="form-control element" id="ga" placeholder="Ga"></td>
        <td class="status">--</td>
    </tr>
    
    <tr>
        <td hidden>
            <input type="hidden" name="status" id="status" value="">
        </td>
    </tr>
</tbody>

</table>



            <button type="submit" class="btn btn-primary">Tambah Data</button>
        </form>
    </div>
</div>
<script>
    // Mengosongkan nilai input saat halaman dimuat
    window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('ga').value = '';
    });
</script>
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

    // Handle category change
    document.getElementById('id_category').addEventListener('change', function () {
        const categoryId = this.value;
        const tipeSampelSelect = document.getElementById('tipe_solder');
        tipeSampelSelect.innerHTML = '<option disabled selected value="">Pilih Tipe Solder</option>';

        if (tipeSampelData[categoryId]) {
            tipeSampelData[categoryId].forEach(function (tipe) {
                const option = document.createElement('option');
                option.value = tipe.tipe_solder;
                option.textContent = tipe.tipe_solder;
                tipeSampelSelect.appendChild(option);
            });
        } else {
            console.warn('No data available for the selected category:', categoryId);
        }
    });

    // Handle tipe solder change
    document.getElementById('tipe_solder').addEventListener('change', function () {
        const tipeSolder = this.value;
        const categoryId = document.getElementById('id_category').value;

        if (tipeSampelData[categoryId]) {
            const selectedTipe = tipeSampelData[categoryId].find(tipe => tipe.tipe_solder === tipeSolder);

            if (selectedTipe) {
                // Fill the specification columns
                const fields = ['sn', 'ag', 'cu', 'pb', 'sb', 'zn', 'fe', 'as', 'ni', 'bi', 'cd', 'ai', 'pe', 'ga'];
                fields.forEach((field, index) => {
                    const row = document.querySelector(`tr:nth-child(${index + 1}) td:nth-child(2)`);
                    if (row) {
                        row.textContent = selectedTipe[field] || '-';
                    }
                });

                // Store the current spesifikasi data globally for validation
                window.currentSpesifikasi = selectedTipe;
            } else {
                console.warn('No data found for tipe solder:', tipeSolder);
            }
        } else {
            console.warn('No data available for the selected category:', categoryId);
        }
    });


    document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('input', function () {
        const spesifikasi = window.currentSpesifikasi; // Ambil data spesifikasi yang dipilih

        if (!spesifikasi) {
            console.warn('Data spesifikasi tidak ditemukan untuk validasi.');
            return;
        }

        const field = this.id; // ID input field (contoh: 'ag', 'sn', dll.)
        const value = parseFloat(this.value); // Nilai input yang diisi oleh pengguna
        const spesifikasiText = spesifikasi[field]; // Ambil spesifikasi patokan

        // Temukan cell status (kolom ke-4 pada baris yang sama)
        const statusCell = this.closest('tr').querySelector('td:nth-child(4)');

        // Pastikan cell status kosong sebelum mengupdate isinya
        statusCell.innerHTML = '';

        // Validasi spesifikasi berdasarkan format
        if (spesifikasiText.includes('<')) {
            // Format batas maksimum, contoh "<0.1000"
            const max = parseFloat(spesifikasiText.replace('<', '').trim());
            updateNotification(value < max, statusCell);

        } else if (spesifikasiText.includes('-') || spesifikasiText.includes('~')) {
            // Format rentang nilai, contoh "0.5-0.6" atau "0.5~0.6"
            const delimiter = spesifikasiText.includes('-') ? '-' : '~';
            const [min, max] = spesifikasiText.split(delimiter).map(val => parseFloat(val.trim()));
            updateNotification(value >= min && value <= max, statusCell);

        } else if (spesifikasiText.includes('±')) {
            // Format toleransi, contoh "2.9±0.05"
            const [patokan, toleransi] = spesifikasiText.split('±').map(val => parseFloat(val.trim()));
            const min = parseFloat((patokan - toleransi).toFixed(5));
            const max = parseFloat((patokan + toleransi).toFixed(5));
            updateNotification(value >= min && value <= max, statusCell);

            // Debug log untuk memverifikasi perhitungan
            console.log(`Field: ${field}, Value: ${value}, Min: ${min}, Max: ${max}`);

        } else {
            // Format spesifikasi tidak dikenali
            console.warn(`Format spesifikasi tidak dikenali: ${spesifikasiText}`);
        }
    });
});

/**
 * Fungsi untuk memperbarui kotak notifikasi hasil validasi
 * @param {boolean} isPassed - Hasil validasi (true jika Passed, false jika Not Passed)
 * @param {HTMLElement} statusCell - Elemen cell status untuk menampilkan hasil
 */
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



});
</script>

<script>
    // Fungsi untuk menghitung nilai balance
    function calculateBalance() {
        const elements = document.querySelectorAll('.element'); // Ambil semua input kecuali Sn
        let total = 0;

        // Loop untuk menjumlahkan nilai input (kecuali Sn)
        elements.forEach((input) => {
            const value = parseFloat(input.value) || 0; // Konversi nilai menjadi angka atau 0 jika kosong
            total += value;
        });

        // Hitung balance (100 - total)
        const balance = 100 - total;

        // Tampilkan hasil di kolom status Sn
        document.getElementById('sn-status').textContent = balance.toFixed(2); // Format 2 desimal
    }

    // Tambahkan event listener ke semua input kecuali Sn
    document.querySelectorAll('.element').forEach((input) => {
        input.addEventListener('input', calculateBalance); // Hitung ulang setiap kali ada perubahan
    });



    // Anda dapat memanggil `setStatus` dengan nilai status lainnya sesuai logika aplikasi Anda
    // Misal:
    // setStatus("Proses Analisa");
    // setStatus("Selesai Analisa");
    // setStatus("Review Hasil");
    // setStatus("Approve");
</script>




@endsection