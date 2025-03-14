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
    <div class="col">
    <div style="margin-bottom: 3px;">
    <label for="nomor_coa" style="display: inline-block; width: 200px;">Nomor CoA</label>
    <span style="margin-left: 5px;">:</span>
    <input type="text" id="nomor_coa" name="nomor_coa" class="form-control">
</div>
    <div style="margin-bottom: 3px;">
    <label for="product" style="display: inline-block; width: 200px;">Product</label>
    <span style="margin-left: 5px;">:</span>
    <input type="text" id="product" name="product" value="{{ $pengajuansolder->tipe_solder }}" class="form-control">
</div>

<div style="margin-bottom: 3px;">
    <label for="compositions" style="display: inline-block; width: 200px;">Compositions</label>
    <span style="margin-left: 5px;">:</span>
    <input type="text" id="compositions" name="compositions" value="{{ $pengajuansolder->DataSolder->spesification }}" class="form-control">
</div>

<div style="margin-bottom: 3px;">
    <label for="marks" style="display: inline-block; width: 200px;">Marks</label>
    <span style="margin-left: 5px;">:</span>
    <input type="text" id="marks" name="marks" class="form-control">
</div>

<div style="margin-bottom: 3px;">
    <label for="number_of_boxes" style="display: inline-block; width: 200px;">Number of Boxes</label>
    <span style="margin-left: 5px;">:</span>
    <input type="text" id="number_of_boxes" name="number_of_boxes" class="form-control">
</div>
    </div>
</div>

  
        <textarea name="w3review" class="form-control">
        We further certify that the analysis of the below mentioned lot as follows :
        </textarea>
     <br>
     <table style="width: 70%; border-collapse: collapse; border: 1px solid black; text-align: center;">
     <thead>
        <tr>
            <th rowspan="2" style="border: 1px solid black; padding: 5px;">Composition</th>
            <th style="border: 1px solid black; padding: 5px;">Standard (%)</th>
          <th style="border: 1px solid black; padding: 5px;">Lot No. {{ $pengajuansolder->batch ?? '-' }}</th>

        </tr>
        <tr>
            <th style="border: 1px solid black; padding: 5px;">Prod. Date</th>
            <th style="border: 1px solid black; padding: 5px;">{{ $pengajuansolder->tgl ?? '-' }}</th>
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
                    <td style="border: 1px solid black; padding: 5px;">{{ $label }}</td>
                    <td style="border: 1px solid black; padding: 5px;">{{ $pengajuansolder->DataSolder->$field }}</td>
                    <td style="border: 1px solid black; padding: 5px;">{{ $pengajuansolder->$field ?? '-' }}</td>
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
        <tr>
            <td colspan="2" style="border: 1px solid black; padding: 5px;">Weight (Kg)</td>
            <td style="border: 1px solid black; padding: 5px;">
    <input type="number" id="weightInput" name="weight" placeholder="Masukan Input Weight Disini !" style="width: 100%; border: none; padding: 5px; text-align: left;" oninput="updateTotalWeight()">
    kg
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
        var weight = document.getElementById("weightInput").value;
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
    <br>
    <br>
   
        <div style="text-align: center; margin-top: 20px;">
  <h2 style="margin: 0; font-size: 40px; font-weight: bold; font-family: 'Times New Roman', Times, serif; text-decoration: underline;">
    Certificate of Analysis
</h2>
            <p style="margin: 5px 0;">No. ${nomorCoaValue}</p>
        </div>
        This is to certify that solder bar under the following particulars:
            <br>
        ${clonePrintArea.innerHTML}
 <div style="text-align: right; position: relative; margin-top: 50px;">
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
                th, td { border: 1px solid black; padding: 1px; font-size: 10px; }
                
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
