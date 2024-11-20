@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data MecL</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Tanggal -->
            <div class="mb-3">
                <label for="tgl" class="form-label">Tanggal</label>
                <input type="date" name="tgl" class="form-control" id="tgl" required readonly>
            </div>

            <!-- Kategori -->
            <div class="mb-3">
                <label for="id_category" class="form-label">Kategori</label>
                <select class="form-control select2" name="id_category" id="id_category" required>
                    <option disabled selected value="">Pilih Kategori</option>
                    @foreach ($category as $rs)
                        <option value="{{ $rs->id_category }}">{{ $rs->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            

            <!-- Tipe Sampel -->
            <div class="mb-3">
                <label for="tipe_sampel" class="form-label">Tipe Sampel</label>
                <select name="tipe_sampel" class="form-control select2" id="tipe_sampel" required>
                    <option disabled selected value="">Pilih Tipe Sampel</option>
                </select>
            </div>


            <!-- Batch / Lot -->
            <div class="mb-3">
                <label for="batch" class="form-label">Batch / Lot</label>
                <input type="text" name="batch" class="form-control" id="batch" placeholder="Masukkan batch" required>
            </div>

            <!-- Deskripsi -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <input type="text" name="deskripsi" class="form-control" id="deskripsi" placeholder="Masukkan deskripsi" required>
            </div>

            <!-- Nama -->
            <div class="mb-3">
                <label for="nama_mecl" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama MecL" value="{{ Auth::user()->name }}" required readonly>
            </div>

            <!-- Audit Trail (Tersembunyi) -->
            <div class="mb-3" style="display: none;">
                <label for="audit_trail" class="form-label">Audit Trail</label>
                <input type="text" name="audit_trail" class="form-control" id="audit_trail" required readonly>
            </div>

            <div class="mb-3" id="jamMasukContainer" style="display: none;">
                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                <input type="time" name="jam_masuk" class="form-control" id="jam_masuk" required readonly>
            </div>

            <button type="submit" class="btn btn-primary">Tambah Data</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mengisi field tanggal dengan tanggal hari ini
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tgl').value = today;

        // Mengisi audit trail
        const user = '{{ Auth::user()->name }}';
        const timestamp = new Date().toLocaleString();
        document.getElementById('audit_trail').value = `Updated by: ${user} at ${timestamp}`;

        // Mengatur nilai jam masuk ke jam saat ini
        const jamMasukInput = document.getElementById('jam_masuk');
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        jamMasukInput.value = `${hours}:${minutes}`;

        // Data tipe sampel berdasarkan kategori
// Data tipe sampel berdasarkan kategori
const tipeSampelData = {
    '1': ['Mecl', '2-EHTG', 'Amonia', 'DPDP', 'Logam Timah', 'Tembaga Murni', 'Perak Murni', 'Nickel'],
    '2': ['SnCL4'],
    '3': ['Line 1', 'Line 2', 'Line 3', 'Line 4', 'Line 5', 'Line 6', 'Line 7', 'Line 8', 'DMT Mixing'],
    '4': ['Reaksi Akhir', 'Settle', 'Drying', 'Filtrasi', 'Sirkulasi Storage', 'Drumming (FG)'],
    '5': ['Tin Shot', 'SnPB 6040', 'Sn100c'],
    '6': ['Other 1', 'Other 2'],
    '7': ['D9930c', 'D9930c (A)', 'D9930c (W)', 'MB D9930c', 'NAP100'],
    '8': ['SAC0307', 'SAC0307 (A)', 'E9650 (2,9% Ag)', 'E9650 (3% Ag)', 'E9650 (A) (2,9% Ag)', 'E9650 (A) (3% Ag)'],
    '9': ['0307CX', '0507CX', '9650CX (2.9% Ag)', '9650CX (3% Ag)', '9650CX (B) (2,9% Ag)'],
    '10': ['Sn63/37', 'Sn63/37 (A)','Sn60/40','Sn60/40 (A)','Sn60/40 (B)','Sn55/45'],
};

// Event listener untuk perubahan kategori
document.getElementById('id_category').addEventListener('change', function() {
    const categoryId = this.value;
    const tipeSampelSelect = document.getElementById('tipe_sampel');
    tipeSampelSelect.innerHTML = '<option disabled selected value="">Pilih Tipe Sampel</option>';

    if (tipeSampelData[categoryId]) {
        tipeSampelData[categoryId].forEach(function(tipe) {
            const option = document.createElement('option');
            option.value = tipe;
            option.textContent = tipe;
            tipeSampelSelect.appendChild(option);
        });
    }
});

    });
</script>

@endsection
