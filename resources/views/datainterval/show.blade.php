@extends('layouts.app')

@section('contents')

    <!-- Judul -->
    <h2>Detail Aktivitas User: {{ $user->name }}</h2>

    <!-- Card untuk Filter Bulan -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h5 class="card-title">Filter Berdasarkan Bulan</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('datainterval.show', $user->id) }}">
                <div class="row mb-3">
                    <div class="col-md-10">
                        <label for="month">Pilih Bulan:</label>
                        <select name="month" id="month" class="form-control" onchange="this.form.submit()">
                            @foreach(range(1, 12) as $month)
                                <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}" 
                                    {{ $selectedMonth == str_pad($month, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Card untuk Tabel -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between">

                <!-- Tabel Solder -->
                <div class="card mb-3" style="flex: 1 1 48%; margin-right: 2%;">
                    <div class="card-header">
                        <h5 class="card-title">Data Analisa Sampel Solder</h5>
                    </div>
                    <div class="card-body">
                        @if($solderData->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Status</th>
                                            <th>Batch</th>
                                            <th>Solder</th>
                                            <th>Interval</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($solderData as $key => $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->status }}</td>
                                                <td>{{ $data->pengajuanSolder->batch ?? 'N/A' }}</td>
                                                <td>{{ $data->pengajuanSolder->tipe_solder ?? 'N/A' }}</td>
                                                <td>{{ round(floatval($data->interval)) }} menit</td> <!-- Mengubah ke float sebelum pembulatan -->
                                                <td>{{ \Carbon\Carbon::parse($data->changed_at)->format('d-m-Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>Belum ada data solder yang selesai dianalisa.</p>
                        @endif
                    </div>
                </div>

                <!-- Tabel Chemical -->
                <div class="card mb-3" style="flex: 1 1 48%;">
                    <div class="card-header">
                        <h5 class="card-title">Data Analisa Sampel Chemical</h5>
                    </div>
                    <div class="card-body">
                        @if($chemicalData->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Status</th>
                                            <th>Batch</th>
                                            <th>Sampel</th>
                                            <th>Interval</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($chemicalData as $key => $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->status }}</td>
                                                <td>{{ $data->pengajuanChemical->batch ?? 'N/A' }}</td>
                                                <td>{{ $data->pengajuanChemical->nama ?? 'N/A' }}</td> 
                                                <td>{{ round(floatval($data->interval)) }} menit</td> <!-- Mengubah ke float sebelum pembulatan -->
                                                <td>{{ \Carbon\Carbon::parse($data->changed_at)->format('d-m-Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>No data found for chemical analysis.</p>
                        @endif
                    </div>
                </div>

            </div> <!-- Akhir dari div d-flex flex-wrap -->

            <!-- Menampilkan Total Interval -->
            <div class="mt-4">
                <h4>Total Akumulasi Waktu Keseluruhan : <strong>{{ $hours }} Jam {{ $minutes }} Menit</strong></h4>
                <a href="{{ route('datainterval') }}" class="btn btn-secondary btn-sm mt-4">
                            Kembali
                </a>
                <!-- Tombol Export -->
                <a href="{{ route('export.data.interval', ['user_id' => $user->id, 'month' => $selectedMonth]) }}" class="btn btn-success btn-sm mt-4">
                            Export to Excel
                </a>
            </div>
        </div>
    </div>

@endsection
