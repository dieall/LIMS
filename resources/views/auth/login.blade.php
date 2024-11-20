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
	<link rel="shortcut icon" href="{{ asset('admin_assets/img/photos/timah.png') }}" />
	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

	<title>Sign In | AdminKit Demo</title>

	<link href="{{ asset('admin_assets/css/app.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-8 col-md-6 col-lg-4 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Welcome back</h1>
							<p class="lead">Sign in to your account to continue</p>
						</div>

						<div class="card shadow-sm" style="border-radius: 15px;">
							<div class="card-body p-1">
								<div class="m-sm-5">
									<div class="text-center mb-2">
										<img src="{{ asset('admin_assets/img/photos/login.png') }}" class="img-fluid" style="max-width: 250px; height: auto;" alt="Timah">
									</div>

									<form class="px-1 py-5" action="{{ route('login.action') }}" method="POST">
										@csrf
										@if ($errors->any())
											<div class="alert alert-danger">
												<ul>
													@foreach ($errors->all() as $error)
														<li>{{ $error }}</li>
													@endforeach
												</ul>
											</div>
										@endif
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input name="email" type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com" required>
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input name="password" type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password" required>
										<br>
												Dont Have Account? <a href="{{ route('register') }}"> Register</a>
										</div>
										<!-- <div>
											<label class="form-check">
												<input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked>
												<span class="form-check-label">Remember me next time</span>
											</label>
										</div> -->
										<div class="text-center mt-1">
											<button type="submit" class="btn btn-bold-sm btn-primary">Sign in</button>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="{{ asset('admin_assets/js/app.js') }}"></script>

</body>

</html>
