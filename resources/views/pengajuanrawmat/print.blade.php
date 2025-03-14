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
    <div class="card-body" id="print-area">
        <div class="coa-label-container">
            <div class="coa-label">
                <div class="coa-header">
                </div>
                <table class="coa-table">
                    <tr>
                        <th>ID Sample</th>
                        <td><input type="text" class="form-control" name="nama" value=""></td>
                    </tr>
                    <tr>
                        <th>Date of Sampling</th>
                        <td><input type="text" class="form-control" id="date_of_release" name="nama" value=""></td>
                    </tr>
                    <tr>
                        <th>Time of Sampling</th>
                        <td><input type="text" class="form-control" name="nama" value=""></td>
                    </tr>
                    <tr>
                        <th>Date of Analysis</th>
                        <td><input type="text" class="form-control" name="nama" value="{{ \Carbon\Carbon::parse($pengajuanrawmat->tgl)->format('d F Y') }}"></td>
                    </tr>
                    <tr>
                        <th>Type Product</th>
                        <td><input type="text"  class="form-control" name="nama" value="{{ $pengajuanrawmat->nama }}"></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><input type="text"  class="form-control" name="nama" value=""></td>
                    </tr>

                </table>
                
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('pengajuanrawmat.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="javascript:void(0)" class="btn btn-success" onclick="printData()">Print</a>
        </div>
    </div>
</div>

<script>
function printData() {
    const printArea = document.getElementById('print-area');
    const clonePrintArea = printArea.cloneNode(true);

    const inputs = clonePrintArea.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        const span = document.createElement('span');
        span.textContent = input.value || '-';
        input.parentNode.replaceChild(span, input);
    });

    const customPrintContent = `${clonePrintArea.innerHTML}`;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = `
 <style>
    @media print {
        @page {
            margin-top: 1.5mm;    /* Mengatur margin atas */
            margin-right: 0mm;  /* Mengatur margin kanan */
            margin-bottom: 0.7mm; /* Mengatur margin bawah */
            margin-left: 0.5mm;   /* Mengatur margin kiri */
        }

        html, body {
            margin-top: 1.5mm;    /* Mengatur margin atas */
            margin-right: 0mm;  /* Mengatur margin kanan */
            margin-bottom: 0.7mm; /* Mengatur margin bawah */
            margin-left: 0.5mm;   /* Mengatur margin kiri */
            width: 50mm; /* Ukuran lebar label thermal */
            height: 30mm; /* Ukuran tinggi label thermal */
            font-family: 'Times New Roman', sans-serif;
            color: black;
        }

        body {
            display: block;
            font-size: 14px; /* Mengurangi ukuran font */
            line-height: 0.1;
            padding-top: 0;
            margin-top: 0;
            height: 100%;
            width: 100%;
            overflow: hidden; /* Mencegah konten terpotong */
        }

        .coa-label {
            width: 100%;
            padding: 0;
            border: 1px solid black;
            font-family: 'Arial', sans-serif;
            box-sizing: border-box;
        }

        .coa-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0,1;
        }

        .coa-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        .coa-table th, .coa-table td {

            padding: 6.5px;
            border: 1px solid black;
            font-size: 9px; /* Ukuran font lebih kecil untuk mencegah pemotongan */
        }
        /* Menyembunyikan tombol Print dan Kembali saat mencetak */
        .mt-3 {
            display: none;
        }
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
    /* Custom styling for the label */
    .coa-label-container {
        display: flex;  
        justify-content: space-between;
        gap: 15px;
    }

    .coa-label {
        width: 32%; /* Set the width to 1/3rd of the container */
        padding: 10px;
        font-family: Arial, sans-serif;
        border: 1px solid #000;
    }

    .coa-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .coa-header .logo img {
        width: 30px;
    }

    .coa-header .label-title h4 {
        margin: 0;
        font-weight: bold;
        color: #007bff;
    }

    .coa-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .coa-table th, .coa-table td {
        text-align: left;
        padding: 5px;
        border: 1px solid black;
    }

 
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the current date
        const today = new Date();

        // Create a list of months for formatting
        const months = [
            "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
        ];

        // Get the day, month, and year
        const day = today.getDate();
        const month = months[today.getMonth()];
        const year = today.getFullYear();

        // Format the date as "d F Y" (e.g., "4 February 2025")
        const formattedDate = `${day} ${month} ${year}`;

        // Set the formatted date as the value of the input field
        document.getElementById('date_of_release').value = formattedDate;
    });
</script>

@endsection
