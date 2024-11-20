@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Data MecL</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Tambah Data
            </li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data Pegawai</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan Nama" required>
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" required>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukkan Alamat" required>
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <div>
                    <div class="form-check">
                        <input type="radio" name="jenis_kelamin" class="form-check-input" id="pria" value="Pria" required>
                        <label class="form-check-label" for="pria">Pria</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="jenis_kelamin" class="form-check-input" id="perempuan" value="Perempuan" required>
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Password" required>
            </div>
            <div class="mb-3">
				<label class="form-label">Repeat Password</label>
				<input name="password_confirmation" type="password" class="form-control form-control-user @error('password_confirmation') is-invalid @enderror" id="exampleRepeatPassword" placeholder="Repeat Password">
				@error('password_confirmation')
				<span class="invalid-feedback">{{ $message }}</span>
				@enderror
			</div>

            <!-- Role -->
            <div class="mb-3">
                <label for="level" class="form-label">Role</label>
                <select name="level" class="form-control" id="level" required>
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Operator">Operator</option>
                    <option value="Foreman">Foreman</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Manager">Manager</option>
                    <option value="General Manager">General Manager</option>
                    <option value="Internal Costumer">Internal Costumer</option>

                </select>
            </div>  

            <!-- Tombol Simpan -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection
