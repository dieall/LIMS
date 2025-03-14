<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Pengajuan Sampel</li>
        </ol>
        <hr>
    </nav>
</div>

@if(Session::has('success'))
    <div class="alert alert-s   uccess" role="alert" id="success-alert">
        {{ Session::get('success') }}
    </div>
@endif

<div class="card shadow mb-4">
<div class="card-header py-2">
    <div class="d-flex justify-content-between align-items-center">
    <form action="{{ route('transaksi') }}" method="GET" class="d-flex align-items-center">
            <label for="perPage" class="me-2">Tampilkan:</label>
            <select name="perPage" id="perPage" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                <option value="10" {{ request()->perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ request()->perPage == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ request()->perPage == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request()->perPage == 100 ? 'selected' : '' }}>100</option>
            </select>
        </form>
    
        <div class="input-group" style="width: 300px;">
            <input type="text" id="searchCategory" class="form-control" placeholder="Cari berdasarkan Tipe Sampel" aria-label="Cari berdasarkan Kategori">
            <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    <hr>
    <div class="d-flex justify-content-between align-items-center mb-1">
    <a href="{{ route('transaksi.create') }}" class="btn btn-success btn-sm">Tambah</a>
    <a href="{{ route('transaksi.cetak') }}" class="btn btn-success btn-sm">Print</a>
    <a href="" class="btn btn-success btn-sm">Export to Excel</a>


        </div>
</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="auto" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Category</th>
                        <th>Tipe Sampel</th>
                        <th>Batch</th>
                        <th>Deskripsi</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($transaksi->count() > 0)
                        @foreach($transaksi as $rs)
                            <tr>
                                <td class="align-middle">{{ ($transaksi->currentPage() - 1) * $transaksi->perPage() + $loop->iteration }}</td>
                                <td>{{ $rs->category->nama_kategori ?? 'Tidak ada kategori' }}</td> <!-- Menampilkan nama kategori -->
                                <td class="align-middle text-tipe-sampel">{{ $rs->tipe_sampel }}</td>
                                <td class="align-middle">{{ $rs->batch }}</td>
                                <td class="align-middle">{{ $rs->deskripsi }}</td>

                                <td class="align-middle">{{ $rs->nama }}</td>
                                <td class="align-middle">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('transaksi.print', $rs->id) }}" class="dropdown-item"><i class="fas fa-print"></i> Print MT-6xx</a></li>
                                            <li><a href="{{ route('transaksi.print2', $rs->id) }}" class="dropdown-item"><i class="fas fa-print"></i> Print MT-7xx</a></li>
                                            <li>

                                            <button type="button" class="dropdown-item btn-detail" data-id="{{ $rs->id }}" data-tgl="{{ $rs->tgl }}" data-category="{{ $rs->id_category }}" data-tipe-sampel="{{ $rs->tipe_sampel }}" data-batch="{{ $rs->batch }}" data-deskripsi="{{ $rs->deskripsi }}" data-nama="{{ $rs->nama }}" data-audit_trail="{{ $rs->audit_trail }}" data-bs-toggle="modal" data-bs-target="#floatingdetail">
                                                        <i class="fas fa-plus-circle"></i> Detail
                                                    </button>

                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item btn-edit" data-id="{{ $rs->id }}" data-tgl="{{ $rs->tgl }}" data-category="{{ $rs->id_category }}" data-tipe-sampel="{{ $rs->tipe_sampel }}" data-batch="{{ $rs->batch }}" data-deskripsi="{{ $rs->deskripsi }}" data-nama="{{ $rs->nama }}" data-audit_trail="{{ $rs->audit_trail }}" data-bs-toggle="modal" data-bs-target="#floatingFormModal">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            </li>
                                            <li>
                                                <form action="{{ route('transaksi.destroy', $rs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="7">Data not found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>


    </div>
    
</div>

<!-- Modal Edit -->
<div class="modal fade" id="floatingFormModal" tabindex="-1" aria-labelledby="floatingFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="floatingFormLabel">Form Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="tgl" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tgl" name="tgl" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipe_sampel" class="form-label">Tipe Sampel</label>
                        <input type="text" class="form-control" id="tipe_sampel" name="tipe_sampel" required>
                    </div>
                    <div class="mb-3">
                        <label for="batch" class="form-label">Batch</label>
                        <input type="text" class="form-control" id="batch" name="batch" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="audit_trail" class="form-label">Alasan</label>
                        <input type="text" class="form-control" id="audit_trail" name="audit_trail" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- MODAL DETAIL ------------>
<div class="modal fade" id="floatingdetail" tabindex="-1" aria-labelledby="floatingDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="floatingDetailLabel">Detail Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="tglDetail" class="form-label">Tanggal</label>
                    <input type="text" class="form-control" id="tglDetail" disabled>
                </div>
                <div class="mb-3">
                    <label for="categoryDetail" class="form-label">Category</label>
                    <input type="text" class="form-control" id="categoryDetail" disabled>
                </div>
                <div class="mb-3">
                    <label for="tipe_sampelDetail" class="form-label">Tipe Sampel</label>
                    <input type="text" class="form-control" id="tipe_sampelDetail" disabled>
                </div>
                <div class="mb-3">
                    <label for="batchDetail" class="form-label">Batch</label>
                    <input type="text" class="form-control" id="batchDetail" disabled>
                </div>
                <div class="mb-3">
                    <label for="deskripsiDetail" class="form-label">Deskripsi</label>
                    <input type="text" class="form-control" id="deskripsiDetail" disabled>
                </div>
                <div class="mb-3">
                    <label for="namaDetail" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="namaDetail" disabled>
                </div>
                <div class="mb-3">
                    <label for="audit_trailDetail" class="form-label">Alasan</label>
                    <input type="text" class="form-control" id="audit_trailDetail" disabled>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>





<!-- Script untuk mengisi data ke form modal -->
<!-- Script untuk mengisi data ke form modal -->
<!-- Script untuk mengisi data ke form modal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const tgl = this.getAttribute('data-tgl');
                const category = this.getAttribute('data-category');
                const tipeSampel = this.getAttribute('data-tipe-sampel');
                const batch = this.getAttribute('data-batch');
                const deskripsi = this.getAttribute('data-deskripsi');
                const nama = this.getAttribute('data-nama');
                const audit_trail = this.getAttribute('data-audit_trail')

                // Mengisi form modal dengan data
                document.getElementById('tgl').value = tgl;
                document.getElementById('category').value = category;
                document.getElementById('tipe_sampel').value = tipeSampel;
                document.getElementById('batch').value = batch;
                document.getElementById('deskripsi').value = deskripsi;
                document.getElementById('nama').value = nama;
                document.getElementById('audit_trail').value = audit_trail;

                // Atur action form ke URL edit yang sesuai
                const form = document.getElementById('editForm');
                form.action = `{{ route('transaksi.update', '') }}/${id}`;  // Gunakan route dengan ID yang diambil dari atribut data
            });
        });
   





    });

    document.addEventListener('DOMContentLoaded', function () {
        const detailButtons = document.querySelectorAll('.btn-detail');

        detailButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Ambil data dari atribut data-* pada tombol yang diklik
                const tgl = button.getAttribute('data-tgl');
                const category = button.getAttribute('data-category');
                const tipeSampel = button.getAttribute('data-tipe-sampel');
                const batch = button.getAttribute('data-batch');
                const deskripsi = button.getAttribute('data-deskripsi');
                const nama = button.getAttribute('data-nama');
                const auditTrail = button.getAttribute('data-audit_trail');

                // Set data tersebut pada input modal
                document.getElementById('tglDetail').value = tgl;
                document.getElementById('categoryDetail').value = category;
                document.getElementById('tipe_sampelDetail').value = tipeSampel;
                document.getElementById('batchDetail').value = batch;
                document.getElementById('deskripsiDetail').value = deskripsi;
                document.getElementById('namaDetail').value = nama;
                document.getElementById('audit_trailDetail').value = auditTrail;
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 5000); // 5000 milliseconds = 5 seconds
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchCategory');
    const clearButton = document.getElementById('clearSearch');
    const table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];

    searchInput.addEventListener('input', function() {
        const filter = searchInput.value.toLowerCase();
        const rows = table.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const categoryCell = row.cells[2]; // Index 2 sesuai dengan urutan kolom Category
            if (categoryCell) {
                const category = categoryCell.textContent.toLowerCase();
                row.style.display = category.includes(filter) ? '' : 'none';
            }
        });
    });

    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        Array.from(table.getElementsByTagName('tr')).forEach(row => row.style.display = '');
    });
});
</script>

<style>
.text-category {
    max-width: 130px; /* Set maximum width */
    white-space: normal; /* Allow text to wrap */
    overflow: hidden; /* Hide overflow */
    text-overflow: ellipsis; /* Add ellipsis for overflowed text */
}
.text-tipe-sampel {
    max-width: 150px; /* Set maximum width for Tipe Sampel */
    white-space: normal; /* Allow text to wrap */
    overflow: hidden; /* Hide overflow */
    text-overflow: ellipsis; /* Add ellipsis for overflowed text */
}
</style>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Font Awesome JS -->  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
