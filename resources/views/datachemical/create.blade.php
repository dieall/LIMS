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
            <form action="{{ route('datachemical.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Dropdown untuk Nama Kategori -->
                <div class="mb-3">
                    <label for="kategori" class="form-label">Nama Kategori</label>
                    <select name="kategori" class="form-control select2" id="kategori" required>
                        <option disabled selected value="">Pilih Kategori</option>
                        <option value="DMT">DMT</option>
                        <option value="Tinchem">Tinchem</option>
                        <option value="Tinstab">Tinstab</option>
                    </select>
                </div>


             
                <!-- Container untuk Dropdown Dynamic -->
                <div class="mb-3" id="dynamic-dropdown-container"></div>

                <div class="form-group mb-3">
                    <label for="date">Tanggal</label>
                    <input type="date" class="form-control" id="date" name="tgl" required>
                </div>


                <div class="form-group mb-3">
                    <label for="batch">Batch</label>
                    <input type="text" class="form-control" id="batch" name="batch" placeholder="Masukkan Batch" required>
                </div>

                <div class="form-group mb-3">
                    <label for="desc">Deskripsi</label>
                    <input type="text" class="form-control" id="desc" name="desc" placeholder="Masukkan Deskripsi" required>
                    <br>
                    * Jika hanya mengajukan sampel maka klik submit <p>
                    * Jika hanya membuat sampel baru maka klik Tampilkan Form
                </div>
                <div class="form-group mb-3" style="display: none;">
                    <label for="jam_masuk">Jam Masuk</label>
                    <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" required>
                </div>
                <!-- Input Orang (Otomatis) -->
                <div class="form-group mb-3" style="display: none;">
                    <label for="orang">Orang</label>
                    <input type="text" class="form-control" id="orang" name="orang" readonly>
                </div>
                <input type="hidden" name="status" value="Pengajuan">



                <!-- Form untuk DMT-98 -->
                <div id="DMT-98" style="display: none;">
                    <h4>Form DMT-98</h4>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ape" class="form-label">Appreance</label>
                            <input type="text" class="form-control" id="ape" name="ape" placeholder="Masukkan Appreance">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="dimet" class="form-label">Dimethlytin Dichloride</label>
                            <input type="text" class="form-control" id="dimet" name="dimet" placeholder="Masukkan Dimethlytin Dichloride">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="mono" class="form-label">Monomethyltin Trichloride</label>
                            <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin Monochloride">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="trime" class="form-label">Trimethyltin Monochloride</label>
                            <input type="text" class="form-control" id="trime" name="trime" placeholder="Masukkan Trimethyltin Monochloride">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="moisture" class="form-label">Moisture Content</label>
                            <input type="text" class="form-control" id="moisture" name="moisture" placeholder="Masukkan Moisture Content">
                        </div>
                    </div>
                </div>

                <!-- Form untuk DMTDCL 510 -->
                <div id="DMTDCL-510" style="display: none;">
                    <h4>Form DMTDCL 510</h4>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ape" class="form-label">Appreance</label>
                            <input type="text" class="form-control" id="ape" name="ape" placeholder="Masukkan Appreance">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="solid" class="form-label">% Solid Content</label>
                            <input type="text" class="form-control" id="solid" name="solid" placeholder="Masukkan DMT Level">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tin" class="form-label">% Tin Content</label>
                            <input type="text" class="form-control" id="tin" name="tin" placeholder="Masukkan DMT Level">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tin" class="form-label">% Tin Content</label>
                            <input type="text" class="form-control" id="tin" name="tin" placeholder="Masukkan DMT Level">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="mono" class="form-label">Monomethyltin Trichloride</label>
                            <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin Monochloride">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="trime" class="form-label">Trimethyltin Monochloride</label>
                            <input type="text" class="form-control" id="trime" name="trime" placeholder="Masukkan Trimethyltin Monochloride">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="cloride" class="form-label">Cloride</label>
                            <input type="text" class="form-control" id="cloride" name="cloride" placeholder="Masukkan Trimethyltin Monochloride">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="spec" class="form-label">Specific Gravity</label>
                            <input type="text" class="form-control" id="spec" name="spec" placeholder="Masukkan Trimethyltin Monochloride">
                        </div>
                    </div>
                </div>

                <!-- Form untuk DMTDCL 515 -->
                <div id="DMTDCL-515" style="display: none;">
                    <h4>Form DMTDCL 515</h4>
                    <div class="row">
                    <div class="col-md-4 mb-3">
                            <label for="ape" class="form-label">Appreance</label>
                            <input type="text" class="form-control" id="ape" name="ape" placeholder="Masukkan Appreance">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="solid" class="form-label">% Solid Content</label>
                            <input type="text" class="form-control" id="solid" name="solid" placeholder="Masukkan DMT Level">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tin" class="form-label">% Tin Content</label>
                            <input type="text" class="form-control" id="tin" name="tin" placeholder="Masukkan DMT Level">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tin" class="form-label">% Tin Content</label>
                            <input type="text" class="form-control" id="tin" name="tin" placeholder="Masukkan DMT Level">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="mono" class="form-label">Monomethyltin Trichloride</label>
                            <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin Monochloride">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="trime" class="form-label">Trimethyltin Monochloride</label>
                            <input type="text" class="form-control" id="trime" name="trime" placeholder="Masukkan Trimethyltin Monochloride">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="cloride" class="form-label">Cloride</label>
                            <input type="text" class="form-control" id="cloride" name="cloride" placeholder="Masukkan Trimethyltin Monochloride">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="spec" class="form-label">CSpecific Gravity</label>
                            <input type="text" class="form-control" id="spec" name="spec" placeholder="Masukkan Trimethyltin Monochloride">
                        </div>
                    </div>
                </div>

                <!-- Form untuk TC-191 -->
<!-- Form untuk TC-191 -->
            <div id="TC-191" style="display: none;">
                <h4>Form TC-191</h4>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="clarity" class="form-label">Clarity</label>
                        <input type="text" class="form-control" id="clarity" name="clarity" placeholder="Masukkan Clarity">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="transmission" class="form-label">% Transmission</label>
                        <input type="text" class="form-control" id="transmission" name="transmission" placeholder="Masukkan % Transmission">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tin" class="form-label">% Tin</label>
                        <input type="text" class="form-control" id="tin" name="tin" placeholder="Masukkan % Tin">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ri" class="form-label">RI @ 25 C</label>
                        <input type="text" class="form-control" id="ri" name="ri" placeholder="Masukkan RI @ 25 C">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="sg" class="form-label">SG @ 25 C</label>
                        <input type="text" class="form-control" id="sg" name="sg" placeholder="Masukkan SG @ 25 C">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="acid" class="form-label">Acid Value</label>
                        <input type="text" class="form-control" id="acid" name="acid" placeholder="Masukkan Acid Value">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="sulfur" class="form-label">% Sulfur</label>
                        <input type="text" class="form-control" id="sulfur" name="sulfur" placeholder="Masukkan % Sulfur">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="water" class="form-label">Water Content</label>
                        <input type="text" class="form-control" id="water" name="water" placeholder="Masukkan Water Content">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="mono" class="form-label">Monomethyltin</label>
                        <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin">
                    </div>
                </div>
            </div>

        <div id="TC-191 F" style="display: none;">
            <h4>Form TC-191 F</h4>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="clarity" class="form-label">Clarity</label>
                    <input type="text" class="form-control" id="clarity" name="clarity" placeholder="Masukkan Clarity">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="transmission" class="form-label">% Transmission</label>
                    <input type="text" class="form-control" id="transmission" name="transmission" placeholder="Masukkan % Transmission">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tin" class="form-label">% Tin</label>
                    <input type="text" class="form-control" id="tin" name="tin" placeholder="Masukkan % Tin">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ri" class="form-label">RI @ 25 C</label>
                    <input type="text" class="form-control" id="ri" name="ri" placeholder="Masukkan RI @ 25 C">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="sg" class="form-label">SG @ 25 C</label>
                    <input type="text" class="form-control" id="sg" name="sg" placeholder="Masukkan SG @ 25 C">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="acid" class="form-label">Acid Value</label>
                    <input type="text" class="form-control" id="acid" name="acid" placeholder="Masukkan Acid Value">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="sulfur" class="form-label">% Sulfur</label>
                    <input type="text" class="form-control" id="sulfur" name="sulfur" placeholder="Masukkan % Sulfur">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="water" class="form-label">Water Content</label>
                    <input type="text" class="form-control" id="water" name="water" placeholder="Masukkan Water Content">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mono" class="form-label">Monomethyltin</label>
                    <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin">
                </div>
            </div>
        </div>

        <div id="TC-181 FS" style="display: none;">
            <h4>Form TC-181 FS</h4>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="clarity" class="form-label">Clarity</label>
                    <input type="text" class="form-control" id="clarity" name="clarity" placeholder="Masukkan Clarity">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="transmission" class="form-label">% Transmission</label>
                    <input type="text" class="form-control" id="transmission" name="transmission" placeholder="Masukkan % Transmission">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tin" class="form-label">% Tin</label>
                    <input type="text" class="form-control" id="tin" name="tin" placeholder="Masukkan % Tin">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ri" class="form-label">RI @ 25 C</label>
                    <input type="text" class="form-control" id="ri" name="ri" placeholder="Masukkan RI @ 25 C">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="sg" class="form-label">SG @ 25 C</label>
                    <input type="text" class="form-control" id="sg" name="sg" placeholder="Masukkan SG @ 25 C">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="acid" class="form-label">Acid Value</label>
                    <input type="text" class="form-control" id="acid" name="acid" placeholder="Masukkan Acid Value">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="sulfur" class="form-label">% Sulfur</label>
                    <input type="text" class="form-control" id="sulfur" name="sulfur" placeholder="Masukkan % Sulfur">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="water" class="form-label">Water Content</label>
                    <input type="text" class="form-control" id="water" name="water" placeholder="Masukkan Water Content">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mono" class="form-label">Monomethyltin</label>
                    <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin">
                </div>
            </div>
        </div>

        <div id="TCZ-159" style="display: none;">
            <h4>Form TCZ-159</h4>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="clarity" class="form-label">Clarity</label>
                    <input type="text" class="form-control" id="clarity" name="clarity" placeholder="Masukkan Clarity">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="transmission" class="form-label">% Transmission</label>
                    <input type="text" class="form-control" id="transmission" name="transmission" placeholder="Masukkan % Transmission">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="yellow" class="form-label">Yellowish Index</label>
                    <input type="text" class="form-control" id="yellow" name="yellow" placeholder="Masukkan % Tin">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ri" class="form-label">RI @ 25 C</label>
                    <input type="text" class="form-control" id="ri" name="ri" placeholder="Masukkan RI @ 25 C">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ri" class="form-label">Density</label>
                    <input type="text" class="form-control" id="densi" name="densi" placeholder="Masukkan densi">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="sg" class="form-label">SG @ 25 C</label>
                    <input type="text" class="form-control" id="sg" name="sg" placeholder="Masukkan SG @ 25 C">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="acid" class="form-label">Acid Value</label>
                    <input type="text" class="form-control" id="acid" name="acid" placeholder="Masukkan Acid Value">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="sulfur" class="form-label">% Sulfur</label>
                    <input type="text" class="form-control" id="sulfur" name="sulfur" placeholder="Masukkan % Sulfur">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="water" class="form-label">Water Content</label>
                    <input type="text" class="form-control" id="water" name="water" placeholder="Masukkan Water Content">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mono" class="form-label">Monomethyltin</label>
                    <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin">
                </div>
            </div>
        </div>

        <div id="TCZ-139 M" style="display: none;">
            <h4>Form TCZ-139 M</h4>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="clarity" class="form-label">Clarity</label>
                    <input type="text" class="form-control" id="clarity" name="clarity" placeholder="Masukkan Clarity">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="transmission" class="form-label">% Transmission</label>
                    <input type="text" class="form-control" id="transmission" name="transmission" placeholder="Masukkan % Transmission">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="spec" class="form-label">Specific Gravity</label>
                    <input type="text" class="form-control" id="spec" name="spec" placeholder="Masukkan Trimethyltin Monochloride">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ri" class="form-label">Density</label>
                    <input type="text" class="form-control" id="densi" name="densi" placeholder="Masukkan densi">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="yellow" class="form-label">Yellowish Index</label>
                    <input type="text" class="form-control" id="yellow" name="yellow" placeholder="Masukkan % Tin">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="water" class="form-label">Water Content</label>
                    <input type="text" class="form-control" id="water" name="water" placeholder="Masukkan Water Content">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mono" class="form-label">Monomethyltin</label>
                    <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin">
                </div>
            </div>
        </div>

        <div id="TCZ-139" style="display: none;">
            <h4>Form TCZ-139</h4>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="clarity" class="form-label">Clarity</label>
                    <input type="text" class="form-control" id="clarity" name="clarity" placeholder="Masukkan Clarity">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="transmission" class="form-label">% Transmission</label>
                    <input type="text" class="form-control" id="transmission" name="transmission" placeholder="Masukkan % Transmission">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="spec" class="form-label">Specific Gravity</label>
                    <input type="text" class="form-control" id="spec" name="spec" placeholder="Masukkan Trimethyltin Monochloride">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ri" class="form-label">Density</label>
                    <input type="text" class="form-control" id="densi" name="densi" placeholder="Masukkan densi">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="yellow" class="form-label">Yellowish Index</label>
                    <input type="text" class="form-control" id="yellow" name="yellow" placeholder="Masukkan % Tin">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="water" class="form-label">Water Content</label>
                    <input type="text" class="form-control" id="water" name="water" placeholder="Masukkan Water Content">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mono" class="form-label">Monomethyltin</label>
                    <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin">
                </div>
            </div>
        </div>

        <div id="TC-192 F" style="display: none;">
                <h4>Form TC-192 F</h4>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="clarity" class="form-label">Clarity</label>
                        <input type="text" class="form-control" id="clarity" name="clarity" placeholder="Masukkan Clarity">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="transmission" class="form-label">% Transmission</label>
                        <input type="text" class="form-control" id="transmission" name="transmission" placeholder="Masukkan % Transmission">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tin" class="form-label">% Tin</label>
                        <input type="text" class="form-control" id="tin" name="tin" placeholder="Masukkan % Tin">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ri" class="form-label">RI @ 25 C</label>
                        <input type="text" class="form-control" id="ri" name="ri" placeholder="Masukkan RI @ 25 C">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="sg" class="form-label">SG @ 25 C</label>
                        <input type="text" class="form-control" id="sg" name="sg" placeholder="Masukkan SG @ 25 C">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="acid" class="form-label">Acid Value</label>
                        <input type="text" class="form-control" id="acid" name="acid" placeholder="Masukkan Acid Value">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="sulfur" class="form-label">% Sulfur</label>
                        <input type="text" class="form-control" id="sulfur" name="sulfur" placeholder="Masukkan % Sulfur">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="water" class="form-label">Water Content</label>
                        <input type="text" class="form-control" id="water" name="water" placeholder="Masukkan Water Content">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="mono" class="form-label">Monomethyltin</label>
                        <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin">
                    </div>
                </div>
            </div>
            <div id="TC-181" style="display: none;">
                <h4>Form TC-181</h4>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="clarity" class="form-label">Clarity</label>
                        <input type="text" class="form-control" id="clarity" name="clarity" placeholder="Masukkan Clarity">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="transmission" class="form-label">% Transmission</label>
                        <input type="text" class="form-control" id="transmission" name="transmission" placeholder="Masukkan % Transmission">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tin" class="form-label">% Tin</label>
                        <input type="text" class="form-control" id="tin" name="tin" placeholder="Masukkan % Tin">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ri" class="form-label">RI @ 25 C</label>
                        <input type="text" class="form-control" id="ri" name="ri" placeholder="Masukkan RI @ 25 C">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="sg" class="form-label">SG @ 25 C</label>
                        <input type="text" class="form-control" id="sg" name="sg" placeholder="Masukkan SG @ 25 C">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="acid" class="form-label">Acid Value</label>
                        <input type="text" class="form-control" id="acid" name="acid" placeholder="Masukkan Acid Value">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="sulfur" class="form-label">% Sulfur</label>
                        <input type="text" class="form-control" id="sulfur" name="sulfur" placeholder="Masukkan % Sulfur">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="water" class="form-label">Water Content</label>
                        <input type="text" class="form-control" id="water" name="water" placeholder="Masukkan Water Content">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="mono" class="form-label">Monomethyltin</label>
                        <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin">
                    </div>
                </div>
            </div>


            <div id="TC-181 VN" style="display: none;">
                <h4>Form TC-181 VN</h4>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="clarity" class="form-label">Clarity</label>
                        <input type="text" class="form-control" id="clarity" name="clarity" placeholder="Masukkan Clarity">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="transmission" class="form-label">% Transmission</label>
                        <input type="text" class="form-control" id="transmission" name="transmission" placeholder="Masukkan % Transmission">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tin" class="form-label">% Tin</label>
                        <input type="text" class="form-control" id="tin" name="tin" placeholder="Masukkan % Tin">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ri" class="form-label">RI @ 25 C</label>
                        <input type="text" class="form-control" id="ri" name="ri" placeholder="Masukkan RI @ 25 C">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="sg" class="form-label">SG @ 25 C</label>
                        <input type="text" class="form-control" id="sg" name="sg" placeholder="Masukkan SG @ 25 C">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="acid" class="form-label">Acid Value</label>
                        <input type="text" class="form-control" id="acid" name="acid" placeholder="Masukkan Acid Value">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="sulfur" class="form-label">% Sulfur</label>
                        <input type="text" class="form-control" id="sulfur" name="sulfur" placeholder="Masukkan % Sulfur">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="water" class="form-label">Water Content</label>
                        <input type="text" class="form-control" id="water" name="water" placeholder="Masukkan Water Content">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="mono" class="form-label">Monomethyltin</label>
                        <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin">
                    </div>
                </div>
            </div>






        

                <!-- Form untuk MT-630 -->
                <!-- Form untuk MT-630 (Tinstab) -->
                <div id="MT-630" style="display: none;">
                    <h4>Form MT-630</h4>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="cla" class="form-label">Clarity</label>
                            <input type="text" class="form-control" id="clarity" name="clarity" placeholder="Masukkan Clarity">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="transmission" class="form-label">% Transmission</label>
                            <input type="text" class="form-control" id="transmission" name="transmission" placeholder="Masukkan % Transmission">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tin" class="form-label">% Tin</label>
                            <input type="text" class="form-control" id="tin" name="tin" placeholder="Masukkan % Tin">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="ri" class="form-label">RI @ 25 C</label>
                            <input type="text" class="form-control" id="ri" name="ri" placeholder="Masukkan RI @ 25 C">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="sg" class="form-label">SG @ 25 C</label>
                            <input type="text" class="form-control" id="sg" name="sg" placeholder="Masukkan SG @ 25 C">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="acid" class="form-label">Acid Value</label>
                            <input type="text" class="form-control" id="acid" name="acid" placeholder="Masukkan Acid Value">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="sulfur" class="form-label">% Sulfur</label>
                            <input type="text" class="form-control" id="sulfur" name="sulfur" placeholder="Masukkan % Sulfur">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="water" class="form-label">Water Content</label>
                            <input type="text" class="form-control" id="water" name="water" placeholder="Masukkan Water Content">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="yellow" class="form-label">Yellowish Index</label>
                            <input type="text" class="form-control" id="yellow" name="yellow" placeholder="Masukkan Yellowish Index">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="eh" class="form-label">2-EH</label>
                            <input type="text" class="form-control" id="eh" name="eh" placeholder="Masukkan 2-EH">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="visco" class="form-label">Viscosity @ 25 C</label>
                            <input type="text" class="form-control" id="visco" name="visco" placeholder="Masukkan Viscosity @ 25 C">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pt" class="form-label">Pt-Co</label>
                            <input type="text" class="form-control" id="pt" name="pt" placeholder="Masukkan Pt-Co">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="mono" class="form-label">Monomethyltin</label>
                            <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin">
                        </div>
                    </div>
                </div>
                <!-- Form untuk MT-620 (Tinstab) -->
                <div id="MT-620" style="display: none;">
                    <h4>Form MT-620</h4>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="clarity" class="form-label">Clarity</label>
                            <input type="text" class="form-control" id="clarity" name="clarity" placeholder="Masukkan Clarity">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="transmission" class="form-label">% Transmission</label>
                            <input type="text" class="form-control" id="transmission" name="transmission" placeholder="Masukkan % Transmission">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="tin" class="form-label">% Tin</label>
                            <input type="text" class="form-control" id="tin" name="tin" placeholder="Masukkan % Tin">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="ri" class="form-label">RI @ 25 C</label>
                            <input type="text" class="form-control" id="ri" name="ri" placeholder="Masukkan RI @ 25 C">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="sg" class="form-label">SG @ 25 C</label>
                            <input type="text" class="form-control" id="sg" name="sg" placeholder="Masukkan SG @ 25 C">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="acid" class="form-label">Acid Value</label>
                            <input type="text" class="form-control" id="acid" name="acid" placeholder="Masukkan Acid Value">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="sulfur" class="form-label">% Sulfur</label>
                            <input type="text" class="form-control" id="sulfur" name="sulfur" placeholder="Masukkan % Sulfur">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="water" class="form-label">Water Content</label>
                            <input type="text" class="form-control" id="water" name="water" placeholder="Masukkan Water Content">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="yellow" class="form-label">Yellowish Index</label>
                            <input type="text" class="form-control" id="yellow" name="yellow" placeholder="Masukkan Yellowish Index">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="eh" class="form-label">2-EH</label>
                            <input type="text" class="form-control" id="eh" name="eh" placeholder="Masukkan 2-EH">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="visco" class="form-label">Viscosity @ 25 C</label>
                            <input type="text" class="form-control" id="visco" name="visco" placeholder="Masukkan Viscosity @ 25 C">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pt" class="form-label">Pt-Co</label>
                            <input type="text" class="form-control" id="pt" name="pt" placeholder="Masukkan Pt-Co">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="mono" class="form-label">Monomethyltin</label>
                            <input type="text" class="form-control" id="mono" name="mono" placeholder="Masukkan Monomethyltin">
                        </div>
                    </div>
                </div>



             <button type="submit" class="btn btn-primary">Submit</button> | <button type="button" id="showFormBtn" class="btn btn-success" disabled>
                        Tampilkan Form
                    </button>
   
            </form>
        </div>
    </div>
</div>

<script>
    const showFormBtn = document.getElementById('showFormBtn');
    let selectedChemical = '';

    // Dropdown Dinamis
    document.getElementById('kategori').addEventListener('change', function () {
        const container = document.getElementById('dynamic-dropdown-container');
        const selectedValue = this.value;

        container.innerHTML = '';
        showFormBtn.disabled = true;

        if (selectedValue === 'DMT') {
            container.innerHTML = generateDropdown(["DMT-98", "DMTDCL-510", "DMTDCL-515"]);
        } else if (selectedValue === 'Tinchem') {
            container.innerHTML = generateDropdown([
                "TC-191", "TC-191 F", "TC-181 FS", "TCZ-159", "TCZ-139 M", 
                "TCZ-139", "TC-192 F", "TC-181", "TC-181 VN"
            ]);
        } else if (selectedValue === 'Tinstab') {
            container.innerHTML = generateDropdown(["MT-630", "MT-620"]);
        }

        document.getElementById('data-chemical').addEventListener('change', function () {
            selectedChemical = this.value;
            showFormBtn.disabled = false;
        });
    });

    function generateDropdown(options) {
        let html = `
            <label for="data-chemical" class="form-label">Pilih Data Chemical</label>
            <select name="nama" class="form-control" id="data-chemical">
                <option disabled selected value="">Pilih</option>`;
        options.forEach(option => {
            html += `<option value="${option}">${option}</option>`;
        });
        html += `</select>`;
        return html;
    }

    // Tombol Tampilkan Form
    showFormBtn.addEventListener('click', function () {
        const forms = [
            "DMT-98", "DMTDCL-510", "DMTDCL-515", "TC-191", "TC-191 F", 
            "TC-181 FS", "TCZ-159", "TCZ-139 M", "TCZ-139", "TC-192 F", 
            "TC-181", "TC-181 VN", "MT-630", "MT-620"
        ];

        // Sembunyikan semua form
        forms.forEach(form => {
            document.getElementById(form).style.display = 'none';
        });

        // Tampilkan form sesuai pilihan
        if (selectedChemical) {
            document.getElementById(selectedChemical).style.display = 'block';
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Set Tanggal Otomatis
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];
        document.getElementById('date').value = formattedDate;

        // Set Jam Masuk Otomatis
        const hours = today.getHours().toString().padStart(2, '0'); // Format 2 digit jam
        const minutes = today.getMinutes().toString().padStart(2, '0'); // Format 2 digit menit
        const formattedTime = `${hours}:${minutes}`;
        document.getElementById('jam_masuk').value = formattedTime;

        const namaPengguna = "{{ Auth::user()->name ?? 'User Default' }}"; // Ambil dari Laravel Auth atau nilai default
        document.getElementById('orang').value = namaPengguna;
    });
</script>

@endsection
