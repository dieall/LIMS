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
        <form action="{{ route('timchen.store') }}" method="POST">
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
                            data-jam_masuk="{{ $trx->jam_masuk }}"
                            data-nama="{{ $trx->nama }}">
                        📅 {{ $trx->tgl }} | ⏰ {{ $trx->jam_masuk }} | 🏷️ {{ optional($trx->category)->nama_kategori ?? 'Kategori Tidak Ada' }} | 🧪 {{ $trx->tipe_sampel }} | 👤 {{ $trx->nama }}
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
                <input type="text" name="id" class="form-control" id="id" readonly value="TC-191">
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


           
            <!-- Tabel DMT 98 -->
            <h5>Tabel DMT 98</h5>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Parameter</th>
                        <th>Specification</th>
                        <th>Methods</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Clarity</td>
                        <td>Clear</td>
                        <td>Visual Inspection</td>
                        <td><input type="text" name="clarity" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>% Transmission</td>
                        <td>≥ 85</td>
                        <td>Spectrophotometric</td>
                        <td><input type="text" name="trans" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>% Tin</td>
                        <td>17.0 ± 0.4</td>
                        <td>X-Ray Fluorescence</td>
                        <td><input type="text" name="tin" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>RI @ 25°C</td>
                        <td>1.505 ± 0.005</td>
                        <td>Refractometer</td>
                        <td><input type="text" name="ri" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>SG @ 25°C</td>
                        <td>1.140 ± 0.01</td>
                        <td>Density Meter</td>
                        <td><input type="text" name="sg" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Acid Value</td>
                        <td>1.140 ± 0.01</td>
                        <td>Density Meter</td>
                        <td><input type="text" name="acid" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>$ Sulfur</td>
                        <td>10 ± 0.05</td>
                        <td>Density Meter</td>
                        <td><input type="text" name="sulfur" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Water Content</td>
                        <td></td>
                        <td>Karl Fischer</td>
                        <td><input type="text" name="water" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Monomethyltin</td>
                        <td></td>
                        <td>NMR</td>
                        <td><input type="text" name="mono" class="form-control"></td>
                    </tr>
                    <input type="hidden" name="spec" class="form-control" value="">
                    <input type="hidden" name="den" class="form-control" value="">
                    <input type="hidden" name="yellow" class="form-control" value="">
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
        const jam_masuk = selectedOption.getAttribute('data-jam_masuk');
        const nama = selectedOption.getAttribute('data-nama');

        // Set nilai ke table detail
        document.getElementById('detail-tgl').innerText = tgl || '-';
        document.getElementById('detail-nama_kategori').innerText = namaKategori || '-';
        document.getElementById('detail-tipe_sampel').innerText = tipeSampel || '-';
        document.getElementById('detail-batch').innerText = batch || '-';
        document.getElementById('detail-deskripsi').innerText = deskripsi || '-';
        document.getElementById('detail-jam_masuk').innerText = jam_masuk || '-';
        document.getElementById('detail-nama').innerText = nama || '-';

        // Set nilai ke input hidden
        document.getElementById('id_transaksi').value = selectedOption.value;
        document.getElementById('id_category').value = idCategory;
    }
});
</script>

<script>
    // Fungsi untuk mendapatkan tanggal hari ini dalam format YYYY-MM-DD
    window.onload = function() {
        var today = new Date();
        var day = ("0" + today.getDate()).slice(-2);
        var month = ("0" + (today.getMonth() + 1)).slice(-2);
        var year = today.getFullYear();
        
        // Gabungkan untuk membuat format YYYY-MM-DD
        var todayFormatted = year + "-" + month + "-" + day;
        
        // Set nilai dari input tanggal
        document.getElementById('tgl').value = todayFormatted;
    };
</script>

@endsection
