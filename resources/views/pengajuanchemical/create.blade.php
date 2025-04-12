@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data | Data Raw Mat Tin-Chemical</h6>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('pengajuanchemical.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Dropdown untuk Nama Kategori -->
                <div class="mb-3">
                    <label for="kategori" class="form-label">Nama Kategori</label>
                    <select name="nama_chemical" class="form-control select2" id="kategori" required>
                        <option disabled selected value="">Pilih Kategori</option>
                        <option value="DMT">DMT</option>
                        <option value="Tinchem">Tinchem</option>
                        <option value="Tinstab">Tinstab</option>
                    </select>
                </div>

                <!-- Container untuk Dropdown Dynamic -->
                <div class="mb-3" id="dynamic-dropdown-container"></div>

                <div class="form-group mb-3">
                    <label for="date">Tanggal</label>
                    <input type="date" class="form-control" id="date" name="tgl" required>
                </div>

                <div class="form-group mb-3">
                    <label for="batch">Batch</label>
                    <input type="text" class="form-control" id="batch" name="batch" placeholder="Masukkan Batch" required>
                </div>

                <div class="form-group mb-3">
                    <label for="desc">Deskripsi</label>
                    <input type="text" class="form-control" id="desc" name="desc" placeholder="Masukkan Deskripsi" required>
                    <div class="mt-2 small text-muted">
                        * Jika hanya mengajukan sampel maka klik submit<br>
                        * Jika hanya membuat sampel baru maka klik Tampilkan Form
                    </div>
                </div>

                <div class="form-group mb-3" style="display: none;">
                    <label for="jam_masuk">Jam Masuk</label>
                    <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" required>
                </div>

                <!-- Input Orang (Otomatis) -->
                <div class="form-group mb-3" style="display: none;">
                    <label for="orang">Orang</label>
                    <input type="text" class="form-control" id="orang" name="orang" readonly>
                </div>

                <input type="hidden" name="status" value="Pengajuan">

                <!-- Tombol untuk Menampilkan Form -->
                <button type="submit" class="btn btn-primary" id="showFormBtn" disabled>Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    let selectedChemical = '';
    
    // Dropdown Dinamis
    document.getElementById('kategori').addEventListener('change', function () {
        const container = document.getElementById('dynamic-dropdown-container');
        const selectedValue = this.value;

        container.innerHTML = ''; // Reset container
        document.getElementById('showFormBtn').disabled = true; // Disable the button initially

        // Menghasilkan dropdown berdasarkan kategori
        if (selectedValue === 'DMT') {
            container.innerHTML = generateDropdown(["DMT-98", "DMTDCL-510", "DMTDCL-515"]);
        } else if (selectedValue === 'Tinchem') {
            container.innerHTML = generateDropdown([
                "TC-191", "TC-191 F", "TC-181 FS", "TCZ-159", "TCZ-139 M", 
                "TCZ-139", "TC-192 F", "TC-181", "TC-181 VN"
            ]);
        } else if (selectedValue === 'Tinstab') {
            container.innerHTML = generateDropdown(["MT-630", "MT-620"]);
        }
    });

    // Fungsi untuk membuat dropdown dinamis
    function generateDropdown(options) {
        let html = `
            <label for="data-chemical" class="form-label">Pilih Data Chemical</label>
            <select name="nama" class="form-control" id="data-chemical">
                <option disabled selected value="">Pilih</option>`;
                
        options.forEach(option => {
            html += `<option value="${option}">${option}</option>`;
        });
        
        html += `</select>`;
        return html;
    }

    // Aktifkan button setelah memilih chemical
    document.addEventListener('change', function(event) {
        if (event.target && event.target.id === 'data-chemical') {
            selectedChemical = event.target.value;
            if (selectedChemical) {
                document.getElementById('showFormBtn').disabled = false; // Enable the button
            }
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Set Tanggal Otomatis
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];
        document.getElementById('date').value = formattedDate;

        // Set Jam Masuk Otomatis
        const hours = today.getHours().toString().padStart(2, '0'); // Format 2 digit jam
        const minutes = today.getMinutes().toString().padStart(2, '0'); // Format 2 digit menit
        const formattedTime = `${hours}:${minutes}`;
        document.getElementById('jam_masuk').value = formattedTime;

        const namaPengguna = "{{ Auth::user()->name ?? 'User Default' }}"; // Ambil dari Laravel Auth atau nilai default
        document.getElementById('orang').value = namaPengguna;
    });
</script>

@endsection
