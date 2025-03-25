<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <!-- Sidebar Brand -->
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
    <img src="{{ asset('admin_assets/img/photos/lege.png') }}" style="max-width: 210px; height: auto; max-height: auto;">
</a>

        <!-- Sidebar Navigation -->
        <ul class="sidebar-nav">
            <!-- Pages Section -->
            <li class="sidebar-header">Pages</li>

            @if (Auth::check() && (Auth::user()->level === 'Admin' || Auth::user()->level === 'Operator QC' || Auth::user()->level === 'Operator Lab' || Auth::user()->level === 'Supervisor' || Auth::user()->level === 'Foreman' || Auth::user()->level === 'Manager' || Auth::user()->level === 'General Manager'))
    <li class="sidebar-item active">
        <a class="sidebar-link" href="{{ route('dashboard') }}">
            <i class="fas fa-home align-middle"></i>
            <span class="align-middle">Dashboard</span>
        </a>
    </li>

    <!-- Data Pengajuan Section -->
    <li class="sidebar-header">Data Sampel</li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('pengajuanrawmat') }}" data-bs-toggle="tooltip" title="Lihat Data Pengajuan Rawmat">
            <i class="fas fa-box align-middle"></i>
            <span class="align-middle">Sampel Rawmat</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('pengajuansolder') }}" data-bs-toggle="tooltip" title="Lihat Data Pengajuan Solder">
            <i class="fas fa-tools align-middle"></i>
            <span class="align-middle">Sampel Solder</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('pengajuanchemical') }}" data-bs-toggle="tooltip" title="Lihat Data Pengajuan Chemical">
            <i class="fas fa-flask align-middle"></i>
            <span class="align-middle">Sampel Chemical</span>
        </a>
    </li>

    <!-- Tools & Components Section -->
    <li class="sidebar-header">Data Pengajuan</li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('datarawmat') }}" data-bs-toggle="tooltip" title="Lihat Data Raw Material">
            <i class="fas fa-cube align-middle"></i>
            <span class="align-middle">Sampel Rawmat</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('datasolder') }}" data-bs-toggle="tooltip" title="Lihat Data Solder">
            <i class="fas fa-boxes align-middle"></i>
            <span class="align-middle">Sampel Solder</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('datachemical') }}" data-bs-toggle="tooltip" title="Lihat Data Chemical">
            <i class="fas fa-vial align-middle"></i>
            <span class="align-middle">Sampel Chemical</span>
        </a>
    </li>
    <li class="sidebar-header">Data Pengajuan</li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('instruments') }}" data-bs-toggle="tooltip" title="Lihat Kondisi Instrument">
            <i class="fas fa-vial align-middle"></i>
            <span class="align-middle">Kondisi Instrument</span>
        </a>
    </li>
    @if (Auth::user()->level === 'Admin')
    <!-- Master Section -->
    <li class="sidebar-header">Master</li>

 
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('user') }}">
                <i class="fas fa-users align-middle"></i>
                <span class="align-middle">Data Pegawai</span>
            </a>
        </li>       
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('import') }}">
                <i class="fas fa-file-export align-middle"></i>
                <span class="align-middle">Export Data</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('datainterval') }}">
                <i class="fas fa-tasks align-middle"></i>
                <span class="align-middle">Data Interval</span>
            </a>
        </li>

    @endif
@endif




        </ul>
    </div>
</nav>


<!-- Include CSS Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<!-- Include JS Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
