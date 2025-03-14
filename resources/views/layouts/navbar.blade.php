<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <img 
        src="{{ asset('admin_assets/img/photos/logotimah.jpg') }}" 
        alt="Company Logo" 
        class="img-fluid" 
        style="max-width: 105px; height: auto; max-height: auto;"
    >

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <!-- Dropdown for smaller screens -->
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <!-- Dropdown for larger screens -->
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="user"></i>
                    <span class="text-dark">
                        {{ auth()->user()->name }} ( {{ auth()->user()->level }} )
                    </span>
                </a>

                <!-- Dropdown Menu -->
                <div class="dropdown-menu dropdown-menu-end">

                    <a class="dropdown-item" href="{{ route('logout') }}">Log out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
