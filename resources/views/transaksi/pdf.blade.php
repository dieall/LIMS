<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Pastikan meta tag ini ada -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print PDF Layout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
        }

        .header, .footer {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            font-size: 11px;
            width: 28%;
            border-collapse: collapse; /* Menghilangkan jarak antar border */
        }

        table, th, td {
            border: 1px solid black;
            padding: 4px; /* Atur padding untuk sel tabel */
            text-align: left;
            line-height: 1.2; /* Atur tinggi baris */
        }

        th {
            background-color: #f2f2f2;
        }

        /* CSS untuk bagian footer yang tidak menggunakan Flexbox */
        .footer-info {
            margin: 20px 0;
            display: flex;
            flex-direction: column; /* Menyusun elemen secara vertikal */
            gap: 10px; /* Jarak antara elemen */
        }

        .footer-row {
            display: flex;
            justify-content: space-between; /* Mengatur agar teks dan nilainya sejajar */
            align-items: center;
        }

        .footer-row h5 {
            margin: 0;
            font-size: 10px;
            line-height: 1.5;
        }

        .footer-row span {
            font-size: 10px;
            line-height: 1.5;
        }

        /* Hilangkan border pada tabel di footer */
        .remarks td, .footer-table td {
            border: none;
        }
        .footer-table {
            width: 25%; /* Atur lebar tabel sesuai kebutuhan */
            margin: 5px; /* Memusatkan tabel di halaman */
            border-collapse: collapse; /* Menghilangkan jarak antar border */
        }
        
        .footer-table td {
            border: none; /* Menghilangkan border pada sel tabel */
            padding: auto; /* Menambahkan padding di dalam sel */
            text-align: left; /* Mengatur teks di dalam sel ke kiri */
        }
        .centered {
            text-align: center; /* Memusatkan teks */
        }

        .narrow {
            width: 100px; /* Mengatur lebar kolom */
        }

        .custom-table {
            font-size: 11px;
            width: 100%;
            border-collapse: collapse; /* Menghilangkan jarak antar border */
        }

        .custom-table th, .custom-table td {
            border: 1px solid black;
            padding: 3px; /* Atur padding untuk sel tabel */
            text-align: center; /* Memusatkan seluruh teks dalam tabel */
            line-height: 1.2; /* Atur tinggi baris */
        }
    </style>
</head>
<body>

    <div class="header">
        <h5>BQR Lab / MT-630</h5>
    </div>
    <!-- Bagian informasi di footer -->
    <div class="footer-info">
        <div class="footer-row">
            <h5>Date : {{ \Carbon\Carbon::now()->format('d-m-Y') }}</h5>
        </div>
        <div class="footer-row">
            <h5>Batch / Lot : {{ $transaksi->batch }}</h5>
        </div>
        <div class="footer-row">
            <h5>Description : {{ $transaksi->deskripsi }}</h5>
        </div>
    </div>

    <div class="footer-row">
        <h5>Data Quality Product :</h5>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th class="centered">No.</th>
                <th class="centered narrow">Parameter/Calculation</th>
                <th class="centered">Specification</th>
                <th class="centered">Methods</th>
                <th class="centered narrow">Result</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="centered">1</td>
                <td class="centered">Clarity</td>
                <td class="centered">Clear</td>
                <td class="centered">Visual Inspection</td>
                <td class="centered"></td>
            </tr>
            <tr>
                <td class="centered">2</td>
                <td class="centered">% Transmission</td>
                <td class="centered">&gt; 98</td>
                <td class="centered">Spectrophotometric</td>
                <td class="centered"></td>
            </tr>
            <tr>
                <td class="centered">3</td>
                <td class="centered">% Tin</td>
                <td class="centered">19.0 &plusmn; 0.2</td>
                <td class="centered">X-Ray Fluorescence</td>
                <td class="centered"></td>
            </tr>
            <tr>
                <td class="centered">4</td>
                <td class="centered">RI @ 25°C</td>
                <td class="centered">1.509 &plusmn; 0.002</td>
                <td class="centered">Refractometer</td>
                <td class="centered"></td>
            </tr>
            <tr>
                <td class="centered">5</td>
                <td class="centered">SG @ 25°C</td>
                <td class="centered">1.17 &plusmn; 0.01</td>
                <td class="centered">Density Meter</td>
                <td class="centered"></td>
            </tr>
            <tr>
                <td class="centered">6</td>
                <td class="centered">Acid Value</td>
                <td class="centered">Max 3</td>
                <td class="centered">Acidimetric Titration</td>
                <td class="centered"></td>
            </tr>
            <tr>
                <td class="centered">7</td>
                <td class="centered">% Sulfur</td>
                <td class="centered">12.0 &plusmn; 0.5</td>
                <td class="centered">Iodimetric Titration</td>
                <td class="centered"></td>
            </tr>
            <tr>
                <td class="centered">8</td>
                <td class="centered">Water Content</td>
                <td class="centered">&lt; 3.5</td>
                <td class="centered">Karl Fischer</td>
                <td class="centered"></td>
            </tr>
            <tr>
                <td class="centered">9</td>
                <td class="centered">Yellowish Index</td>
                <td class="centered">&lt; 9.0</td>
                <td class="centered">Spectrophotometric</td>
                <td class="centered"></td>
            </tr>
            <tr>
                <td class="centered">10</td>
                <td class="centered">2-EH</td>
                <td class="centered">&lt; 0.7</td>
                <td class="centered">Gas Chromatograpy</td>
                <td class="centered"></td>
            </tr>
            <tr>
                <td class="centered">11</td>
                <td class="centered">Viscosity @ 25°C</td>
                <td class="centered">40 - 80 cps</td>
                <td class="centered">Viscometer</td>
                <td class="centered"></td>
            </tr>
            <tr>
                <td class="centered">12</td>
                <td class="centered">Pt-Co</td>
                <td class="centered">
  <span style="text-decoration: underline;">&lt;</span> 30
</td>

                <td class="centered">Visual Inspection</td>
                <td class="centered"></td>
            </tr>
            <tr>
                <td class="centered">13</td>
                <td class="centered">Monomethyltin</td>
                <td class="centered">16.5% - 24.5%</td>
                <td class="centered">NMR</td>
                <td class="centered"></td>
            </tr>
        </tbody>
    </table>
    <div style="font-size: 8px; font-style: italic; margin-left: 260px;">
    (1) Mandatory Half Drumming Monitoring<br>
    (2) Mandatory Beginning & Last Drumming Monitoring<br>
    (3) Mandatory Storage Blending / Circulation Monitoring<br>
    (4) Mandatory After Filter Monitoring<br>
    (5) Mandatory Drying Monitoring
</div>

    <div style="width: 100%; position: relative;">
    <table style="float: left; border: 1px solid black; margin-right: 10px;">
        <tr>
            <td style="text-align: center;"><b>Analyzed by</b></td>
        </tr>
        <tr>
            <td style="text-align: center;"><b>Lab Analyst</b></td>
        </tr>
        <tr>
            <td>
                <br><br><br><br><br>
                <hr>Nama : {{ $transaksi->nama }}<br>
                <hr>NIK :<br>
            </td>
        </tr>
    </table>

    <table style="float: right; border: 1px solid black; margin-left: 10px; font-size: 11px;">
        <tr>
            <td style="text-align: center; font-size: 11px;"><b>Checked By</b></td>
        </tr>
        <tr>
            <td style="text-align: center; font-size: 11px;"><b>Lab Supervisor</b></td>
        </tr>
        <tr>
            <td>
            <br><br><br><br><br>
                <hr>Nama : Selfira Arum Andadari<br>
                <hr>Nik :<br>
            </td>
        </tr>
    </table>
</div>

<br>
<br>

<br>
<br>
<br>
<br>
<br>
<br>
<br>

<!-- Quality Checklist Table -->
<table border="1" style="border-collapse: collapse; width: 100%; margin-top: 20px; font-size: 10px;">
    <tr>
    <th style="width: 10%; text-align: center; font-size: 11px;">Check</th>
        <th style="width: 50%; text-align: center; font-size: 11px;">Quality Checklist</th>
        <th style="width: 40%; text-align: center; font-size: 11px;">Remarks</th>
        
    </tr>
    <tr>
    <td style="text-align: center; font-size: 11px;"><input type="checkbox"></td>
        <td><b>PASSED</b></td>
        <td></td>
        
    </tr>
    <tr>
    <td style="text-align: center;"><input type="checkbox"></td>
        <td><b>NO PASSED</b></td>
        <td></td>
        
    </tr>
    <tr>
    <td style="text-align: center;"><input type="checkbox"></td>
        <td><b>CONDITIONAL PASSED</b></td>
        <td></td>
        
    </tr>
</table>

<div style="width: 100%; position: relative;">
    <table style="float: left; border: 1px solid black; margin-right: 100px;">
        <tr>
            <td style="text-align: center;"><b>Operator</b></td>
        </tr>
        <tr>
            <td style="text-align: center;"><b>QC</b></td>
        </tr>
        <tr>
            <td>
            <br><br><br><br><br>
                <hr>Nama :<br>
                <hr>Nik :<br>
            </td>
        </tr>
    </table>

    <table style="float: right; border: 1px solid black; margin-left: 10px;">
        <tr>
            <td style="text-align: center;"><b>Verified By</b></td>
        </tr>
        <tr>
            <td style="text-align: center;"><b>Lab Supervisor</b></td>
        </tr>
        <tr>
            <td>
            <br><br><br><br><br>
                <hr>Nama : Rangkum Sembodo<br>
                <hr>Nik :<br>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
