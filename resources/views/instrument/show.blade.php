@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('instruments') }}">Kondisi Instrument</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Data Instrument</li>
        </ol>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-tools me-2"></i> Detail Data Instrument
        </h6>
        <span class="badge bg-info">{{ \Carbon\Carbon::parse($instrument->tgl)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
    </div>

    <div class="card-body">
        <!-- Basic Information Card -->
        <div class="card mb-4 border-left-info">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex mb-2">
                            <div class="text-info" style="width: 30px;"><i class="fas fa-calendar-day fa-fw"></i></div>
                            <div style="width: 150px;"><strong>Tanggal</strong></div>
                            <div>: {{ \Carbon\Carbon::parse($instrument->tgl)->locale('id')->isoFormat('D MMMM YYYY') }}</div>
                        </div>
                        
                        <div class="d-flex mb-2">
                            <div class="text-info" style="width: 30px;"><i class="fas fa-user-clock fa-fw"></i></div>
                            <div style="width: 150px;"><strong>Shift</strong></div>
                            <div>: {{ $instrument->shift }}</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex mb-2">
                            <div class="text-info" style="width: 30px;"><i class="fas fa-clock fa-fw"></i></div>
                            <div style="width: 150px;"><strong>Jam</strong></div>
                            <div>: {{ \Carbon\Carbon::parse($instrument->jam)->format('H:i') }}</div>
                        </div>
                        
                        <div class="d-flex mb-2">
                        <div class="text-info" style="width: 30px;"><i class="fas fa-user fa-fw"></i></div>
                        <div style="width: 150px;"><strong>Operator</strong></div>
                        <div>: {{ $instrument->nama }}</div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instrument Condition Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th style="width: 35%;">Nama Instrument</th>
                        <th style="width: 30%;">Kondisi</th>
                        <th style="width: 30%;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        try {
                            // Decode JSON fields with error handling
                            $nama_instrument = json_decode($instrument->nama_instrument, true);
                            $kondisi = json_decode($instrument->kondisi, true);
                            $keterangan = json_decode($instrument->keterangan, true);
                            
                            // Ensure we have arrays
                            $nama_instrument = is_array($nama_instrument) ? $nama_instrument : [];
                            $kondisi = is_array($kondisi) ? $kondisi : [];
                            $keterangan = is_array($keterangan) ? $keterangan : [];
                            
                            // Create a combined array for sorting
                            $combined = [];
                            foreach ($nama_instrument as $i => $name) {
                                // Handle case where name might be an array
                                $displayName = is_array($name) ? implode(', ', $name) : $name;
                                
                                $combined[] = [
                                    'nama' => $displayName,
                                    'kondisi' => isset($kondisi[$i]) ? $kondisi[$i] : '-',
                                    'keterangan' => isset($keterangan[$i]) ? $keterangan[$i] : '-'
                                ];
                            }
                            
                            // Sort by instrument name - account for if displayNames are arrays
                            usort($combined, function($a, $b) {
                                $nameA = is_array($a['nama']) ? implode(', ', $a['nama']) : $a['nama'];
                                $nameB = is_array($b['nama']) ? implode(', ', $b['nama']) : $b['nama'];
                                return strcmp($nameA, $nameB);
                            });
                        } catch (\Exception $e) {
                            // Handle any errors during JSON decoding
                            $combined = [];
                        }
                    @endphp
                    
                    @forelse($combined as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ is_array($item['nama']) ? implode(', ', $item['nama']) : $item['nama'] }}</td>
                            <td>
                                @php
                                    $kondisiValue = $item['kondisi'];
                                    // Handle kondisi if it's an array
                                    if(is_array($kondisiValue)) {
                                        $kondisiText = implode(', ', $kondisiValue);
                                    } else {
                                        $kondisiText = $kondisiValue;
                                    }
                                @endphp
                                
                                @if(is_string($kondisiText) && strtolower($kondisiText) == 'baik')
                                    <span class="badge bg-success">Baik</span>
                                @elseif(is_string($kondisiText) && strtolower($kondisiText) == 'rusak')
                                    <span class="badge bg-danger">Rusak</span>
                                @else
                                    {{ $kondisiText }}
                                @endif
                            </td>
                            <td>{{ is_array($item['keterangan']) ? implode(', ', $item['keterangan']) : $item['keterangan'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data instrument yang tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Additional Info or Actions -->
        <div class="mt-4">
            <!-- Show created/updated timestamps if needed -->
            @if($instrument->created_at)
                <p class="text-muted small mb-1">
                    <i class="fas fa-history"></i> Dibuat: {{ $instrument->created_at->format('d M Y H:i') }}
                    @if($instrument->updated_at && $instrument->updated_at->ne($instrument->created_at))
                        | Diperbarui: {{ $instrument->updated_at->format('d M Y H:i') }}
                    @endif
                </p>
            @endif
            
            <div class="d-flex gap-2">
                <a href="{{ route('instruments') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                
                @if(request()->user()->level === 'Admin' || request()->user()->name === $instrument->nama)
                    <a href="{{ route('instrument.edit', $instrument->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('instrument.destroy', $instrument->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Style for badges */
    .badge {
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
    .bg-info {
        background-color: #0dcaf0 !important;
    }
    .bg-success {
        background-color: #198754 !important;
        color: white;
    }
    .bg-danger {
        background-color: #dc3545 !important;
        color: white;
    }
    
    /* Card enhancements */
    .border-left-info {
        border-left: 4px solid #0dcaf0 !important;
    }
    
    /* Table styles */
    .table-hover tbody tr:hover {
        background-color: rgba(13, 202, 240, 0.05);
    }
    
    /* Gap utility for browsers that don't support it */
    .gap-2 {
        gap: 0.5rem;
    }
</style>
@endsection
