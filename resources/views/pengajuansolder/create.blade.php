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
        <form action="{{ route('pengajuansolder.store') }}" method="POST" enctype="multipart/form-data">
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
                    @foreach ($categorysolder as $rs)
                        <option value="{{ $rs->id_category }}">{{ $rs->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tipe Solder -->
            <div class="mb-3">
                <label for="tipe_solder" class="form-label">Tipe Solder</label>
                <select name="tipe_solder" class="form-control select2" id="tipe_solder" required>
                    <option disabled selected value="">Pilih Tipe Solder</option>
                </select>
            </div>

            <!-- Batch / Lot -->
            <div class="mb-3">
                <label for="batch" class="form-label">Batch / Lot</label>
                <input type="text" name="batch" class="form-control" id="batch" placeholder="Masukkan batch" required>
            </div>

            <!-- Nama -->
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama MecL" value="{{ Auth::user()->name }}" required readonly>
            </div>

            <!-- Audit Trail (Tersembunyi) -->
            <div class="mb-3" style="display: none;">
                <label for="audit_trail" class="form-label">Audit Trail</label>
                <input type="text" name="audit_trail" class="form-control" id="audit_trail" required readonly>
            </div>

            <!-- Jam Masuk (Tersembunyi) -->
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

    // Data tipe sampel untuk kategori id 1 dan id 2
    const tipeSampelData = {
        '1': {!! json_encode($tbs_sncu->pluck('tipe_solder')) !!},
        '2': {!! json_encode($tbs_snagcu->pluck('tipe_solder')) !!},
        '3': {!! json_encode($tbs_snag->pluck('tipe_solder')) !!},
        '4': {!! json_encode($tbs_tin->pluck('tipe_solder')) !!}
    };

    // Event listener untuk perubahan kategori
    document.getElementById('id_category').addEventListener('change', function() {
        const categoryId = this.value;
        const tipeSampelSelect = document.getElementById('tipe_solder');
        tipeSampelSelect.innerHTML = '<option disabled selected value="">Pilih Tipe Solder</option>';

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
