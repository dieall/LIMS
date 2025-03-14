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
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />
    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-up.html" />

    <title>Sign Up | PT Timah Industri</title>

    <link href="{{ asset('admin_assets/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="text-center mt-4">
                            <h1 class="h2">Get started</h1>
                            <p class="lead">
                                Start creating the best possible user experience for your customers.
                            </p>
                        </div>

						<div class="card">
    <div class="card-body">
        <div class="text-center mb-4">
            <img src="{{ asset('admin_assets/img/photos/login.png') }}" class="img-fluid" style="max-width: 250px; height: auto;" alt="Timah">
        </div>
        <div class="m-sm-4">
		<form action="{{ route('register.save') }}" method="POST" class="user">
    @csrf

    <!-- Name and Email Fields -->
    <div class="row mb-3">
        <div class="col">
            <label class="form-label" for="exampleInputName">Name</label>
            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder="Name" value="{{ old('name') }}">
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="col">
            <label class="form-label" for="exampleInputEmail">Email</label>
            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="Email Address" value="{{ old('email') }}">
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Department and Jabatan Fields -->
    <div class="row mb-3">
        <div class="col">
            <label class="form-label" for="departement">Departement</label>
            <select name="departement" class="form-control @error('departement') is-invalid @enderror" id="departement">
                <option value="" selected disabled>Pilih Departement</option>
                <option value="Quality Control" {{ old('departement') == 'Quality Control' ? 'selected' : '' }}>Quality Control</option>
                <option value="Produksi" {{ old('departement') == 'Produksi' ? 'selected' : '' }}>Produksi</option>
                <option value="Purchasing" {{ old('departement') == 'Purchasing' ? 'selected' : '' }}>Purchasing</option>
                <option value="RND" {{ old('departement') == 'RND' ? 'selected' : '' }}>RND</option>
                <option value="Other" {{ old('departement') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('departement')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="col">
            <label class="form-label" for="jabatan">Jabatan</label>
            <input name="jabatan" type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" placeholder="Jabatan" value="{{ old('jabatan') }}">
            @error('jabatan')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Password and Repeat Password Fields -->
    <div class="row mb-3">
        <div class="col">
            <label class="form-label" for="exampleInputPassword">Password</label>
            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Password">
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="col">
            <label class="form-label" for="exampleRepeatPassword">Repeat Password</label>
            <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="exampleRepeatPassword" placeholder="Repeat Password">
            @error('password_confirmation')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Alamat and Tanggal Lahir Fields -->
    <div class="row mb-3">
        <div class="col">
            <label class="form-label" for="exampleInputAlamat">Alamat</label>
            <input name="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" id="exampleInputAlamat" placeholder="Alamat" value="{{ old('alamat') }}">
            @error('alamat')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="col">
            <label class="form-label" for="exampleInputTglLahir">Tanggal Lahir</label>
            <input name="tgl_lahir" type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" id="exampleInputTglLahir" value="{{ old('tgl_lahir') }}">
            @error('tgl_lahir')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Submit Button -->
    <div class="text-center mt-3">
        <button type="submit" class="btn btn-bold-sm btn-primary">Register Account</button>
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
	<script>
    // Mengisi nilai alamat dengan string kosong
    document.getElementById('exampleInputName').value = "";
	document.getElementById('exampleInputNamee').value = "";
</script>
    <script src="{{ asset('admin_assets/js/app.js') }}"></script>

</body>

</html>