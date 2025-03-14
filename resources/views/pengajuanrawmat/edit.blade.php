@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengajuanrawmat.index') }}">Pengajuan Raw Material</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Pengajuan Raw Material</li>
        </ol>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Edit Pengajuan Raw Material</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('pengajuanrawmat.update', $pengajuanrawmat->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Tabel Responsif -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="min-width: 150px;">Nama</th>
                            <th style="min-width: 150px;">Supplier</th>
                            <th style="min-width: 150px;">Spesifikasi</th>
                            <th style="min-width: 150px;">Satuan</th>
                            <th style="min-width: 150px;">COA</th>
                            <th style="min-width: 150px;">Result</th>
                            <th style="min-width: 150px;">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Decode JSON data
                            $spesifikasi = json_decode($pengajuanrawmat->spesifikasi, true) ?? [];
                            $satuan = json_decode($pengajuanrawmat->satuan, true) ?? [];
                            $coa = json_decode($pengajuanrawmat->coa, true) ?? [];
                            $result = json_decode($pengajuanrawmat->result, true) ?? [];
                            
                            // Calculate maximum number of rows
                            $maxLength = max(count($spesifikasi), count($satuan), count($coa), count($result));
                        @endphp

                        @for ($i = 0; $i < $maxLength; $i++)
                        <tr>
                            @if ($i == 0)
                            <td rowspan="{{ $maxLength }}">
                                <input type="text" name="nama" class="form-control" value="{{ old('nama', $pengajuanrawmat->nama) }}" required readonly>
                            </td>
                            <td rowspan="{{ $maxLength }}">
                                <input type="text" name="supplier" class="form-control" value="{{ old('supplier', $pengajuanrawmat->supplier) }}" required  readonly>
                            </td>
                            @endif
                            <td>
                                <input type="text" name="spesifikasi[]" class="form-control" value="{{ $spesifikasi[$i] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" name="satuan[]" class="form-control" value="{{ $satuan[$i] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" name="coa[]" class="form-control" value="{{ $coa[$i] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" name="result[]" class="form-control" value="{{ $result[$i] ?? '' }}">
                            </td>
                            @if ($i == 0)
                            <td rowspan="{{ $maxLength }}">
                                <input type="date" name="tgl" class="form-control" value="{{ old('tgl', $pengajuanrawmat->tgl) }}"  required readonly>
                            </td>
                            @endif
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <!-- Submit Button -->
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('pengajuanrawmat.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
