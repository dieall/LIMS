@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('instrument.index') }}">Data Kondisi Instrumen</a></li>
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
        <form action="{{ route('instrument.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <!-- Kolom Kiri 1 -->
                <div class="col-md-6">
                    <label for="shift" class="form-label">Shift</label>
                    <input type="text" name="shift" class="form-control" id="shift" placeholder="Masukkan Shift" value="{{ $shift }}" readonly>
                </div>

                <div class="col-md-6">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tgl" class="form-control" id="tgl" required readonly>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Kolom Kiri 2 -->
                <div class="col-md-6">
                    <label for="jam" class="form-label">Jam</label>
                    <input type="time" name="jam" class="form-control" id="jam" placeholder="Masukkan Jam" required readonly>
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

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light text-dark">
                        <tr>
                            <th>Nama Instrumen</th>
                            <th style="text-align: center; width: 150px;">Kondisi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($instruments as $instrument)
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="nama_instrument[{{ $instrument->id }}]" value="{{ old('nama_instrument.' . $instrument->id, $instrument->nama_instrument) }}" required readonly>
                                </td>
                                <td>
                                    <div class="form-check" style="display: flex; justify-content: space-between; width: 150px;">
                                        <label class="form-check-label" for="normal" style="margin-right: 10px;">
                                            <input class="form-check-input" type="checkbox" name="kondisi[{{ $instrument->id }}][]" value="Normal" {{ in_array('Normal', old('kondisi.' . $instrument->id, [])) ? 'checked' : '' }}> Normal
                                        </label>
                                        <label class="form-check-label" for="trouble">
                                            <input class="form-check-input" type="checkbox" name="kondisi[{{ $instrument->id }}][]" value="Trouble" {{ in_array('Trouble', old('kondisi.' . $instrument->id, [])) ? 'checked' : '' }}> Trouble
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <textarea name="keterangan[{{ $instrument->id }}]" class="form-control">{{ old('keterangan.' . $instrument->id) }}</textarea>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Instrumen</button>
        </form>
    </div>
</div>

<script>
// Fungsi untuk menentukan shift berdasarkan jam saat ini
function setShift() {
    const currentTime = new Date();
    const hours = currentTime.getHours();

    let shift = '';
    if (hours >= 0 && hours < 8) {
        shift = 'Shift 1';
    } else if (hours >= 8 && hours < 16) {
        shift = 'Shift 2';
    } else if (hours >= 16 && hours < 24) {
        shift = 'Shift 3';
    }
    document.getElementById('shift').value = shift;
}

// Fungsi untuk mengatur tanggal hari ini
const today = new Date().toISOString().split('T')[0];
document.getElementById('tgl').value = today;

// Fungsi untuk mengatur waktu saat ini
function setJam() {
    const currentTime = new Date();
    const hours = String(currentTime.getHours()).padStart(2, '0');
    const minutes = String(currentTime.getMinutes()).padStart(2, '0');
    const formattedTime = `${hours}:${minutes}`;
    document.getElementById('jam').value = formattedTime;
}

window.onload = function() {
    setShift();
    setJam();
};
</script>
@endsection
