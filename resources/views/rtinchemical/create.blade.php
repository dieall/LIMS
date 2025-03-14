@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data | Data Raw Mat Tin-Chemical</h6>
    </div>
    <div class="card shadow mb-4">

    <div class="card-body">
        <form action="{{ route('rtinchemical.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" placeholder="Masukkan Rev" value="Raw Mat Tin-Chemical" required readonly>
                </div>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="tipe_rawmat" class="form-label">Pilih Jenis Raw Mat Tin-Chemical</label>
                <select name="tipe_rawmat" id="tipe_rawmat" class="form-select" required>
                    <option value="Logam Timah Grade 99.9%">Logam Timah Grade 99.9%</option>
                    <option value="Logam Timah Grade 99.85%">Logam Timah Grade 99.85%</option>
                    <option value="Methyl Chloride (MeCl)">Methyl Chloride (MeCl)</option>
                    <option value="Tetramethyl Ammmonium Chloride (TMAC)">Tetramethyl Ammmonium Chloride (TMAC)</option>
                    <option value="Ammonia">Ammonia</option>
                    <option value="Ethylhexyl Thioglicolate (2-EHTG)">Ethylhexyl Thioglicolate (2-EHTG)</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <label for="nama" class="form-label">Nama Material</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Material" readonly>
            </div>
        </div>


            <!-- Form 1: Formulir Pendaftaran -->
            <div id="Logam Timah Grade 99.9%" style="display: none;">
                <div class="row">
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="sn" class="form-label">Sn</label>
                        <input type="text" name="sn" class="form-control" id="sn" placeholder="Sn">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="cu" class="form-label">Cu</label>
                        <input type="text" name="cu" class="form-control" id="cu" placeholder="Cu">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="pb" class="form-label">Pb</label>
                        <input type="text" name="pb" class="form-control" id="pb" placeholder="Pb">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="sb" class="form-label">Sb</label>
                        <input type="text" name="sb" class="form-control" id="sb" placeholder="Sb">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="bi" class="form-label">Bi</label>
                        <input type="text" name="bi" class="form-control" id="bi" placeholder="Bi">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="cd" class="form-label">Cd</label>
                        <input type="text" name="cd" class="form-control" id="cd" placeholder="Cd">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ai" class="form-label">Ai</label>
                        <input type="text" name="ai" class="form-control" id="ai" placeholder="Ai">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ag" class="form-label">Ag</label>
                        <input type="text" name="ag" class="form-control" id="ag" placeholder="Ag">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="as" class="form-label">As</label>
                        <input type="text" name="as" class="form-control" id="as" placeholder="As">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="fe" class="form-label">Fe</label>
                        <input type="text" name="fe" class="form-control" id="fe" placeholder="Fe">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ni" class="form-label">Ni</label>
                        <input type="text" name="ni" class="form-control" id="ni" placeholder="Ni">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ge" class="form-label">Ge</label>
                        <input type="text" name="ge" class="form-control" id="ge" placeholder="Ga">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="in" class="form-label">In</label>
                        <input type="text" name="in" class="form-control" id="in" placeholder="Ni">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="zn" class="form-label">Zn</label>
                        <input type="text" name="zn" class="form-control" id="zn" placeholder="Zn">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="pe" class="form-label">Pe</label>
                        <input type="text" name="pe" class="form-control" id="pe" placeholder="Pe">
                    </div>

                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </div>

            <!-- Form 2: Formulir Pembayaran -->
            <div id="Logam Timah Grade 99.85%" style="display: none;">
                <div class="row">
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="sn" class="form-label">Sn</label>
                        <input type="text" name="sn_b" class="form-control" id="sn_b" placeholder="Sn">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="cu" class="form-label">Cu</label>
                        <input type="text" name="cu_b" class="form-control" id="cu_b" placeholder="Cu">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="pb" class="form-label">Pb</label>
                        <input type="text" name="pb_b" class="form-control" id="pb_b" placeholder="Pb">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="sb" class="form-label">Sb</label>
                        <input type="text" name="sb_b" class="form-control" id="sb_b" placeholder="Sb">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="bi" class="form-label">Bi</label>
                        <input type="text" name="bi_b" class="form-control" id="bi_b" placeholder="Bi">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="cd" class="form-label">Cd</label>
                        <input type="text" name="cd_b" class="form-control" id="cd_b" placeholder="Cd">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ai" class="form-label">Ai</label>
                        <input type="text" name="ai_b" class="form-control" id="ai_b" placeholder="Ai">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ag" class="form-label">Ag</label>
                        <input type="text" name="ag_b" class="form-control" id="ag_b" placeholder="Ag">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="as" class="form-label">As</label>
                        <input type="text" name="as_b" class="form-control" id="as_b" placeholder="As">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="fe" class="form-label">Fe</label>
                        <input type="text" name="fe_b" class="form-control" id="fe_b" placeholder="Fe">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ni" class="form-label">Ni</label>
                        <input type="text" name="ni_b" class="form-control" id="ni_b" placeholder="Ni">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="ge" class="form-label">Ge</label>
                        <input type="text" name="ge_b" class="form-control" id="ge_b" placeholder="Ga">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="in" class="form-label">In</label>
                        <input type="text" name="in_b" class="form-control" id="in_b" placeholder="Ni">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="zn" class="form-label">Zn</label>
                        <input type="text" name="zn_b" class="form-control" id="zn_b" placeholder="Zn">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="pe" class="form-label">Pe</label>
                        <input type="text" name="pe_b" class="form-control" id="pe_b" placeholder="Pe">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </div>
            
            <!-- Form 3: Methyl Chloride (MeCl)-->
            <div id="Methyl Chloride (MeCl)" style="display: none;">
                <div class="row">
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="purity_mecl" class="form-label">Purity</label>
                        <input type="text" name="purity_mecl" class="form-control" id="purity_mecl" placeholder="Purity">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </div>

            <!-- Form 4: Tetramethyl Ammmonium Chloride (TMAC)-->
            <div id="Tetramethyl Ammmonium Chloride (TMAC)" style="display: none;">
                <div class="row">
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="appreance_tmac" class="form-label">Appreance</label>
                        <input type="text" name="appreance_tmac" class="form-control" id="appreance_tmac" placeholder="Appreance">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="purity_tmac" class="form-label">Purity</label>
                        <input type="text" name="purity_tmac" class="form-control" id="purity_tmac" placeholder="Purity">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </div>

            <!-- Form 5: Ammonia -->
            <div id="Ammonia" style="display: none;">
                <div class="row">
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="appreance_ammo" class="form-label">Appreance</label>
                        <input type="text" name="appreance_ammo" class="form-control" id="appreance_ammo" placeholder="Appreance">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="purity_ammo" class="form-label">Purity / Assay</label>
                        <input type="text" name="purity_ammo" class="form-control" id="purity_ammo" placeholder="Purity">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="specific_ammo" class="form-label">Specific Gravity</label>
                        <input type="text" name="specific_ammo" class="form-control" id="specific_ammo" placeholder="Specific Gravity">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="iron_ammo" class="form-label">Iron (as Fe)</label>
                        <input type="text" name="iron_ammo" class="form-control" id="iron_ammo" placeholder="iron">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="chlorides_ammo" class="form-label">Chlorides (as CI)</label>
                        <input type="text" name="chlorides_ammo" class="form-control" id="chlorides_ammo" placeholder="chlorides">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="heavy_ammo" class="form-label">Heavy Metals (as Pb)</label>
                        <input type="text" name="heavy_ammo" class="form-control" id="heavy_ammo" placeholder="Heavy Metals">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </div>

            <!-- Form 5:  Ethylhexyl Thioglicolate (2-EHTG) -->
            <div id="Ethylhexyl Thioglicolate (2-EHTG)" style="display: none;">
                <div class="row">
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="appreance_ammo" class="form-label">Appreance</label>
                        <input type="text" name="appreance_ammo" class="form-control" id="appreance_ammo" placeholder="Appreance">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="purity_ammo" class="form-label">Purity / Assay</label>
                        <input type="text" name="purity_ammo" class="form-control" id="purity_ammo" placeholder="Purity">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="specific_ammo" class="form-label">Specific Gravity</label>
                        <input type="text" name="specific_ammo" class="form-control" id="specific_ammo" placeholder="Specific Gravity">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="iron_ammo" class="form-label">Iron (as Fe)</label>
                        <input type="text" name="iron_ammo" class="form-control" id="iron_ammo" placeholder="iron">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="chlorides_ammo" class="form-label">Chlorides (as CI)</label>
                        <input type="text" name="chlorides_ammo" class="form-control" id="chlorides_ammo" placeholder="chlorides">
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <label for="heavy_ammo" class="form-label">Heavy Metals (as Pb)</label>
                        <input type="text" name="heavy_ammo" class="form-control" id="heavy_ammo" placeholder="Heavy Metals">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('tipe_rawmat').addEventListener('change', function () {
        const selectedForm = this.value;
        document.getElementById('Logam Timah Grade 99.9%').style.display = selectedForm === 'Logam Timah Grade 99.9%' ? 'block' : 'none';
        document.getElementById('Logam Timah Grade 99.85%').style.display = selectedForm === 'Logam Timah Grade 99.85%' ? 'block' : 'none';
        document.getElementById('Methyl Chloride (MeCl)').style.display = selectedForm === 'Methyl Chloride (MeCl)' ? 'block' : 'none';
        document.getElementById('Tetramethyl Ammmonium Chloride (TMAC)').style.display = selectedForm === 'Tetramethyl Ammmonium Chloride (TMAC)' ? 'block' : 'none';
        document.getElementById('Ammonia').style.display = selectedForm === 'Ammonia' ? 'block' : 'none';
        document.getElementById('Ethylhexyl Thioglicolate (2-EHTG)').style.display = selectedForm === 'Ethylhexyl Thioglicolate (2-EHTG)' ? 'block' : 'none';

    });
        // Handle auto-fill of namaProduk
        document.getElementById('tipe_rawmat').addEventListener('change', function () {
        const namaProdukInput = document.getElementById('nama');
        if (this.value === 'Logam Timah Grade 99.9%') {
        namaProdukInput.value = 'Logam Timah / Tin Ingot (Grade 99.90)';
        } else if (this.value === 'Logam Timah Grade 99.85%') {
            namaProdukInput.value = 'Logam Timah / Tin Ingot (Grade 99.85)';
        } else if (this.value === 'Methyl Chloride (MeCl)') {
            namaProdukInput.value = 'Methyl Chloride (MeCl)';
        } else if (this.value === 'Tetramethyl Ammmonium Chloride (TMAC)') {
            namaProdukInput.value = 'Tetramethyl Ammmonium Chloride';
        } else if (this.value === 'Ammonia') {
            namaProdukInput.value = 'Aqueous Ammonia / Aquos NH3 / NH4OH';
        } else if (this.value === 'Ethylhexyl Thioglicolate (2-EHTG)') {
            namaProdukInput.value = '2-Ethylhexyl Thioglicolate (2-EHTG)';
        }
    });
</script>

@endsection