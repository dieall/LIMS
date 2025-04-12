@extends('layouts.app')

@section('contents')
<style>
    .alert {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        font-weight: bold;
        transition: opacity 1s ease-out; /* Efek transisi saat hilang */
    }

    .alert-success {
        background-color: #d4edda; /* Warna latar belakang hijau */
        color: #155724; /* Warna teks hijau gelap */
        border: 1px solid #c3e6cb; /* Border hijau muda */
    }

    #success-alert {
        opacity: 1; /* Mulai dengan visibilitas penuh */
    }
    .custom-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        gap: 8px;
    }

    .page-link {
        display: inline-block;
        padding: 8px 12px;
        color: #007bff;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .page-link:hover {
        background-color: #f1f1f1;
        color: #0056b3;
    }

    .page-link.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .page-link.disabled {
        color: #6c757d;
        pointer-events: none;
    }


</style>

<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Sampel Solder</li>
        </ol>
        <hr>
    </nav>
</div>

<!-- Card Wrapper -->
<div class="card shadow mb-4">
<div class="card-header py-2 d-flex justify-content-between align-items-center">
    <h6 class="m-0 font-weight-bold">Data Sample Solder</h6>
    <div class="d-flex gap-2">
        <!-- Dropdown Filter Data -->
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Filter Data
            </button>
            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                <li><a class="dropdown-item" href="{{ route('pengajuansolder.index', ['filter' => 'all']) }}">Semua Data</a></li>
                <li><a class="dropdown-item" href="{{ route('pengajuansolder.index', ['filter' => 'this_month']) }}">Data Bulan Ini</a></li>
                <li><a class="dropdown-item" href="{{ route('pengajuansolder.index', ['filter' => 'today']) }}">Data Hari Ini</a></li>
            </ul>

        </div>

        <!-- Dropdown for Page Size -->
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="pageSizeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Tampilkan: {{ request('page_size', 10) }} Data
            </button>
            <ul class="dropdown-menu" aria-labelledby="pageSizeDropdown">
                <li><a class="dropdown-item" href="{{ route('pengajuansolder.index', array_merge(request()->all(), ['page_size' => 10])) }}">10</a></li>
                <li><a class="dropdown-item" href="{{ route('pengajuansolder.index', array_merge(request()->all(), ['page_size' => 20])) }}">20</a></li>
                <li><a class="dropdown-item" href="{{ route('pengajuansolder.index', array_merge(request()->all(), ['page_size' => 50])) }}">50</a></li>
                <li><a class="dropdown-item" href="{{ route('pengajuansolder.index', array_merge(request()->all(), ['page_size' => 100])) }}">100</a></li>
            </ul>
        </div>

        <!-- Button Tambah -->
        <a href="{{ route('pengajuansolder.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> Tambah
        </a>
        <a href="{{ route('pengajuansolder.export-excel') }}" class="btn btn-success btn-sm">
    <i class="fas fa-file-export"></i> Export to Excel
</a>

    </div>
</div>

    <!-- Success Alert -->
    @if(Session::has('success'))
    <div class="alert alert-success" role="alert" id="success-alert">
        {{ Session::get('success') }}
    </div>
    @endif

    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-light text-dark">
                <tr>
                    <th class="text-center">No</th>
                    <th>Category</th>
                    <th>Tipe Sampel</th>
                    <th>Batch</th>
                    <th>Riwayat Proses</th>
                    <th>Nama</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($pengajuansolder->count() > 0)
                    @foreach($pengajuansolder as $rs)
                        <tr>
                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $rs->categorysolder->nama_kategori }}</td>
                            <td class="align-middle">{{ $rs->tipe_solder }}</td>
                            <td class="align-middle">{{ $rs->batch }}</td>
                            <td class="align-middle">{{ \Carbon\Carbon::parse($rs->jam_masuk)->format('H:i') }}</td>
                            <td class="align-middle">{{ $rs->nama }}</td>
                            <td class="align-middle text-center">
                                    @if ($rs->status == 'Pengajuan')
                                        <span class="badge bg-primary">{{ $rs->status }}</span>
                                    @elseif ($rs->status == 'Proses Analisa')
                                        <span class="badge bg-info">{{ $rs->status }}</span>
                                    @elseif ($rs->status == 'Selesai Analisa')
                                        <span class="badge bg-secondary">{{ $rs->status }}</span>
                                    @elseif ($rs->status == 'Review Hasil')
                                        <span class="badge bg-warning">{{ $rs->status }}</span>
                                    @elseif ($rs->status == 'Approve')
                                        <span class="badge bg-success">{{ $rs->status }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $rs->status }}</span>
                                    @endif
                                </td>
                            <td class="text-center align-middle">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <!-- Tombol Detail -->
                                            <li>
                                                <a href="{{ route('pengajuansolder.show', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-info-circle"></i> Detail
                                                </a>
                                            </li>
                                            <!-- Tombol Print -->
                                            <li>
                                                <a href="{{ route('pengajuansolder.print', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                            </li>
                                            <!-- Tombol Edit -->
                                            <li>
                                                <a href="{{ route('pengajuansolder.edit', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </li>
                            @if (Auth::user()->level === 'Admin' || Auth::user()->level === 'Operator QC')                                 
                            <li>
                        <form action="{{ route('pengajuansolder.pengajuan', $rs->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-file-alt"></i> Pengajuan
                            </button>
                        </form>
                    </li>
                        
                        @endif
                        @if (Auth::user()->level === 'Admin' || Auth::user()->level === 'Operator Lab')
                            @if ($rs->status != 'Analisa Selesai') 
                                <!-- Always show the button until analysis is complete -->
                                <li>
                                    <form action="{{ route('pengajuansolder.proses-analisa', $rs->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-cogs"></i> 
                                            @if ($rs->status == 'Proses Analisa')
                                                Lanjutkan Proses Analisa
                                            @else
                                                Proses Analisa
                                            @endif
                                        </button>
                                    </form>
                                </li>
                            @endif
                        @endif




<!-- Tombol Analisa Selesai -->
@if (Auth::user()->level === 'Admin' || Auth::user()->level === 'Operator Lab')
    @if ($rs->status == 'Proses Analisa') <!-- Tombol hanya muncul saat status 'Proses Analisa' -->
        <li>
            <form action="{{ route('pengajuansolder.analisaSelesai', $rs->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="fas fa-check-circle"></i> Analisa Selesai
                </button>
            </form>
        </li>
    @endif
@endif



                    <!-- Review Hasil -->
                    @if (Auth::user()->level === 'Admin' || Auth::user()->level === 'Foreman')
                        <li>
                            <form action="{{ route('pengajuansolder.reviewHasil', $rs->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-eye"></i> Review Hasil
                                </button>
                            </form>
                        </li>
                    @endif

                    <!-- Approve -->
                    @if (Auth::user()->level === 'Admin' || Auth::user()->level === 'Supervisor')
                        <li>
                            <form action="{{ route('pengajuansolder.approve', $rs->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-thumbs-up"></i> Approve
                                </button>
                            </form>
                        </li>
                    @endif

                    <!-- Tombol Delete -->
                     
                    @if (Auth::user()->level === 'Admin') 
                    <li>
                        <form action="{{ route('pengajuansolder.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </li>
                    @endif
                    
                </ul>
            </div>

        @if (Auth::user()->level === 'Admin')
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-cogs"></i> Cetak CoA
            </button>
            <ul class="dropdown-menu">
                <!-- Tombol Detail -->
                <li>
                    <a href="{{ route('pengajuansolder.lokal', $rs->id) }}" class="dropdown-item">
                        <i class="fas fa-map-marker-alt"></i> Lokal
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengajuansolder.expor', $rs->id) }}" class="dropdown-item">
                        <i class="fas fa-paper-plane"></i> Ekspor
                    </a>
                </li>
            </ul>
        </div>
        @endif
                                </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data pengajuan solder yang tersedia.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="custom-pagination">
    @if ($pengajuansolder->currentPage() > 1)
        <a href="{{ $pengajuansolder->previousPageUrl() }}" class="page-link">« Previous</a>
    @endif

    @for ($i = 1; $i <= $pengajuansolder->lastPage(); $i++)
        <a href="{{ $pengajuansolder->url($i) }}" class="page-link {{ $pengajuansolder->currentPage() == $i ? 'active' : '' }}">
            {{ $i }}
        </a>
    @endfor

    @if ($pengajuansolder->currentPage() < $pengajuansolder->lastPage())
        <a href="{{ $pengajuansolder->nextPageUrl() }}" class="page-link">Next »</a>
    @endif
</div>

</div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.getElementById('success-alert');

        if (successAlert) {
            setTimeout(function() {
                successAlert.style.opacity = '0';
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 1000);
            }, 3000);
        }
    });
</script>
@endsection