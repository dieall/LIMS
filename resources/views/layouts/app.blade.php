<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin & Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{ asset('admin_assets/img/icons/icon-48x48.png') }}" />

	<!-- Optional: Replace canonical URL if this is a deployed site -->
	<link rel="canonical" href="https://your-site-url.com/" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
	<title>@yield('title', 'PT Timah Industri')</title>

	<!-- Custom CSS -->
	<link href="{{ asset('admin_assets/css/app.css') }}" rel="stylesheet">
    
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- Main content area -->
        <div class="main">
            <!-- Top navigation bar -->
            @include('layouts.navbar')
            
            <!-- Page Content -->
            <main class="content">
                @yield('contents')
            </main>

            @include('layouts.footer')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin_assets/js/app.js') }}"></script>
    
</body>

</html>
