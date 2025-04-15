@extends('layouts.app')

@section('contents')
<style>
    /* Card styling */
    .info-card {
        border-left: 4px solid #36b9cc;
        margin-bottom: 20px;
    }
    
    /* Value display */
    .reading-value {
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    /* Badge styling */
    .badge {
        padding: 0.4em 0.6em;
        font-size: 0.85rem;
    }
    
    /* Table enhancements */
    .table-hover tbody tr:hover {
        background-color: rgba(54, 185, 204, 0.05);
    }
    
    /* Temperature and humidity values */
    .temp-value {
        color: #e74a3b;
        font-weight: 500;
    }
    
    .humid-value {
        color: #4e73df;
        font-weight: 500;
    }
    
    /* Icon styling */
    .icon-container {
        width: 30px;
        color: #36b9cc;
    }
</style>

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home me-1"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('datathermo') }}"><i class="fas fa-thermometer-half me-1"></i> Data Thermohygrometer</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-info-circle me-1"></i> Detail Data</li>
        </ol>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-thermometer-half me-2"></i> Detail Data Thermohygrometer
        </h6>
        <span class="badge bg-info">{{ \Carbon\Carbon::parse($datathermo->tgl)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
    </div>

    <div class="card-body">
        <!-- Basic Information Card -->
        <div class="card info-card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex mb-2">
                            <div class="icon-container"><i class="fas fa-user fa-fw"></i></div>
                            <div style="width: 120px;"><strong>Operator</strong></div>
                            <div>: {{ $datathermo->nama }}</div>
                        </div>
                        
                        <div class="d-flex mb-2">
                            <div class="icon-container"><i class="fas fa-calendar-day fa-fw"></i></div>
                            <div style="width: 120px;"><strong>Tanggal</strong></div>
                            <div>: {{ \Carbon\Carbon::parse($datathermo->tgl)->locale('id')->isoFormat('D MMMM YYYY') }}</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex mb-2">
                            <div class="icon-container"><i class="fas fa-clock fa-fw"></i></div>
                            <div style="width: 120px;"><strong>Waktu</strong></div>
                            <div>: {{ \Carbon\Carbon::parse($datathermo->waktu)->format('H:i') }} WIB</div>
                        </div>
                        
                        <div class="d-flex mb-2">
                            <div class="icon-container"><i class="fas fa-clipboard-list fa-fw"></i></div>
                            <div style="width: 120px;"><strong>Total Pengukuran</strong></div>
                            <div>: <span class="badge bg-primary">{{ count(json_decode($datathermo->nama_thermo, true) ?? []) }} Pengukuran</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thermohygrometer Readings Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="35%">Lokasi Pengukuran</th>
                        <th width="30%">Suhu</th>
                        <th width="30%">Kelembapan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        try {
                            // Decode JSON fields with error handling
                            $nama_thermo = json_decode($datathermo->nama_thermo, true);
                            $suhu = json_decode($datathermo->suhu, true);
                            $kelembapan = json_decode($datathermo->kelembapan, true);
                            
                            // Ensure we have arrays
                            $nama_thermo = is_array($nama_thermo) ? $nama_thermo : [];
                            $suhu = is_array($suhu) ? $suhu : [];
                            $kelembapan = is_array($kelembapan) ? $kelembapan : [];
                            
                            // Create a combined array for sorting
                            $combined = [];
                            foreach ($nama_thermo as $i => $name) {
                                // Handle case where values might be arrays
                                $displayName = is_array($name) ? implode(', ', $name) : $name;
                                $displaySuhu = isset($suhu[$i]) ? (is_array($suhu[$i]) ? implode(', ', $suhu[$i]) : $suhu[$i]) : '-';
                                $displayKelembapan = isset($kelembapan[$i]) ? (is_array($kelembapan[$i]) ? implode(', ', $kelembapan[$i]) : $kelembapan[$i]) : '-';
                                
                                $combined[] = [
                                    'nama' => $displayName,
                                    'suhu' => $displaySuhu,
                                    'kelembapan' => $displayKelembapan
                                ];
                            }
                            
                            // Sort by location name
                            usort($combined, function($a, $b) {
                                return strcmp($a['nama'], $b['nama']);
                            });
                        } catch (\Exception $e) {
                            // Handle any errors during JSON decoding
                            $combined = [];
                        }
                    @endphp
                    
                    @forelse($combined as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>
                                <i class="fas fa-temperature-high text-danger me-1"></i>
                                <span class="temp-value">{{ $item['suhu'] }}</span> °C
                            </td>
                            <td>
                                <i class="fas fa-tint text-primary me-1"></i>
                                <span class="humid-value">{{ $item['kelembapan'] }}</span> %
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data pengukuran yang tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Additional Information -->
        <div class="mt-4">
            <!-- Show timestamps if needed -->
            @if($datathermo->created_at)
                <p class="text-muted small mb-2">
                    <i class="fas fa-history"></i> Data direkam: {{ $datathermo->created_at->format('d M Y H:i') }}
                    @if($datathermo->updated_at && $datathermo->updated_at->gt($datathermo->created_at))
                        | Diperbarui: {{ $datathermo->updated_at->format('d M Y H:i') }}
                    @endif
                </p>
            @endif
            
            <div class="d-flex gap-2">
                <a href="{{ route('datathermo') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                
                @if(Auth::check() && (Auth::user()->level === 'Admin' || Auth::user()->name === $datathermo->nama))
                    <a href="{{ route('datathermo.edit', $datathermo->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit Data
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
