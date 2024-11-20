<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">AdminKit</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">Pages</li>

            @if (Auth::user()->level === 'Admin')
            <li class="sidebar-item active">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" data-bs-toggle="collapse" href="#rawMatDropdown1" role="button" aria-expanded="false" aria-controls="rawMatDropdown1">
                    <i class="align-middle" data-feather="box"></i>
                    <span class="align-middle">In-Coming RawMat</span>
                    <i class="align-middle float-end" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="rawMatDropdown1">
                    <ul class="sidebar-dropdown list-unstyled">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('mecl') }}">MecL</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('logamtimah') }}">Logam Timah</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('ehtg') }}">2-EHTG</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('nh3') }}">NH3</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('logamtimbal') }}">Logam Timbal</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('solar') }}">Solar</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" data-bs-toggle="collapse" href="#rawMatDropdown" role="button" aria-expanded="false" aria-controls="rawMatDropdown">
                    <i class="align-middle" data-feather="box"></i>
                    <span class="align-middle">In-Progres FG</span>
                    <i class="align-middle float-end" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="rawMatDropdown">
                    <ul class="sidebar-dropdown list-unstyled">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('line') }}">Line</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('mixing') }}">Mixing</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('trial') }}">Trial Formulasi</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('ri') }}">R1</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('re') }}">R3</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('filtrasi') }}">Filtrasi</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('sir') }}">Sir.Storage</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('finish') }}">Finish Good</a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('solder') }}">Solder</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-header">Tambah Data</li>
            
            <li class="sidebar-item">
                <a class="sidebar-link" data-bs-toggle="collapse" href="#dataDmtDropdown" role="button" aria-expanded="false" aria-controls="dataDmtDropdown">
                    <i class="align-middle" data-feather="file-plus"></i><!-- Ikon box untuk Data Tinstab -->
                    <span class="align-middle">Data DMT</span>
                    <i class="align-middle float-end" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="dataDmtDropdown">
                    <ul class="sidebar-dropdown list-unstyled">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('dmt.create') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah DMT
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('dmt.create1') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah DMTDCL 515
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('dmt.create2') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah DMTDCL 510  
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" data-bs-toggle="collapse" href="#dataTinstabDropdown" role="button" aria-expanded="false" aria-controls="dataTinstabDropdown">
                    <i class="align-middle" data-feather="file-plus"></i><!-- Ikon box untuk Data Tinstab -->
                    <span class="align-middle">Data Tinstab</span>
                    <i class="align-middle float-end" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="dataTinstabDropdown">
                    <ul class="sidebar-dropdown list-unstyled">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('tinstab.create') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah MT-630
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('tinstab.create1') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah MT-620
                            </a>
                        </li>

                        
                    </ul>
                </div>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" data-bs-toggle="collapse" href="#dataTinchemDropdown" role="button" aria-expanded="false" aria-controls="dataTinchemDropdown">
                    <i class="align-middle" data-feather="file-plus"></i> <!-- Ikon box untuk Data Tinstab -->
                    <span class="align-middle">Data Tinchem</span>
                    <i class="align-middle float-end" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="dataTinchemDropdown">
                    <ul class="sidebar-dropdown list-unstyled">
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('tinchem.create') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah TC-191
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('tinchem.create1') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah TC-192 F
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('tinchem.create2') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah TC-185 VN
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('tinchem.create3') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah TC-181
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('tinchem.create5') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah TCZ-139
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('tinchem.create6') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah TCZ-139 M
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('tinchem.create7') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah TCZ-159
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('tinchem.create8') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah TC-191 F
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('tinchem.create9') }}">
                                <i class="align-middle" data-feather="plus"></i> 
                                Tambah TC-181 FS
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-header">Data Pengajuan</li>


            
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('pengajuansolder') }}">
                    <i class="align-middle" data-feather="info"></i>
                    <span class="align-middle">Pengajuan Solder</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('transaksi') }}">
                    <i class="align-middle" data-feather="info"></i>
                    <span class="align-middle">Pengajuan Sampel</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('datasolder') }}">
                    <i class="align-middle" data-feather="info"></i>
                    <span class="align-middle">Pengajuan Coba Solder</span>
                </a>
            </li>



            

            <li class="sidebar-header">Tools & Components</li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('user') }}">
                    <i class="align-middle" data-feather="user"></i>
                    <span class="align-middle">Data Pegawai</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('dmt') }}">
                    <i class="align-middle" data-feather="database"></i>
                    <span class="align-middle">Data DMT</span>
                </a>
            </li>


            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('categorysolder') }}">
                    <i class="align-middle" data-feather="smile"></i>
                    <span class="align-middle">Data Category Solder</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('category') }}">
                    <i class="align-middle" data-feather="list"></i>
                    <span class="align-middle">Data Category</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('tinchem') }}">
                    <i class="align-middle" data-feather="database"></i>
                    <span class="align-middle">Data Tinchem</span>
                </a>
            </li>
            <li class="sidebar-item">   
                <a class="sidebar-link" href="{{ route('tinstab') }}">
                    <i class="align-middle" data-feather="database"></i>
                    <span class="align-middle">Data Tinstab</span>
                </a>
            </li>



            <li class="sidebar-item">
    <a class="sidebar-link" data-bs-toggle="collapse" href="#dataSolderDropdown" role="button" aria-expanded="false" aria-controls="dataSolderDropdown">
        <i class="align-middle" data-feather="file-plus"></i><!-- Ikon box untuk Data Tinstab -->
        <span class="align-middle">Data Solder</span>
        <i class="align-middle float-end" data-feather="chevron-down"></i>
    </a>
    <div class="collapse" id="dataSolderDropdown">
        <ul class="sidebar-dropdown list-unstyled">
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('sncu') }}">
                    <i class="align-middle" data-feather="plus"></i> 
                    Data Sn/Cu Series
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('snagcu') }}">
                    <i class="align-middle" data-feather="plus"></i> 
                    Data Sn/Ag/Cu Series
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('snag') }}">
                    <i class="align-middle" data-feather="plus"></i> 
                    Data Sn/Ag Series 
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('tin') }}">
                    <i class="align-middle" data-feather="plus"></i> 
                    Data Tin-Lead Solder Bar
                </a>
            </li>

        </ul>
    </div>
</li>
            <li class="sidebar-header">Master</li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('import') }}">
                    <i class="align-middle" data-feather="info"></i>
                    <span class="align-middle">Export Data</span>
                </a>
            </li>

            
            @endif
        </ul>
    </div>
</nav>

<!-- Include CSS Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<!-- Include JS Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
