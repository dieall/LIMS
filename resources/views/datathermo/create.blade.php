@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('datathermo') }}">Data Kondisi Instrumen</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Instrumen</li>
        </ol>
        <hr>
    </nav>
</div>

@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Instrumen Baru</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('datathermo.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <!-- Kolom Kiri 1 -->
                <div class="col-md-6">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tgl" class="form-control" id="tgl" required readonly>
                </div>
                <div class="col-md-6">
                    <label for="waktu" class="form-label">Waktu</label>
                    <input type="time" name="waktu" class="form-control" id="waktu" placeholder="Masukkan waktu" required readonly>
                </div>
                
                <div class="col-md-6">
                    <label for="user_id" class="form-label">Nama</label>
                    <select name="user_id" class="form-control" id="user_id" required>
                        <option value="">Pilih Nama</option> <!-- Opsi default -->
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" 
                                {{ old('user_id', auth()->user()->id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>




            </div>
            <hr>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light text-dark">
                        <tr>
                            <th>Nama Instrumen</th>
                            <th>Suhu</th>
                            <th>Kelembapan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($thermodata as $thermo)
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="nama_thermo[{{ $thermo->id }}]" value="{{ old('nama_thermo.' . $thermo->id, $thermo->nama_thermo) }}" required readonly>
                            </td>

                            <!-- Kolom Suhu -->
                            <td>
                                <input type="text" name="suhu[{{ $thermo->id }}]" id="suhu_{{ $thermo->id }}" class="form-control" value="{{ old('suhu.' . $thermo->id) }}" placeholder="Masukkan suhu" required>
                            </td>

                            <!-- Kolom Kelembapan -->
                            <td>
                                <input type="text" name="kelembapan[{{ $thermo->id }}]" id="kelembapan_{{ $thermo->id }}" class="form-control" value="{{ old('kelembapan.' . $thermo->id) }}" placeholder="Masukkan kelembapan" required>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
    </div>
</div>

<script>
// Fungsi untuk mengatur tanggal hari ini
const today = new Date().toISOString().split('T')[0];
document.getElementById('tgl').value = today;

// Fungsi untuk mengatur waktu saat ini
function setwaktu() {
    const currentTime = new Date();
    const hours = String(currentTime.getHours()).padStart(2, '0');
    const minutes = String(currentTime.getMinutes()).padStart(2, '0');
    const formattedTime = `${hours}:${minutes}`;
    document.getElementById('waktu').value = formattedTime;
}

// Panggil fungsi untuk set waktu ketika halaman dimuat
window.onload = function() {
    setwaktu();
};
</script>
@endsection
