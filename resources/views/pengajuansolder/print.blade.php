<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Solder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10px;
        }

        h1, h2, .section-title {
            color: #333;
            text-align: center;
            margin: 5px 0;
        }

        h1 {
            font-size: 1.2em;
        }

        h2, .section-title {
            font-size: 1em;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .container {
            width: 95%;
            margin: 10px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 9px;
        }

        table th, table td {
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
        }

        table th {
            background-color: #f9f9f9;
        }

        .info-table td {
            font-weight: bold;
            width: 25%;
        }

        .table-wrapper {
            margin-bottom: 10px;
        }

        .print-btn {
            text-align: center;
            margin: 10px 0;
        }

        .print-btn button {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .print-btn button:hover {
            background-color: #0056b3;
        }

        @media print {
            .print-btn {
                display: none;
            }

            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pengajuan Solder #{{ $pengajuansolder->id }}</h1>

        <!-- Informasi Pengajuan -->
        <div class="table-wrapper">
            <h2>Informasi Pengajuan</h2>
            <table class="info-table">
                <tr>
                    <td>Tanggal</td>
                    <td>{{ $pengajuansolder->tgl }}</td>
                </tr>
                <tr>
                    <td>Kategori</td>
                    <td>{{ $pengajuansolder->datasolder->nama_kategori ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Tipe Solder</td>
                    <td>{{ $pengajuansolder->tipe_solder }}</td>
                </tr>
                <tr>
                    <td>Jam Masuk</td>
                    <td>{{ $pengajuansolder->jam_masuk }}</td>
                </tr>
                <tr>
                    <td>Batch / Lot</td>
                    <td>{{ $pengajuansolder->batch }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>{{ $pengajuansolder->nama }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>{{ $pengajuansolder->status }}</td>
                </tr>
            </table>
        </div>

        <!-- Detail Solder -->
        <div class="table-wrapper">
    <h2>Detail Solder</h2>
    <table>
        @if($pengajuansolder->sn)
        <tr><th>Sn</th><td>{{ $pengajuansolder->sn }}</td></tr>
        @endif
        @if($pengajuansolder->ag)
        <tr><th>Ag</th><td>{{ $pengajuansolder->ag }}</td></tr>
        @endif
        @if($pengajuansolder->cu)
        <tr><th>Cu</th><td>{{ $pengajuansolder->cu }}</td></tr>
        @endif
        @if($pengajuansolder->pb)
        <tr><th>Pb</th><td>{{ $pengajuansolder->pb }}</td></tr>
        @endif
        @if($pengajuansolder->sb)
        <tr><th>Sb</th><td>{{ $pengajuansolder->sb }}</td></tr>
        @endif
        @if($pengajuansolder->zn)
        <tr><th>Zn</th><td>{{ $pengajuansolder->zn }}</td></tr>
        @endif
        @if($pengajuansolder->fe)
        <tr><th>Fe</th><td>{{ $pengajuansolder->fe }}</td></tr>
        @endif
        @if($pengajuansolder->as)
        <tr><th>As</th><td>{{ $pengajuansolder->as }}</td></tr>
        @endif
        @if($pengajuansolder->ni)
        <tr><th>Ni</th><td>{{ $pengajuansolder->ni }}</td></tr>
        @endif
        @if($pengajuansolder->bi)
        <tr><th>Bi</th><td>{{ $pengajuansolder->bi }}</td></tr>
        @endif
        @if($pengajuansolder->cd)
        <tr><th>Cd</th><td>{{ $pengajuansolder->cd }}</td></tr>
        @endif
        @if($pengajuansolder->ai)
        <tr><th>Ai</th><td>{{ $pengajuansolder->ai }}</td></tr>
        @endif
        @if($pengajuansolder->pe)
        <tr><th>Pe</th><td>{{ $pengajuansolder->pe }}</td></tr>
        @endif
        @if($pengajuansolder->ga)
        <tr><th>Ga</th><td>{{ $pengajuansolder->ga }}</td></tr>
        @endif
    </table>
</div>


        <!-- Status History -->
        <div class="table-wrapper">
            <h2>Status History</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jam Masuk</th>
                        <th>Status</th>
                        <th>Alasan Penolakan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($pengajuansolder->statusHistory as $history)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($history->changed_at)->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $history->status }}</td>
                            <td>{{ $history->rejection_reason ?? '-' }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($pengajuansolder->jam_masuk)->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $pengajuansolder->status }}</td>
                        <td>{{ $pengajuansolder->rejection_reason ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tombol Print -->
        <div class="print-btn">
            <button onclick="window.print()">Print</button>
        </div>
    </div>
</body>
</html>
