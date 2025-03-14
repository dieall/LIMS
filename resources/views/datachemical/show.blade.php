@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Detail Pengajuan Solder</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Detail Data | Pengajuan Solder</h6>
    </div>

    <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri: Informasi Utama -->
                <div class="col-md-6 mb-3">
                    <table class="table table-bordered">
                        @if($datachemical->nama)
                            <tr>
                                <th>Nama</th>
                                <td>{{ $datachemical->nama }}</td>
                            </tr>
                        @endif
                        @if($datachemical->kategori)
                            <tr>
                                <th>Kategori</th>
                                <td>{{ $datachemical->kategori }}</td>
                            </tr>
                        @endif
                        @if($datachemical->tgl)
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ $datachemical->tgl }}</td>
                            </tr>
                        @endif
                        @if($datachemical->batch)
                            <tr>
                                <th>Batch / Lot</th>
                                <td>{{ $datachemical->batch }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $datachemical->desc }}</td>
                            </tr>
                        @endif
                        @if(isset($pengajuanchemical->user) && $pengajuanchemical->user->name)
                            <tr>
                                <th>Nama</th>
                                <td>{{ $pengajuanchemical->user->name }}</td>
                            </tr>
                        @endif

                        @if($datachemical->created_at)
                            <tr>
                                <th>Jam Pengajuan</th>
                                <td>{{ \Carbon\Carbon::parse($datachemical->created_at)->format('H:i:s') }}</td>
                            </tr>
                        @endif

                    </table>
                </div>

                <!-- Kolom Kanan: Detail Solder -->
                <div class="col-md-6 mb-3">
    <h6 class="font-weight-bold text-center mb-3">Detail Sampel</h6>
    @if(
        $datachemical->clarity || $datachemical->transmission || $datachemical->ape || 
        $datachemical->dimet || $datachemical->trime || $datachemical->tin || 
        $datachemical->solid || $datachemical->ri || $datachemical->sg || 
        $datachemical->acid || $datachemical->sulfur || $datachemical->water || 
        $datachemical->mono || $datachemical->yellow || $datachemical->eh || 
        $datachemical->visco || $datachemical->pt || $datachemical->moisture || 
        $datachemical->cloride || $datachemical->spec || $datachemical->cla || 
        $datachemical->densi
    )
        <table class="table table-bordered">
            @if($datachemical->clarity)
                <tr><th>Clarity</th><td>{{ $datachemical->clarity }}</td></tr>
            @endif
            @if($datachemical->transmission)
                <tr><th>Transmission</th><td>{{ $datachemical->transmission }}</td></tr>
            @endif
            @if($datachemical->ape)
                <tr><th>Ape</th><td>{{ $datachemical->ape }}</td></tr>
            @endif
            @if($datachemical->dimet)
                <tr><th>Dimet</th><td>{{ $datachemical->dimet }}</td></tr>
            @endif
            @if($datachemical->trime)
                <tr><th>Trime</th><td>{{ $datachemical->trime }}</td></tr>
            @endif
            @if($datachemical->tin)
                <tr><th>Tin</th><td>{{ $datachemical->tin }}</td></tr>
            @endif
            @if($datachemical->solid)
                <tr><th>Solid</th><td>{{ $datachemical->solid }}</td></tr>
            @endif
            @if($datachemical->ri)
                <tr><th>RI</th><td>{{ $datachemical->ri }}</td></tr>
            @endif
            @if($datachemical->sg)
                <tr><th>SG</th><td>{{ $datachemical->sg }}</td></tr>
            @endif
            @if($datachemical->acid)
                <tr><th>Acid</th><td>{{ $datachemical->acid }}</td></tr>
            @endif
            @if($datachemical->sulfur)
                <tr><th>Sulfur</th><td>{{ $datachemical->sulfur }}</td></tr>
            @endif
            @if($datachemical->water)
                <tr><th>Water</th><td>{{ $datachemical->water }}</td></tr>
            @endif
            @if($datachemical->mono)
                <tr><th>Mono</th><td>{{ $datachemical->mono }}</td></tr>
            @endif
            @if($datachemical->yellow)
                <tr><th>Yellow</th><td>{{ $datachemical->yellow }}</td></tr>
            @endif
            @if($datachemical->eh)
                <tr><th>Eh</th><td>{{ $datachemical->eh }}</td></tr>
            @endif
            @if($datachemical->visco)
                <tr><th>Visco</th><td>{{ $datachemical->visco }}</td></tr>
            @endif
            @if($datachemical->pt)
                <tr><th>PT</th><td>{{ $datachemical->pt }}</td></tr>
            @endif
            @if($datachemical->moisture)
                <tr><th>Moisture</th><td>{{ $datachemical->moisture }}</td></tr>
            @endif
            @if($datachemical->cloride)
                <tr><th>Cloride</th><td>{{ $datachemical->cloride }}</td></tr>
            @endif
            @if($datachemical->spec)
                <tr><th>Spec</th><td>{{ $datachemical->spec }}</td></tr>
            @endif
            @if($datachemical->cla)
                <tr><th>Cla</th><td>{{ $datachemical->cla }}</td></tr>
            @endif
            @if($datachemical->densi)
                <tr><th>Densi</th><td>{{ $datachemical->densi }}</td></tr>
            @endif
        </table>
    @else
        <p class="text-center">Tidak ada data Detail sampel yang tersedia.</p>
    @endif
</div>

        </div>
    </div>
</div>
@endsection
