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
        <h6 class="m-0 font-weight-bold">Cetak CoA Lokal | {{ $pengajuansolder->tipe_solder }}</h6>
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
                    <input type="text" id="compositions" name="compositions" value="{{ $pengajuansolder->spesification ?? '-' }}" class="form-control">
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
            </div>X 
        </div>

        <textarea name="w3review" class="form-control" style="margin-top: 20px;">
            We further certify that the analysis of the below mentioned lot as follows:
        </textarea>
        
        <br>
        
        <table style="width: 70%; border-collapse: collapse; border: 1px solid black; text-align: center;" id="mainTable">
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
        <td style="border: 1px solid black; padding: 5px;">{{ $pengajuansolder->DataSolder->$field ?? '-' }}</td>
        <td style="border: 1px solid black; padding: 5px;">{{ $pengajuansolder->$field ?? '-' }}</td>
    </tr>
    @endforeach
</tbody>
<tfoot>
    <tr id="weightRow">
        <td colspan="2" style="border: 1px solid black; padding: 5px; text-align: center; font-weight: bold;">
            Weight (Kg)
        </td>
        <td style="border: 1px solid black; padding: 5px;">
            <input type="number" id="weight-0" class="weight-input"
                   style="width: 100%; border: none; padding: 5px; text-align: center;"
                   oninput="updateTotalWeight()">
        </td>
    </tr>
    <tr>


</tfoot>

</table>

<div style="margin-top: 20px;">
    <!-- Dropdown untuk mengganti data di tabel -->
    <select id="dropdownPengajuan" name="dropdownPengajuan" style="width: 100%; padding: 5px; margin-bottom: 10px;" onchange="fetchPengajuanData(this.value)">
        <option value="" selected disabled>Pilih Pengajuan</option>
        @foreach ($allPengajuanSolder as $pengajuan)
            <option value="{{ $pengajuan->id }}">Lot No: {{ $pengajuan->batch ?? '-' }} - Prod. Date: {{ $pengajuan->tgl ?? '-' }}</option>
        @endforeach
    </select>
</div>

<br>
<div style="font-size: 18px; font-weight: bold; margin-top: 10px;">
    Total Weight: <span id="totalWeight">0.00</span> 
</div>
    </div></div>
<div class="mt-3">
        <a href="{{ route('pengajuansolder.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="javascript:void(0)" class="btn btn-success" onclick="printData()">Print</a>
      
    </div>


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
                newCell.textContent = data[field] ?? '-';
                row.appendChild(newCell);
            }

            // Tambahkan input weight baru di footer (row weight)
            const newWeightCell = document.createElement("td");
            newWeightCell.style.border = "1px solid black";
            newWeightCell.style.padding = "5px";
            newWeightCell.innerHTML = `<input type="number" class="weight-input"
                                        style="width: 100%; border: none; padding: 5px; text-align: center;"
                                        oninput="updateTotalWeight()">`;
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
@endsection
