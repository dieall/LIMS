@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Data Sn/Ag Series</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data Sn/Ag Series</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('datasolder.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="tipe_solder" id="formType" value="">

            <div class="row">
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <select name="nama_kategori" class="form-control select2" id="nama_kategori" required>
                        <option disabled selected value="">Pilih Kategori</option>
                        <option value="1">Sn/Cu Series</option>
                        <option value="2">Sn/Ag/Cu Series</option>
                        <option value="3">Sn/Ag Series</option>
                        <option value="4">Tin-Lead Solder Bar</option>

                    </select>
                </div>

                <div id="form-content" class="col-md-6 mb-3"></div>

                <div class="col-md-6 mb-3">
                    <label for="batch" class="form-label">Spesification</label>
                    <input type="text" name="spesification" class="form-control" id="spesification" placeholder="Masukkan Spesification" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="deskripsi" class="form-label">Rev</label>
                    <input type="text" name="rev" class="form-control" id="rev" placeholder="Masukkan Rev" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tgl" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tgl" name="tgl" required readonly>
                </div>
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

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tgl').value = today;

        const tipeSampelData = {
            '1': ['D9930c', 'D9930c (A)', 'D9930c (W)', 'MB D9930c', 'NAP100'],
            '2': ['SAC0307', 'SAC0307 (A)', 'E9650 (2,9% Ag)', 'E9650 (3% Ag)', 'E9650 (A) (2,9% Ag)', 'E9650 (A) (3% Ag)'],
            '3': ['0307CX', '0507CX', '9650CX (2.9% Ag)', '9650CX (3% Ag)', '9650CX (B) (2,9% Ag)'],
            '4': ['Sn63/37', 'Sn63/37 (A)', 'Sn60/40', 'Sn60/40 (A)', 'Sn60/40 (B)', 'Sn55/45'],
        };

        document.getElementById('nama_kategori').addEventListener('change', function() {
            const category = this.value;
            const solderTypeSelect = document.getElementById('form-content');
            solderTypeSelect.innerHTML = '';

            if (tipeSampelData[category]) {
                let optionsHTML = '<label for="solderType" class="form-label">Pilih Tipe Solder</label>';
                optionsHTML += '<select name="solder_type" class="form-control" id="solderType" required>';
                optionsHTML += '<option disabled selected value="">Pilih Tipe Solder</option>';

                tipeSampelData[category].forEach(function(item) {
                    optionsHTML += `<option value="${item}">${item}</option>`;
                });

                optionsHTML += '</select>';
                solderTypeSelect.innerHTML = optionsHTML;

                document.getElementById('solderType').addEventListener('change', function() {
                    document.getElementById('formType').value = this.value;
                });
            }
        });
    });
</script>


@endsection
