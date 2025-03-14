@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cetak CoA Ekspor</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold">Cetak CoA Ekspor | {{ $pengajuanchemical->nama }}</h6>
    </div>

    <div class="card-body" id="print-area">
        <div class="row">
            <div class="col">
                <table class="data-table" id="dynamic-table">
                    <tr>
                        <th>Nomor CoA</th>
                        <td><input type="text" class="form-control" name="nomor_coa"></td>
                    </tr>
                    <tr>
                        <th>Brand</th>
                        <td><input type="text" class="form-control" name="nama" value="{{ $pengajuanchemical->nama }}" style="font-weight: bold"></td>
                    </tr>
                    <tr>
                        <th>Lot No</th>
                        <td><input type="text" class="form-control" name="nama" value="{{ $pengajuanchemical->batch }}"></td>
                    </tr>
                    <tr>
                        <th>Date Of Inspection</th>
                        <td><input type="date" class="form-control" name="date_of_inspection" required></td>
                    </tr>
                    <tr>
                        <th>Date Of Release</th>
                        <td><input type="date" class="form-control" name="date_of_release" required></td>
                    </tr>
                    <tr>
                        <th>PO Number</th>
                        <td><input type="text" class="form-control" name="po_number" required></td>
                    </tr>
                    <tr>
                        <th>Net Weight</th>
                        <td>
                            <input type="text" class="form-control" name="net_weight" required>
                            <span>kg</span>
                        </td>
                    </tr>
                </table>
           
            </div>
        </div>
        <br>
  
        <textarea name="w3review" class="form-control">
    The undersigned hereby certifies the following data to be true specification of the obtained results of tests and assays.</p>
    Manufacture name at PT. TIMAH INDUSTRI
        </textarea>
        <br>
        <table style="width: 70%; border-collapse: collapse; border: 1px solid black;">
    <thead>
        <tr style="background-color: #f2f2f2; border: 1px solid black;">
        <th style="padding: 8px; text-align: center; border: 1px solid black; font-style: italic;">Test</th>
        <th style="padding: 8px; text-align: center; border: 1px solid black; font-style: italic;">Specification</th>
        <th style="padding: 8px; text-align: center; border: 1px solid black; font-style: italic;">Result</th>

            <th style="padding: 8px; text-align: center; border: 1px solid black;">Action</th> <!-- Kolom Action -->
        </tr>
    </thead>
    <tbody>
        @if ($pengajuanchemical->dataChemical)
            @php
                $fields = [
                    'clarity' => 'Clarity',
                    'transmission' => 'Transmission',
                    'ape' => 'Appearance',
                    'dimet' => 'Dimethyltin Dichloride',
                    'trime' => 'Trimethyltin Trichloride',
                    'tin' => 'Tin Content',
                    'solid' => 'Solid Content',
                    'ri' => 'Refractive Index (25°C)',
                    'sg' => 'Specific Gravity (25°C)',
                    'acid' => 'Acid Value',
                    'sulfur' => 'Sulfur',
                    'water' => 'Water Content',
                    'mono' => 'Monomethyltin',
                    'yellow' => 'Yellowish Index',
                    'eh' => '2-EH',
                    'visco' => 'Viscosity @ 25°C',
                    'pt' => 'Pt-CO',
                    'moisture' => 'Moisture Content',
                    'cloride' => 'Cloride',
                    'spec' => 'Specific Gravity (25°C)',
                    'cla' => 'CLA',
                    'densi' => 'Density',
                ];
            @endphp

            @foreach ($fields as $field => $label)
                @if (!empty($pengajuanchemical->dataChemical->$field))
                    <tr style="border: 1px solid black;">
                        <td style="padding: 8px; text-align: left; border: 1px solid black;">{{ $label }}</td>
                        <td style="padding: 8px; text-align: center; border: 1px solid black;">{{ $pengajuanchemical->dataChemical->$field }}</td>
                        <td style="padding: 8px; text-align: center; border: 1px solid black;">{{ $pengajuanchemical->$field ?? '-' }}</td>
                        <td style="padding: 8px; text-align: center; border: 1px solid black;">
                            <button class="btn btn-danger btn-sm" onclick="deleteRow(this)">X</button>
                        </td> <!-- Tombol Hapus -->
                    </tr>
                @endif
            @endforeach
        @else
            <tr>
                <td colspan="4" style="padding: 8px; text-align: center; border: 1px solid black;">Data chemical tidak ditemukan</td>
            </tr>
        @endif
    </tbody>
</table>


    </div></div>

    <div class="mt-3">
        <a href="{{ route('pengajuanchemical.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="javascript:void(0)" class="btn btn-success" onclick="printData()">Print</a>
        <button class="btn btn-primary" type="button" id="add-row-button">Tambah Baris</button>
 
</div>




<script>
    function deleteRow(button) {
        // Akses elemen <tr> dari tombol yang ditekan
        const row = button.parentNode.parentNode;

        // Hapus baris dari tabel
        row.parentNode.removeChild(row);
    }
</script>
<script>
    // Script untuk menambahkan baris baru ke tabel dengan input untuk label
    document.getElementById('add-row-button').addEventListener('click', function() {
        // Meminta input untuk label (field)
        const fieldLabel = prompt("Masukkan nama field (label):", "");
        if (!fieldLabel) return; // Jika label kosong, keluar dari fungsi

        const table = document.getElementById('dynamic-table');
        
        // Membuat elemen baris baru
        const newRow = document.createElement('tr');
        
        // Isi kolom pertama (label)
        const newLabelCell = document.createElement('th');
        newLabelCell.textContent = fieldLabel;
        newRow.appendChild(newLabelCell);
        
        // Isi kolom kedua (input)
        const newInputCell = document.createElement('td');
        const newInput = document.createElement('input');
        newInput.type = "text";
        newInput.className = "form-control";
        newInput.name = `${fieldLabel.toLowerCase().replace(/\s+/g, '_')}`; // Nama field dinamis
        newInputCell.appendChild(newInput);
        newRow.appendChild(newInputCell);
        
        // Menambahkan baris ke tabel
        table.appendChild(newRow);
    });
</script>
<script>
function printData() {
    const printArea = document.getElementById('print-area');
    const clonePrintArea = printArea.cloneNode(true);

    // Ambil nilai dari input "Nomor CoA"
    const nomorCoaInput = document.querySelector('input[name="nomor_coa"]');
    const nomorCoaValue = nomorCoaInput ? nomorCoaInput.value.trim() : '-';

    // Hapus kolom Action dari salinan tabel untuk mode cetak
    const actionHeaders = clonePrintArea.querySelectorAll('th:nth-child(4)');
    const actionCells = clonePrintArea.querySelectorAll('td:nth-child(4)');
    actionHeaders.forEach(header => header.remove());
    actionCells.forEach(cell => cell.remove());

    const inputs = clonePrintArea.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        const span = document.createElement('span');
        span.textContent = input.value || '-';
        input.parentNode.replaceChild(span, input);
    });

    const customPrintContent = `
    <br>

    <br>
        <div style="text-align: center; margin-top: 20px;">
           <h2 style="margin: 0; font-size: 40px; font-weight: bold; font-family: 'Times New Roman', Times, serif;">
                Certificate of Analysis
            </h2>
            <p style="margin: 5px 0;">No. ${nomorCoaValue}</p>
        </div>
        ${clonePrintArea.innerHTML}
 <div style="text-align: right; position: relative; margin-top: 150px;">
    <p style="margin: 0; font-weight: bold;">SELFIRA ARUM ANDADARI</p>
    <div style="border-top: 2px solid black; width: 187px; margin: 10px 0 0 auto; position: relative;"></div>
    <p style="margin: 5px 0 0 auto; font-weight: bold; text-align: right; width: 250px;">Laboratory Spv</p>
</div>
    `;

    const originalContents = document.body.innerHTML;

    document.body.innerHTML = `     
        <style>
            @media print {
                @page { margin: 0; }
                body { margin: 1cm; font-family: 'Times New Roman', sans-serif; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid black; padding: 4px; font-size: 10px; }
                
            }
        </style>
        ${customPrintContent}
    `;

    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}
</script>



<style>
    th {
    font-style: italic;
}
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
    @media print {
        .data-table th:nth-child(4), /* Header kolom Action */
        .data-table td:nth-child(4), /* Isi kolom Action */
        
        button { /* Semua tombol */
            display: none; /* Sembunyikan */
            
        }
    }
</style>
@endsection
