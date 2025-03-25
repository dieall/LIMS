@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('instrument.index') }}">Data Kondisi Instrument</a></li>
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
                                <div class="row">
                    <!-- Kolom Kiri 1 -->
                    <div class="col-md-6 mb-3">
    <label for="shift" class="form-label">Shift</label>
    <input type="text" name="shift" class="form-control" id="shift" placeholder="Masukkan Shift" value="{{ $shift }}" readonly>
</div>
                    <div class="col-md-6 mb-3">
    <label for="tanggal" class="form-label">Tanggal</label>
    <input type="date" name="tgl" class="form-control" id="tgl" required readonly>
</div>

                </div>

                <div class="row">
                    <!-- Kolom Kiri 2 -->
                    <div class="col-md-6 mb-3">
    <label for="jam" class="form-label">Jam</label>
    <input type="time" name="jam" class="form-control" id="jam" placeholder="Masukkan Jam" required readonly>
</div>
<div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <!-- Menampilkan nama pengguna -->
                            <input type="text" name="nama" class="form-control" id="nama" value="{{ auth()->user()->name }}" required readonly>

                            <!-- Hidden input untuk menyimpan user_id yang sebenarnya -->
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        </div>
                </div>
                        @foreach($instruments as $instrument)
                            <tr>
                                <td>
                                    <!-- Input untuk nama instrumen, dikirimkan dalam bentuk array -->
                                    <input type="text" class="form-control" name="nama_instrument[{{ $instrument->id }}]" value="{{ old('nama_instrument.' . $instrument->id, $instrument->nama_instrument) }}" required readonly>
                                </td>
                                <td>
                                    <div class="form-check" style="display: flex; justify-content: space-between; width: 150px;">
                                        <!-- Kondisi array, menggunakan multiple checkbox -->
                                        <label class="form-check-label" for="normal" style="margin-right: 10px;">
                                            <input class="form-check-input" type="checkbox" name="kondisi[{{ $instrument->id }}][]" value="Normal" {{ in_array('Normal', old('kondisi.' . $instrument->id, [])) ? 'checked' : '' }}> Normal
                                        </label>
                                        <label class="form-check-label" for="trouble">
                                            <input class="form-check-input" type="checkbox" name="kondisi[{{ $instrument->id }}][]" value="Trouble" {{ in_array('Trouble', old('kondisi.' . $instrument->id, [])) ? 'checked' : '' }}> Trouble
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <!-- Keterangan per instrumen -->
                                    <textarea name="keterangan[{{ $instrument->id }}]" class="form-control" value=".">{{ old('keterangan.' . $instrument->id) }}</textarea>
                                </td>
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
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
    const currentTime = new Date(); // Mendapatkan waktu saat ini
    const hours = currentTime.getHours(); // Mengambil jam saat ini

    let shift = ''; // Variabel untuk menyimpan shift

    // Menentukan shift berdasarkan jam
    if (hours >= 0 && hours < 8) {
        shift = 'Shift 1'; // Jam 00:00 - 08:00
    } else if (hours >= 8 && hours < 16) {
        shift = 'Shift 2'; // Jam 08:00 - 16:00
    } else if (hours >= 16 && hours < 24) {
        shift = 'Shift 3'; // Jam 16:00 - 23:59
    }

    // Menetapkan nilai shift ke dalam input
    document.getElementById('shift').value = shift;
}

// Panggil fungsi setShift untuk mengatur shift saat halaman dimuat
window.onload = setShift;
</script>
<script>
        const today = new Date().toISOString().split('T')[0];
    document.getElementById('tgl').value = today;

</script>

<script>
    function setJam() {
        const currentTime = new Date(); // Mendapatkan waktu saat ini
        
        const hours = String(currentTime.getHours()).padStart(2, '0'); // Mengambil jam (format 24 jam)
        const minutes = String(currentTime.getMinutes()).padStart(2, '0'); // Mengambil menit

        // Menyusun format waktu menjadi HH:MM
        const formattedTime = `${hours}:${minutes}`;
        
        // Menetapkan nilai waktu ke dalam input
        document.getElementById('jam').value = formattedTime;
    }

    // Panggil fungsi setJam untuk mengatur jam saat halaman dimuat
    window.onload = setJam;
</script>
@endsection
