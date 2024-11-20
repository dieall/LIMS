@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data DMT</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('dmt.store') }}" method="POST">
            @csrf

            <!-- Pilihan Data Pengajuan Sampel -->
            <div class="mb-3">
                <label for="select_transaksi" class="form-label">
                    <i class="fas fa-exchange-alt"></i> Pilih Data Pengajuan Sampel Hari Ini
                </label>
                <select class="form-control stylish-select" name="select_transaksi" id="select_transaksi" required>
                    <option disabled selected value="">Pengajuan Sampel Hari Ini</option>
                    @foreach($transaksi as $trx)
                    <option value="{{ $trx->id }}" 
                            data-tgl="{{ $trx->tgl }}"
                            data-id_category="{{ $trx->id_category }}"  
                            data-nama_kategori="{{ optional($trx->category)->nama_kategori }}"  
                            data-tipe_sampel="{{ $trx->tipe_sampel }}"
                            data-batch="{{ $trx->batch }}"
                            data-deskripsi="{{ $trx->deskripsi }}"
                            data-nama="{{ $trx->nama }}">
                        📅 {{ $trx->tgl }} | 🏷️ {{ optional($trx->category)->nama_kategori ?? 'Kategori Tidak Ada' }} | 🧪 {{ $trx->tipe_sampel }} | 👤 {{ $trx->nama }}
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
                            <th>Tipe Sampel</th>
                            <th>Batch</th>
                            <th>Deskripsi</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td id="detail-tgl"></td>
                            <td id="detail-nama_kategori"></td>
                            <td id="detail-tipe_sampel"></td>
                            <td id="detail-batch"></td>
                            <td id="detail-deskripsi"></td>
                            <td id="detail-nama"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Input Kode BQR -->
            <div class="mb-3" id="kode-bqr-container" style="display:none;">
                <label for="id" class="form-label">Kode BQR</label>
                <input type="text" name="id" class="form-control" id="id" readonly value="DMTDCL-510">
            </div>
            <div class="mb-3" style="display:none;">
    <label for="tgl" class="form-label">Tanggal</label>
    <input type="date" name="tgl" class="form-control" id="tgl" value="">
</div>

            <!-- Input Hidden untuk ID Transaksi dan Kategori -->
            <div class="mb-3" style="display:none;">
                <label for="id_transaksi" class="form-label">ID TRANSAKSI</label>
                <input type="text" name="id_transaksi" class="form-control" id="id_transaksi">
            </div>
            <div class="mb-3" style="display:none;">
                <label for="id_category" class="form-label">ID CATEGORY</label>
                <input type="text" name="id_category" class="form-control" id="id_category">
            </div>
            <div class="mb-3">
    <label for="tanggal">Tanggal Hari Ini</label>
    <input type="hidden" name="tanggal" class="form-control" id="tanggal" value="{{ date('Y-m-d') }}" readonly>
</div>
            <div class="mb-3">
                <input type="hidden" name="dimet" class="form-control" id="dimet" value="">
            </div>

            <div class="mb-3">
                <input type="hidden" name="moisture" class="form-control" id="moisture" value="">
            </div>
           
            <!-- Tabel DMT 98 -->
            <h5>Tabel DMT 98</h5>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Test</th>
                        <th>Specification</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Appearance</td>
                        <td>Alpha Color < 50</td>
                        <td><input type="text" name="ape" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>%Solid Content</td>
                        <td>50% ± 3%</td>
                        <td><input type="text" name="solid" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>%Tin Content</td>
                        <td>26.5 ± 1.5%</td>
                        <td><input type="text" name="tinc" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Monomethylin Trichloride</td>
                        <td>10% ± 3%</td>
                        <td><input type="text" name="monomet" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Trimethyltin Monochloride</td>
                        <td>0.1 % max</td>
                        <td><input type="text" name="trime" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Cloride</td>
                        <td>17.5 ± 1%</td>
                        <td><input type="text" name="cloride" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Specific Gravity (25°C)</td>
                        <td>1.45 ± 0.1</td>
                        <td><input type="text" name="spec" class="form-control"></td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Tambah Data</button>
        </form>
    </div>
</div>

<script>
document.getElementById('select_transaksi').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];

    if (selectedOption.value) {
        // Tampilkan detail dan input Kode BQR
        document.getElementById('transaksi-details').style.display = 'block';
        document.getElementById('kode-bqr-container').style.display = 'block';

        // Ambil nilai dari option yang dipilih
        const tgl = selectedOption.getAttribute('data-tgl');
        const idCategory = selectedOption.getAttribute('data-id_category'); 
        const namaKategori = selectedOption.getAttribute('data-nama_kategori'); 
        const tipeSampel = selectedOption.getAttribute('data-tipe_sampel');
        const batch = selectedOption.getAttribute('data-batch');
        const deskripsi = selectedOption.getAttribute('data-deskripsi');
        const nama = selectedOption.getAttribute('data-nama');

        // Set nilai ke table detail
        document.getElementById('detail-tgl').innerText = tgl || '-';
        document.getElementById('detail-nama_kategori').innerText = namaKategori || '-';
        document.getElementById('detail-tipe_sampel').innerText = tipeSampel || '-';
        document.getElementById('detail-batch').innerText = batch || '-';
        document.getElementById('detail-deskripsi').innerText = deskripsi || '-';
        document.getElementById('detail-nama').innerText = nama || '-';

        // Set nilai ke input hidden
        document.getElementById('id_transaksi').value = selectedOption.value;
        document.getElementById('id_category').value = idCategory;
    }
});
</script>

<script>
    // Mengisi input tanggal dengan tanggal hari ini
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // Bulan mulai dari 0
        const dd = String(today.getDate()).padStart(2, '0');

        // Format tanggal ke format YYYY-MM-DD
        const formattedDate = `${yyyy}-${mm}-${dd}`;
        
        // Set nilai ke input
        document.getElementById('tgl').value = formattedDate;
    });
</script>

@endsection
