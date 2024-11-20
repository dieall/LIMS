<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pengajuan Sampel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            h1 {
                margin-bottom: 10px;
            }

            table {
                margin: 0;
            }

            .no-print {
                display: none; /* Sembunyikan elemen ini saat mencetak */
            }
        }
    </style>
</head>
<body>
    <h1>Daftar Pengajuan Sampel</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Tipe Sampel</th>
                <th>Batch</th>
                <th>Deskripsi</th>
                <th>Nama</th>
                <!-- Tambahkan kolom lainnya sesuai dengan tabel Anda -->
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->id }}</td>
                    <td>{{ $transaksi->tgl }}</td>
                    <td>{{ $transaksi->category->nama_kategori }}</td>  
                    <td>{{ $transaksi->tipe_sampel }}</td>
                    <td>{{ $transaksi->batch }}</td>
                    <td>{{ $transaksi->deskripsi }}</td>
                    <td>{{ $transaksi->nama }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" class="btn btn-success">Print</button>
    </div>

    <script>
        window.print(); // Untuk mencetak halaman secara otomatis saat dibuka
    </script>
</body>
</html>
