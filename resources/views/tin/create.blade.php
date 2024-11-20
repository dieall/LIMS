@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Data Tin-Lead Solder Series</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data Tin-Lead Solder Series</h6>
    </div>

    <div class="card-body">
        <!-- Pilih Tipe -->

 

        <!-- Form Utama -->
        <form action="{{ route('tin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="tipe_solder" id="formType" value="Sn63/37"> <!-- Default ke opsi pertama -->

            <!-- Isi Form -->
            <div class="row">
            <div class="col-md-6 mb-3">
            <label for="solderType" class="form-label">Pilih Tipe Solder</label>
            <select id="solderType" class="form-control">
                <option value="Sn63/67">Sn63/67</option>
                <option value="Sn63/67 (A)">Sn63/67 (A)</option>
                <option value="Sn60/40">Sn60/40</option>
                <option value="Sn60/40 (A)">Sn60/40 (A)</option>
                <option value="Sn60/40 (B)">Sn60/40 (B)</option>
                <option value="Sn55/45 (B)">Sn55/45</option>
            </select>
        </div>
                <!-- Batch / Lot -->
                <div class="col-md-6 mb-3">
                    <label for="batch" class="form-label">Spesification</label>
                    <input type="text" name="spesification" class="form-control" id="spesification" placeholder="Masukkan Spesification" required>
                </div>

                <!-- Deskripsi -->
                <div class="col-md-6 mb-3">
                    <label for="deskripsi" class="form-label">Rev</label>
                    <input type="text" name="rev" class="form-control" id="rev" placeholder="Masukkan rev" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tgl" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tgl" name="tgl" required readonly>
                </div>

                <!-- Tambahan Elemen Kimia -->
                <div class="row">
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="sn" class="form-label">Sn</label>
                        <input type="text" step="any" name="sn" class="form-control" id="sn" placeholder="Sn">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ag" class="form-label">Ag</label>
                        <input type="text" step="any" name="ag" class="form-control" id="ag" placeholder="Ag">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="cu" class="form-label">Cu</label>
                        <input type="text" step="any" name="cu" class="form-control" id="cu" placeholder="Cu">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="pb" class="form-label">Pb</label>
                        <input type="text" step="any" name="pb" class="form-control" id="pb" placeholder="Pb">
                        <div id="pb-warning" class="text-danger mt-1" style="display: none;">
                            Nilai Pb tidak boleh kurang dari 0.04!
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="sb" class="form-label">Sb</label>
                        <input type="text" step="any" name="sb" class="form-control" id="sb" placeholder="Sb">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="zn" class="form-label">Zn</label>
                        <input type="text" step="any" name="zn" class="form-control" id="zn" placeholder="Zn">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="fe" class="form-label">Fe</label>
                        <input type="text" step="any" name="fe" class="form-control" id="fe" placeholder="Fe">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="as" class="form-label">As</label>
                        <input type="text" step="any" name="as" class="form-control" id="as" placeholder="As">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ni" class="form-label">Ni</label>
                        <input type="text" step="any" name="ni" class="form-control" id="ni" placeholder="Ni">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="bi" class="form-label">Bi</label>
                        <input type="text" step="any" name="bi" class="form-control" id="bi" placeholder="Bi">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="cd" class="form-label">Cd</label>
                        <input type="text" step="any" name="cd" class="form-control" id="cd" placeholder="Cd">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ai" class="form-label">Ai</label>
                        <input type="text" step="any" name="ai" class="form-control" id="ai" placeholder="Ai">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="pe" class="form-label">Pe</label>
                        <input type="text" step="any" name="pe" class="form-control" id="pe" placeholder="Pe">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ge" class="form-label">Ga</label>
                        <input type="text" step="any" name="ga" class="form-control" id="ga" placeholder="Ga">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ge" class="form-label">MP</label>
                        <input type="text" step="any" name="mp" class="form-control" id="mp" placeholder="Mp">
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
