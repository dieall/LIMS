@extends('layouts.app')

@section('contents')
<!-- CSS Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<!-- JS Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cetak CoA Lokal</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Cetak CoA Ekspor | {{ $pengajuansolder->tipe_solder }}</h6>
    </div>

    <div class="card-body" id="print-area">
        <div class="row">
            <div class="col">
                <div style="margin-bottom: 1px; padding-bottom: 0px;">
                    <label for="nomor_coa" style="display: inline-block; width: 200px;">CoA Number</label>
                    <span style="margin-left: 5px;">:</span>
                    <input type="text" id="nomor_coa" name="nomor_coa" class="form-control">
                </div>

                <div style="margin-bottom: 0px; padding-bottom: 0px;">
                    <label for="product" style="display: inline-block; width: 200px;">Product</label>
                    <span style="margin-left: 5px;">:</span>
                    <input type="text" id="product" name="product" value="{{ $pengajuansolder->tipe_solder }}" class="form-control">
                </div>
                <div style="margin-bottom: 0px; padding-bottom: 0px;">
                    <label for="product" style="display: inline-block; width: 200px;">Composition</label>
                    <span style="margin-left: 5px;">:</span>
                    <input type="text" id="product" name="product" value="{{ $pengajuansolder->nama_kategori }}" class="form-control">
                </div>
                <div style="margin-bottom: 0px; padding-bottom: 0px;">
                    <label for="po_number" style="display: inline-block; width: 200px;">PO Number</label>
                    <span style="margin-left: 5px;">:</span>
                    <input type="text" id="po_number" name="po_number" value="{{ $pengajuansolder->spesification ?? '-' }}" class="form-control">
                </div>

                <div style="margin-bottom: 0px; padding-bottom: 0px;">
                    <label for="marks" style="display: inline-block; width: 200px;">Marks</label>
                    <span style="margin-left: 5px;">:</span>
                    <input type="text" id="marks" name="marks" class="form-control">
                </div>

                <div style="margin-bottom: 0px; padding-bottom: 0px;">
                    <label for="number_of_boxes" style="display: inline-block; width: 200px;">Number Of Boxes</label>
                    <span style="margin-left: 5px;">:</span>
                    <input type="text" id="number_of_boxes" name="number_of_boxes" class="form-control">
                </div>
            </div>
        </div>

        <div style="margin-bottom: 1px; padding-top: 2px;">
    <!-- Filter berdasarkan Batch -->
    <label for="filterBatch" class="filter-label">Filter Berdasarkan Batch</label>
    <div class="form-group">
        <input type="text" id="filterBatch" class="form-control" placeholder="Cari berdasarkan Batch" onkeyup="filterBatch()" />
    </div>

    <!-- Dropdown untuk memilih Pengajuan -->
    <label for="dropdownPengajuan" class="dropdown-label">Pilih Pengajuan</label>
    <div class="form-group">
        <select id="dropdownPengajuan" name="dropdownPengajuan" class="form-control" onchange="fetchPengajuanData(this.value)">
            <option value="" selected disabled>Pilih Pengajuan</option>
            @foreach ($allPengajuanSolder as $pengajuan)
                <option value="{{ $pengajuan->id }}">
                    {{ $pengajuan->batch ?? '' }} - {{ \Carbon\Carbon::parse($pengajuan->tgl)->format('j  M  y') ?? '-' }}
                </option>
            @endforeach
        </select>
    </div>
</div>



        <div style="padding-top: 5px;">
            
        </div> <!-- Menambahkan jarak di atas elemen lain -->

        <textarea name="w3review" class="form-control" style="margin-top: 20px;">
            We further certify that the analysis of the below mentioned lot as follows:
        </textarea>
        
        <div style="padding-top: 5px;">

        </div> <!-- Menambahkan jarak di atas elemen lain -->

        <table style="width: 87%; border-collapse: collapse; border: 1px solid black; text-align: center;" id="mainTable">
            <thead>
                <tr>
                    <th rowspan="2" style="padding: 4px; text-align: center; border: 1px solid black;">Composition</th>
                    <th rowspan="2" style="padding: 4px; text-align: center; border: 1px solid black;">Method</th>
                    
                    <th rowspan="2" style="padding: 4px; text-align: center; border: 1px solid black;">Specification</th>
                
                    <th style="padding: 2px; text-align: center; border: 1px solid black;">Lot No. {{ $pengajuansolder->batch ?? '-' }}</th>
                </tr>
                <tr>
                    <th style="padding: 2px; text-align: center; border: 1px solid black;">{{ \Carbon\Carbon::parse($pengajuansolder->tgl)->format('j  M  y') ?? '-' }}</th>
                </tr>
            </thead>
                <tbody id="tableBody">
                    @php
                        $fields = [
                            'sn' => 'Sn',
                            'ag' => 'Ag',
                            'cu' => 'Cu',
                            'pb' => 'Pb',
                            'sb' => 'Sb',
                            'zn' => 'Zn',
                            'fe' => 'Fe',
                            'as' => 'As',
                            'ni' => 'Ni',
                            'bi' => 'Bi',
                            'cd' => 'Cd',
                            'ai' => 'Al',
                            'pe' => 'Pe',
                            'ga' => 'Ga',
                        ];
                    @endphp

                    @foreach ($fields as $field => $label)
                    <tr id="row-{{ $field }}">
                        <td style="border: 1px solid black; padding: 5px;">{{ $label }}</td>
                        <td style="border: 1px solid black; padding: 5px;">OES</td>
                        <td style="border: 1px solid black; padding: 5px;">{{ $pengajuansolder->DataSolder->$field ?? '' }}</td>
                        <td style="border: 1px solid black; padding: 5px;">{{ $pengajuansolder->$field ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr id="weightRow">
                        <td colspan="2" style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
                            Weight (Kg)
                        </td>
                        
                        <td>

                        </td>
                        <td style="border: 1px solid black; padding: 3px;">
                            <input type="number" class="weight-input" style="width: 100%; padding: 5px;" placeholder="Masukan Kg Disini ! ! !"oninput="updateTotalWeight()" /> Kg
                        </td>
                    </tr>
                </tfoot>
        </table>

        <div style="font-size: 11px; margin-top: 10px;">
            <span>Total Weight : </span><span id="totalWeight">0 kg</span>
        </div>

    </div></div>
<div class="mt-3">
        <a href="{{ route('pengajuansolder.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="javascript:void(0)" class="btn btn-success" onclick="printData()">Print</a>
      
    </div>

    <script>
    // Menunggu hingga halaman sepenuhnya dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        const day = today.getDate(); // Mendapatkan tanggal
        const month = today.toLocaleString('default', { month: 'long' }); // Mendapatkan nama bulan
        const year = today.getFullYear(); // Mendapatkan tahun

        // Format tanggal yang diinginkan
        const formattedDate = `${month} ${day}, ${year}`;

        // Menampilkan tanggal dalam elemen dengan id "date"
        document.getElementById('date').textContent = formattedDate;
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const dropdown = document.getElementById('dropdownPengajuan');

    dropdown.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const selectedId = selectedOption.value;
        const batchNo = selectedOption.textContent.split(" - ")[0].replace("Lot No: ", "");
        const prodDate = selectedOption.textContent.split(" - ")[1].replace("Prod. Date: ", "");

        if (!selectedId) return;

        fetch(`{{ route('pengajuansolder.expor', ['id' => $pengajuansolder->id]) }}?pengajuan_id=${selectedId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        })
        .then(response => response.json())
        .then(data => {
            const table = document.getElementById("mainTable");
            const theadRows = table.querySelectorAll("thead tr");
            const tbody = document.getElementById("tableBody");
            const weightRow = document.getElementById("weightRow");

            // Tambahkan header baru untuk Lot No.
            const newHeader = document.createElement("th");
            newHeader.style.border = "1px solid black";
            newHeader.style.padding = "5px";
            newHeader.textContent = `Lot No. ${batchNo}`;
            theadRows[0].appendChild(newHeader);

            // Tambahkan sub-header untuk Prod. Date
            const newSubHeader = document.createElement("th");
            newSubHeader.style.border = "1px solid black";
            newSubHeader.style.padding = "5px";
            newSubHeader.textContent = prodDate;
            theadRows[1].appendChild(newSubHeader);

            // Data komposisi kimia
            const fields = {
                sn: 'Sn',
                ag: 'Ag',
                cu: 'Cu',
                pb: 'Pb',
                sb: 'Sb',
                zn: 'Zn',
                fe: 'Fe',
                as: 'As',
                ni: 'Ni',
                bi: 'Bi',
                cd: 'Cd',
                ai: 'Al',
                pe: 'Pe',
                ga: 'Ga',
            };

            // Tambahkan kolom baru untuk setiap baris yang sudah ada di tabel
            for (const field in fields) {
                let row = document.getElementById(`row-${field}`);

                if (!row) {
                    console.error(`Baris ${field} tidak ditemukan!`);
                    continue;
                }

                // Tambahkan sel baru di sebelah kanan tabel
                const newCell = document.createElement("td");
                newCell.style.border = "1px solid black";
                newCell.style.padding = "5px";
                newCell.textContent = data[field] ?? '';
                row.appendChild(newCell);
            }

            // Tambahkan input weight baru di footer (row weight)
            const newWeightCell = document.createElement("td");
            newWeightCell.style.border = "1px solid black";
            newWeightCell.style.padding = "5px";
            newWeightCell.innerHTML = `<input type="number" class="weight-input"
                                        style="width: 100%; border: none; padding: 5px; text-align: center;"
                                        oninput="updateTotalWeight()"> kg`;
            weightRow.appendChild(newWeightCell);

        })
        .catch(error => {
            console.error('Error fetching data:', error);
            alert('Terjadi kesalahan saat mengambil data.');
        });
    });
});


    function updateTotalWeight() {
        const weightInput = document.getElementById("weightInput").value;
        const weight = parseFloat(weightInput);
        document.getElementById("totalWeight").innerText = isNaN(weight) ? 0 : weight;
    }
</script>

<script>
function printData() {
    // Simpan elemen utama yang akan dicetak
    const printArea = document.getElementById('print-area').cloneNode(true);

    // Ambil nilai dari input "Nomor CoA"
    const nomorCoaInput = document.querySelector('input[name="nomor_coa"]');
    const nomorCoaValue = nomorCoaInput ? nomorCoaInput.value.trim() : '-';

    // Ubah semua input, textarea, dan select menjadi teks biasa agar tidak muncul kotak input saat cetak
    const inputs = printArea.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        const span = document.createElement('span');
        span.textContent = input.value || '-';
        input.parentNode.replaceChild(span, input);
    });

    // Template cetak
    const customPrintContent = `
    <br>
    <br>
        <div style="text-align: center; margin-top: 20px;">
<h2 style="margin: 0; font-size: 35px; font-weight: bold; font-family: 'Times New Roman', Times, serif; text-decoration: underline;">
    Certificate of Analysis
</h2>

            <p style="margin-bottom: 1.5px;">No. ${nomorCoaValue}</p>
        </div>
         <div style="color: black; display: inline; font-size: 12px;">This is to certify that solder bar under the following particulars:</div>
        ${printArea.innerHTML}
<div style="text-align: right; position: relative; margin-top: 5px; width: 634px;">
    <!-- Tanggal dan Lokasi -->
<p style="margin: 0; font-weight: normal; font-size: 12px; text-align: right; padding-right: 10px;"> 
    <span id="date"></span>
</p>
<p style="margin: 0; font-weight: normal; font-size: 12px; text-align: right; padding-right: 13px;">
    Laboratory Supervisor
</p>

    <br><br><br><br>
    <u style="margin-bottom: 0px; font-weight: bold; font-size: 11px; text-align: right;">
        SELFIRA ARUM ANDADARI
    </u>
</div>

    `;

    // Simpan isi asli halaman sebelum mencetak
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = `
<style>
    @media print {
        @page {
            margin: 0;
        }
        
        body {
            margin: 2cm;
            font-family: 'Times New Roman', sans-serif;
            color: black; /* Pastikan semua teks berwarna hitam */
        }

        table {
            width: 95%;
            border-collapse: collapse;
            
        }

        th, td {
            border: 1px solid black;
            padding: 0px;
            font-size: 9px;
            color: black; /* Warna teks di tabel */
        }
        
        col input,
        col label,
        col span {
            border: 1px solid black;
            padding: 1px;
            font-size: 10px;
            color: black; /* Warna teks pada input, label, span */
        }

        /* Pastikan seluruh elemen teks yang relevan berwarna hitam */
        .col input,
        .col label,
        .col span,
        .col textarea,
        .col p,
        .panel-body p,
        .card-header h6,
        .breadcrumb li,
        .breadcrumb a,
        .form-group,
        .weight-input,
        #mainTable,
        .breadcrumb {
            font-size: 10px; /* Ukuran font menjadi 10px */
            padding: 0px; /* Menambahkan padding pada input dan textarea */
            color: black; /* Pastikan semua warna teks hitam */
        }
        /* Menyembunyikan dropdown saat print */
        .form-group {
            display: none;
        }
        div[style*="margin-bottom: 1px;"] {
            display: none !important;
        }
    }
    </style>
        ${customPrintContent}
    `;

    // Menambahkan tanggal otomatis dalam format "Cilegon, 31 January 2025"
    const dateElement = document.getElementById("date");
    const currentDate = new Date();
    const day = currentDate.getDate();
    const monthIndex = currentDate.getMonth();
    const year = currentDate.getFullYear();

    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const formattedDate = `Cilegon, ${day} ${months[monthIndex]} ${year}`;
    dateElement.textContent = formattedDate;

    // Cetak halaman
    window.print();

    // Kembalikan halaman ke tampilan awal setelah cetak selesai
    document.body.innerHTML = originalContents;
    location.reload();
}
</script>

<script>
    function updateTotalWeight() {
    let totalWeight = 0;

    // Loop semua input dengan class "weight-input"
    document.querySelectorAll('.weight-input').forEach(input => {
        const weight = parseFloat(input.value) || 0; // Pastikan nilai numerik
        totalWeight += weight;
    });

    // Update tampilan total weight
    document.getElementById("totalWeight").innerText = totalWeight.toFixed() + " kg";
}

    </script>
<script>
  // Mendapatkan elemen dengan id "date"
  var dateElement = document.getElementById("date");

  // Membuat objek Date untuk mendapatkan tanggal saat ini
  var currentDate = new Date();

  // Mendapatkan tanggal, bulan, dan tahun
  var day = currentDate.getDate();
  var month = currentDate.getMonth() + 1; // Bulan dimulai dari 0, jadi perlu ditambah 1
  var year = currentDate.getFullYear();

  // Format menjadi string: dd/mm/yyyy
  var formattedDate = day + "/" + month + "/" + year;

  // Menampilkan tanggal yang sudah diformat ke elemen dengan id "date"
  dateElement.textContent = formattedDate;
</script>

<script>
    // Fungsi untuk filter batch
    function filterBatch() {
        var input, filter, select, options, option, i, txtValue;
        input = document.getElementById("filterBatch");
        filter = input.value.toUpperCase();
        select = document.getElementById("dropdownPengajuan");
        options = select.getElementsByTagName("option");

        // Loop melalui semua opsi dan sembunyikan yang tidak cocok dengan filter batch
        for (i = 0; i < options.length; i++) {
            option = options[i];
            txtValue = option.textContent || option.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                option.style.display = "";
            } else {
                option.style.display = "none";
            }
        }
    }

    // Ambil data pengajuan berdasarkan ID yang dipilih
    function fetchPengajuanData(pengajuanId) {
        if (!pengajuanId) return;

        fetch(`/path/to/ajax/route/${pengajuanId}`)
            .then(response => response.json())
            .then(data => {
                // Gunakan data yang diterima untuk memperbarui elemen tampilan
                console.log(data);
            });
    }
</script>
<style>
    .form-container {
        display: flex;
        flex-direction: column;
        margin-top: 15px;
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .filter-label, .dropdown-label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .form-control:focus {
        border-color: #5cb85c;
        outline: none;
    }
</style>
@endsection
