@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Data Sn/Cu Series</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data Sn/Cu Series</h6>
    </div>

    <div class="card-body">

        <!-- Form Utama -->
        <form action="{{ route('sncu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" id="formType" value="D9930C"> <!-- Default ke opsi pertama -->

            <!-- Isi Form -->
            <div class="row">
                <!-- Batch / Lot -->
                <div class="col-md-6 mb-3">
                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" placeholder="Masukkan Nama Kategori" required>
            </div>

                <!-- Deskripsi -->
                <div class="col-md-6 mb-3">
                    <label for="deskripsi" class="form-label">Sample Code</label>
                    <input type="text" name="sample" class="form-control" id="sample" placeholder="Masukkan sample" required>
                </div>
                <!-- Tambahan Elemen Kimia -->
                <div class="row">
                    <!-- Pb -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="pb" class="form-label">Pb</label>
                        <input type="number" step="any" name="pb" class="form-control" id="pb" placeholder="Pb">
                        <div id="pb-warning" class="text-danger mt-1" style="display: none;">
                            Nilai Pb tidak boleh kurang dari 0.04!
                        </div>
                    </div>
                    <!-- Bi -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="bi" class="form-label">Bi</label>
                        <input type="number" step="any" name="bi" class="form-control" id="bi" placeholder="Bi">
                    </div>
                    <!-- Sb -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="sb" class="form-label">Sb</label>
                        <input type="number" step="any" name="sb" class="form-control" id="sb" placeholder="Sb">
                    </div>
                    <!-- Cu -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="cu" class="form-label">Cu</label>
                        <input type="number" step="any" name="cu" class="form-control" id="cu" placeholder="Cu">
                    </div>
                    <!-- Zn -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="zn" class="form-label">Zn</label>
                        <input type="number" step="any" name="zn" class="form-control" id="zn" placeholder="Zn">
                    </div>
                    <!-- Ag -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ag" class="form-label">Ag</label>
                        <input type="number" step="any" name="ag" class="form-control" id="ag" placeholder="Ag">
                    </div>
                    <!-- Ai -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ai" class="form-label">Ai</label>
                        <input type="number" step="any" name="ai" class="form-control" id="ai" placeholder="Ai">
                    </div>
                    <!-- As -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="as" class="form-label">As</label>
                        <input type="number" step="any" name="as" class="form-control" id="as" placeholder="As">
                    </div>
                    <!-- Cd -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="cd" class="form-label">Cd</label>
                        <input type="number" step="any" name="cd" class="form-control" id="cd" placeholder="Cd">
                    </div>
                    <!-- Fe -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="fe" class="form-label">Fe</label>
                        <input type="number" step="any" name="fe" class="form-control" id="fe" placeholder="Fe">
                    </div>
                    <!-- In -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="in" class="form-label">In</label>
                        <input type="number" step="any" name="in" class="form-control" id="in" placeholder="In">
                    </div>
                    <!-- Ni -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ni" class="form-label">Ni</label>
                        <input type="number" step="any" name="ni" class="form-control" id="ni" placeholder="Ni">
                    </div>
                    <!-- Ge -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ge" class="form-label">Ge</label>
                        <input type="number" step="any" name="ge" class="form-control" id="ge" placeholder="Ge">
                    </div>
                    <!-- Pe -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="pe" class="form-label">Pe</label>
                        <input type="number" step="any" name="pe" class="form-control" id="pe" placeholder="Pe">
                    </div>
                    <!-- Sn -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="sn" class="form-label">Sn</label>
                        <input type="number" step="any" name="sn" class="form-control" id="sn" placeholder="Sn">
                    </div>

                    <!-- Note -->
                    <div class="col-md-6 mb-3">
                        <label for="note" class="form-label">Note</label>
                        <input type="text" name="note" class="form-control" id="note" placeholder="Masukkan note">
                    </div>
                </div>

                <div class="row">
                    <!-- Max and Average -->
                    <div class="col-md-6 mb-3">
                        <label for="max" class="form-label">Max</label>
                        <input type="number" step="any" name="max" class="form-control" id="max" placeholder="Masukkan max" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="average" class="form-label">Average</label>
                        <input type="number" step="any" name="average" class="form-control" id="average" placeholder="Masukkan average" required>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    document.getElementById('pb').addEventListener('input', function() {
        const pbValue = parseFloat(this.value);
        const warningMessage = document.getElementById('pb-warning');
        
        if (!isNaN(pbValue) && pbValue < 0.04) {
            warningMessage.style.display = 'block';
        } else {
            warningMessage.style.display = 'none';
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mengatur tanggal hari ini
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tgl').value = today;

        const formTypeInput = document.getElementById('formType');
        const solderTypeSelect = document.getElementById('solderType');

        solderTypeSelect.addEventListener('change', function() {
            formTypeInput.value = solderTypeSelect.value;
        });
    });
</script>
@endsection
