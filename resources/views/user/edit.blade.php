@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item">
                <a href="{{ url('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Data Pegawai</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit Data
            </li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Edit Data Pegawai</h6>
    </div>

    <div class="card-body">
        <!-- Form Edit -->
        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan Nama" value="{{ $user->name }}" required>
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" value="{{ $user->tgl_lahir }}" required>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukkan Alamat" value="{{ $user->alamat }}" required>
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <div>
                    <div class="form-check">
                        <input type="radio" name="jenis_kelamin" class="form-check-input" id="pria" value="Pria" {{ $user->jenis_kelamin == 'Pria' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="pria">Pria</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="jenis_kelamin" class="form-check-input" id="perempuan" value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" value="{{ $user->password }}" required>
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label for="level" class="form-label">Role</label>
                <select name="level" class="form-control" id="level" required>
                    <option value="" disabled>Pilih Role</option>
                    <option value="Admin" {{ $user->level == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Operator QC" {{ $user->level == 'Operator QC' ? 'selected' : '' }}>Operator Quality Control</option>
                    <option value="Operator Lab" {{ $user->level == 'Operator Lab' ? 'selected' : '' }}>Operator Laboratorium</option>
                    <option value="Foreman" {{ $user->level == 'Foreman' ? 'selected' : '' }}>Foreman</option>
                    <option value="Supervisor" {{ $user->level == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                    <option value="Manager" {{ $user->level == 'Manager' ? 'selected' : '' }}>Manager</option>
                    <option value="General Manager" {{ $user->level == 'General Manager' ? 'selected' : '' }}>General Manager</option>
                    <option value="Internal Costumer" {{ $user->level == 'Internal Costumer' ? 'selected' : '' }}>Internal Costumer</option>
                </select>
            </div>

            <!-- Tombol Simpan -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection
