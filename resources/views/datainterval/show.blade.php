@extends('layouts.app')

@section('contents')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Aktivitas User: {{ $user->name }}</h1>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Berdasarkan Bulan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('datainterval.show', $user->id) }}">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="month" class="form-label">Pilih Bulan:</label>
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

    <!-- Data Tables Row -->
    <div class="row">
        <!-- Solder Data Table -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Analisa Sampel Solder</h6>
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
                                            <td>
                                                @if($data->status == 'Pengajuan')
                                                    <span class="badge badge-primary">{{ $data->status }}</span>
                                                @elseif($data->status == 'Proses Analisa')
                                                    <span class="badge badge-info">{{ $data->status }}</span>
                                                @elseif($data->status == 'Selesai Analisa')
                                                    <span class="badge badge-secondary">{{ $data->status }}</span>
                                                @elseif($data->status == 'Review Hasil')
                                                    <span class="badge badge-warning">{{ $data->status }}</span>
                                                @elseif($data->status == 'Approve')
                                                    <span class="badge badge-success">{{ $data->status }}</span>
                                                @else
                                                    <span class="badge badge-dark">{{ $data->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $data->pengajuanSolder->batch ?? 'N/A' }}</td>
                                            <td>{{ $data->pengajuanSolder->tipe_solder ?? 'N/A' }}</td>
                                            <td>{{ round(floatval($data->interval)) }} menit</td>
                                            <td>{{ \Carbon\Carbon::parse($data->changed_at)->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada data solder yang selesai dianalisa.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Chemical Data Table -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Analisa Sampel Chemical</h6>
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
                                            <td>
                                                @if($data->status == 'Pengajuan')
                                                    <span class="badge badge-primary">{{ $data->status }}</span>
                                                @elseif($data->status == 'Proses Analisa')
                                                    <span class="badge badge-info">{{ $data->status }}</span>
                                                @elseif($data->status == 'Selesai Analisa')
                                                    <span class="badge badge-secondary">{{ $data->status }}</span>
                                                @elseif($data->status == 'Review Hasil')
                                                    <span class="badge badge-warning">{{ $data->status }}</span>
                                                @elseif($data->status == 'Approve')
                                                    <span class="badge badge-success">{{ $data->status }}</span>
                                                @else
                                                    <span class="badge badge-dark">{{ $data->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $data->pengajuanChemical->batch ?? 'N/A' }}</td>
                                            <td>{{ $data->pengajuanChemical->nama ?? 'N/A' }}</td> 
                                            <td>{{ round(floatval($data->interval)) }} menit</td>
                                            <td>{{ \Carbon\Carbon::parse($data->changed_at)->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada data chemical yang selesai dianalisa.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h4>Total Akumulasi Waktu: <strong>{{ $hours }} Jam {{ $minutes }} Menit</strong></h4>
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('datainterval') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('export.data.interval', ['user_id' => $user->id, 'month' => $selectedMonth]) }}" 
                       class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
