<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Lokal</title>
    <style>
        /* Tambahkan gaya khusus untuk tampilan cetak */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Certificate of Analysis</h1>
        <p><strong>Nama Sampel:</strong> {{ $pengajuanChemical->nama_chemical }}</p>
        <p><strong>Batch:</strong> {{ $pengajuanChemical->batch }}</p>
        <p><strong>Status:</strong> {{ $pengajuanChemical->status }}</p>
        
        <!-- Tambahkan detail lain sesuai kebutuhan -->
        <table>
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jam Pengajuan</td>
                    <td>{{ \Carbon\Carbon::parse($pengajuanChemical->jam_masuk)->format('H:i') }}</td>
                </tr>
                <tr>
                    <td>Nama Pengaju</td>
                    <td>{{ $pengajuanChemical->orang }}</td>
                </tr>
                <!-- Tambahkan data lain jika perlu -->
            </tbody>
        </table>
    </div>
    <script>
        window.onload = function() {
            window.print(); // Otomatis mencetak saat halaman dimuat
        }
    </script>
</body>
</html>
