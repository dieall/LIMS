@extends('layouts.app')

@section('contents')

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
        <h6 class="m-0 font-weight-bold">Cetak CoA Lokal| {{ $pengajuansolder->tipe_solder }}</h6>
    </div>

    <div class="card-body" id="print-area">
        
    <div class="row">
    <div class="col" font-size="10px">
    <div style="margin-bottom: 1px;">
    <label for="nomor_coa" style="display: inline-block; width: 200px;">CoA Number</label>
    <span style="margin-left: 5px;">:</span>
    <input type="text" id="nomor_coa" name="nomor_coa" class="form-control">
</div>
    <div style="margin-top: 1px;">
    <label for="product" style="display: inline-block; width: 200px;">Product</label>
    <span style="margin-left: 5px;">:</span>
    <input type="text" id="product" name="product" value="{{ $pengajuansolder->tipe_solder }}" class="form-control">
</div>

<div style="margin-top: 1px;">
    <label for="compositions" style="display: inline-block; width: 200px;">Composition</label>
    <span style="margin-left: 5px;">:</span>
    <input type="text" id="compositions" name="compositions" value="{{ $pengajuansolder->DataSolder->spesification }}" class="form-control">
</div>

<div style="margin-top: 1px;">
    <label for="marks" style="display: inline-block; width: 200px;">Marks</label>
    <span style="margin-left: 5px;">:</span>
    <input type="text" id="marks" name="marks" class="form-control">
</div>

<div style="margin-top: 1px;">
    <label for="number_of_boxes" style="display: inline-block; width: 200px;">Number of Boxes</label>
    <span style="margin-left: 5px;">:</span>
    <input type="text" id="number_of_boxes" name="number_of_boxes" class="form-control">
</div>
    </div>
</div>

<div style="padding-top: 5px;"></div> <!-- Menambahkan jarak di atas elemen lain -->
        <textarea name="w3review" class="form-control">
        We further certify that the analysis of the below mentioned lot as follows :
        </textarea>
        <div style="padding-top: 5px;"></div> <!-- Menambahkan jarak di atas elemen lain -->
     <table style="width: 65%; border-collapse: collapse; border: 1px solid black; text-align: center;">
     <thead>
    <tr>
        <th rowspan="2" style="border: 1px solid black; padding: 5px;">Composition</th>
        <th style="border: 1px solid black; padding: 5px;">Standard (%)</th>
        <th style="border: 1px solid black; padding: 5px;">Lot No. {{ $pengajuansolder->batch ?? '-' }}</th>
    </tr>
    <tr>
        <th style="border: 1px solid black; padding: 5px;">Prod. Date</th>
        <th style="border: 1px solid black; padding: 5px;">{{ $pengajuansolder->tgl ?? '-' }}</th>
        <th rowspan="2" style="border: 1px solid black; padding: 5px;">Action</th> <!-- Kolom Action dengan rowspan="2" -->
    </tr>
</thead>
    <tbody>
    @if ($pengajuansolder->DataSolder)
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
            @if (!empty($pengajuansolder->DataSolder->$field)) <!-- Mengecek jika data ada -->
                <tr>
                <td style="padding: 5px; padding-top: 1px; text-align: center; border: 1px solid black;">{{ $label }}</td>
                <td style="padding: 3px; padding-top: 3px; text-align: center; border: 1px solid black;">{{ $pengajuansolder->DataSolder->$field }}</td>
                <td style="padding: 3px; padding-top: 3px; text-align: center; border: 1px solid black;">{{ $pengajuansolder->$field ?? '-' }}</td>
                                      <td style="padding: 8px; text-align: center; border: 1px solid black;">
                            <button class="btn btn-danger btn-sm" onclick="deleteRow(this)">X</button>
                        </td> <!-- Tombol Hapus -->
                    
                </tr>
            @endif
        @endforeach

    @else
        <tr>
            <td colspan="3" style="border: 1px solid black; padding: 5px;">Data chemical tidak ditemukan</td>
        </tr>
    @endif
</tbody>
<tfoot>
        <tr id="weightRow">
            <td colspan="2" style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
                Weight (Kg)
            </td>
            <td style="border: 1px solid black; padding: 3px;">
            <input type="number" class="weight-input" style="width: 100%; padding: 5px;" placeholder="Masukan Kg Disini ! ! !" oninput="updateTotalWeight()" /> Kg
            </td>
        </tr>
    </tfoot>
    
</table>
<br>
Total Weight: <span id="totalWeight">0</span> kg
    </div></div>

    <div class="mt-3">
        <a href="{{ route('pengajuansolder.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="javascript:void(0)" class="btn btn-success" onclick="printData()">Print</a>
      
    </div>

<script>
    function updateTotalWeight() {
        var weight = document.querySelector(".weight-input").value;

        document.getElementById("totalWeight").innerText = weight ? weight : 0;
    }
</script>


<script>
    function deleteRow(button) {
        // Akses elemen <tr> dari tombol yang ditekan
        const row = button.parentNode.parentNode;

        // Hapus baris dari tabel
        row.parentNode.removeChild(row);
    }
</script>

<script>
function printData() {
    const printArea = document.getElementById('print-area');
    const clonePrintArea = printArea.cloneNode(true);

    // Ambil nilai dari input "Nomor CoA"
    const nomorCoaInput = document.querySelector('input[name="nomor_coa"]');
    const nomorCoaValue = nomorCoaInput ? nomorCoaInput.value.trim() : '-';

    // Hapus kolom "Action" dari tabel sebelum mencetak
    const actionHeaders = clonePrintArea.querySelectorAll('th');
    const actionCells = clonePrintArea.querySelectorAll('td');

    actionHeaders.forEach(header => {
        if (header.textContent.trim().toLowerCase() === 'action') {
            header.remove();
        }
    });

    actionCells.forEach(cell => {
        if (cell.textContent.trim().toLowerCase() === 'x' || cell.querySelector('button')) {
            cell.remove();
        }
    });

    // Mengambil nilai Total Weight dari elemen <span id="totalWeight">
    const totalWeight = document.getElementById("totalWeight").textContent;

    // Menambahkan total weight ke dalam bagian yang dicetak
    const totalWeightRow = `
        <tr>
            <td colspan="2" style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
                Weight (Kg)
            </td>
            <td style="border: 1px solid black; padding: 3px;">
                ${totalWeight} kg
            </td>
        </tr>
    `;

    // Menambahkan baris total weight ke dalam clonePrintArea
    const tfoot = clonePrintArea.querySelector('tfoot');
    tfoot.innerHTML = totalWeightRow;

    // Ubah semua input menjadi teks biasa agar dapat dicetak
    const inputs = clonePrintArea.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        const span = document.createElement('span');
        span.textContent = input.value || '-';
        input.parentNode.replaceChild(span, input);
    });

    // Struktur untuk tampilan cetak
    const customPrintContent = `
    <br>
    <br>
   
        <div style="text-align: center; margin-top: 20px;">
           <h2 style="margin: 0; font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif;">
                Certificate of Analysis
            </h2>
            <p style="margin-bottom: 5px;">No. ${nomorCoaValue}</p>
        </div>
        This is to certify that solder bar under the following particulars:
        ${clonePrintArea.innerHTML}
        <div style="text-align: right; position: relative;">
            <!-- Tanggal dan Lokasi -->
            <p style="margin: 0; font-weight: normal; font-size: 12px; text-align: right; width: 680px; padding-right: 10px;" id="date"></p>
            <p style="margin: 0; font-weight: normal; font-size: 12px; text-align: right; width: 678px; padding-right: 10px;">PT TIMAH INDUSTRI</p>
            <br><br><br><br>

            <!-- Nama -->
            <u style="margin-top: 60px; font-weight: bold; font-size: 11px; text-align: right; padding-right: 10px;">SELFIRA ARUM ANDADARI</u>
            <p style="margin-top: 0px; font-weight: bold; font-size: 11px; text-align: right; width: 663px; padding-right: 15px;">Laboratory Spv</p>
        </div>

    `;
    

    // Simpan isi asli halaman
    const originalContents = document.body.innerHTML;

    // Ganti isi halaman dengan konten cetak
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
            padding: 1px;
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
            font-size: 13px; /* Ukuran font menjadi 10px */
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

    // Menambahkan tanggal otomatis dalam format "Cilegon, January 31, 2025"
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



<style>
    
    table.data-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid black;
       
    }

    .data-table th,
    .data-table td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
      
    }

    .data-table th:nth-child(1) {
        width: 20%;
    }

    .data-table td:nth-child(2) {
        width: 80%;
    }

    /* Aturan khusus untuk mode cetak */
    /* Aturan khusus untuk mode cetak */
    @media print {
        .data-table th:nth-child(4), /* Header kolom Action */
        .data-table td:nth-child(4), /* Isi kolom Action */
        
        button { /* Semua tombol */
            display: none; /* Sembunyikan */
            
        }
    }
</style>

@endsection
