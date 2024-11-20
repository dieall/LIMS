@extends('layouts.app')

@section('contents')

<div class="card shadow mb-4">
    <!-- Header Card with Gradient Background and Icon -->
    <div class="card-header py-3 text-center" style="background: linear-gradient(135deg, #007bff, #00c6ff); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 5px;">
        <h6 class="m-0 font-weight-bold text-white">
            <i class="fas fa-vial"></i> Detail Information
        </h6>
    </div>

    <!-- Informasi Detail Umum -->
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <h6><strong>Kode BQR:</strong> {{ $tinstab->id }}</h6>
                <h6><strong>Deskripsi:</strong> {{ $tinstab->deskripsi ?? 'Deskripsi Tidak Tersedia' }}</h6>
            </div>
            <div class="col-md-6">
                <h6><strong>Tanggal Pengajuan:</strong> {{ $tinstab->created_at->format('d-m-Y') }}</h6>
                <h6><strong>Nama Pengaju:</strong> {{ $tinstab->nama ?? 'Nama Tidak Tersedia' }}</h6>
            </div>
        </div>
    </div>

    <!-- Tabel Detail Parameter -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Data Tinstab - {{ $tinstab->id }}</h6>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-light text-center">
                <tr>
                    <th>Parameter</th>
                    <th>Specification</th>
                    <th>Methods</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Clarity</td>
                    <td>Clear</td>
                    <td>Visual Inspection</td>
                    <td>{{ $tinstab->clarity }}</td>
                </tr>
                <tr>
                    <td>% Transmission</td>
                    <td>> 98</td>
                    <td>Spectrophotometric</td>
                    <td>{{ $tinstab->transmission }}</td>
                </tr>
                <tr>
                    <td>% Tin</td>
                    <td>19.2 ± 0.2</td>
                    <td>X-Ray Fluorescence</td>
                    <td>{{ $tinstab->tin }}</td>
                </tr>
                <tr>
                    <td>RI @ 25°C</td>
                    <td>1.509 ± 0.002 </td>
                    <td>Refractometer</td>
                    <td>{{ $tinstab->ri }}</td>
                </tr>
                <tr>
                    <td>SG @ 25°C</td>
                    <td>1.17 ± 0.01</td>
                    <td>Density Meter</td>
                    <td>{{ $tinstab->sg }}</td>
                </tr>
                <tr>
                    <td>Acid Value</td>
                    <td>Max 3</td>
                    <td>Acidimetric Titration</td>
                    <td>{{ $tinstab->acid }}</td>
                </tr>
                <tr>
                    <td>% Sulfur</td>
                    <td>12.0 ± 0.5</td>
                    <td>Iodimetric Titration</td>
                    <td>{{ $tinstab->sulfur }}</td>
                </tr>
                <tr>
                    <td>Water Content</td>
                    <td>&lt; 3.5</td>
                    <td>Karl Fischer</td>
                    <td>{{ $tinstab->water }}</td>
                </tr>
                <tr>
                    <td>Yellowish Index</td>
                    <td>&lt; 9.0</td>
                    <td>Spectrophotometric</td>
                    <td>{{ $tinstab->yellow }}</td>
                </tr>
                <tr>
                    <td>2-EH</td>
                    <td>&lt; 0.7</td>
                    <td>Gas Chromatography</td>
                    <td>{{ $tinstab->eh }}</td>
                </tr>
                <tr>
                    <td>Viscosity @ 25°C</td>
                    <td>40 - 80 cps</td>
                    <td>Viscometer</td>
                    <td>{{ $tinstab->visco }}</td>
                </tr>
                <tr>
                    <td>Pt-Co</td>
                    <td>&lt; 30</td>
                    <td>Pt-Co Method</td>
                    <td>{{ $tinstab->pt }}</td>
                </tr>
                <tr>
                    <td>Monomethyltin</td>
                    <td>16.5% - 24.5%</td>
                    <td>NMR</td>
                    <td>{{ $tinstab->mono }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Footer Card with Button -->
    <div class="card-footer text-right">
        <a href="{{ route('tinstab') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

@endsection
