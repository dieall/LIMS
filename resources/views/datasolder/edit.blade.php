@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('datasolder') }}">Daftar Solder</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Data Solder</li>
        </ol>
        <hr>
    </nav>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Edit Data Solder</h6>
    </div>
    
    <div class="card-body">
        <form action="{{ route('datasolder.update', $datasolder->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group row">
                <label for="nama_kategori" class="col-md-3 col-form-label">Nama Kategori</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $datasolder->nama_kategori) }}" required readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="tipe_solder" class="col-md-3 col-form-label">Tipe Solder</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="tipe_solder" name="tipe_solder" value="{{ old('tipe_solder', $datasolder->tipe_solder) }}" required readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="spesification" class="col-md-3 col-form-label">Spesifikasi</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="spesification" name="spesification" value="{{ old('spesification', $datasolder->spesification) }}" required readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="tgl" class="col-md-3 col-form-label">Tanggal</label>
                <div class="mb-3">
                    <input type="date" class="form-control" id="tgl" name="tgl" value="{{ old('tgl', $datasolder->tgl) }}" required readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="rev" class="col-md-3 col-form-label">Rev</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="rev" name="rev" value="{{ old('rev', $datasolder->rev) }}" required readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="sn" class="col-md-3 col-form-label">Sn</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="sn" name="sn" value="{{ old('sn', $datasolder->sn) }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="ag" class="col-md-3 col-form-label">Ag</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="ag" name="ag" value="{{ old('ag', $datasolder->ag) }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="cu" class="col-md-3 col-form-label">Cu</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="cu" name="cu" value="{{ old('cu', $datasolder->cu) }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="pb" class="col-md-3 col-form-label">Pb</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="pb" name="pb" value="{{ old('pb', $datasolder->pb) }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="sb" class="col-md-3 col-form-label">Sb</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="sb" name="sb" value="{{ old('sb', $datasolder->sb) }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="zn" class="col-md-3 col-form-label">Zn</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="zn" name="zn" value="{{ old('zn', $datasolder->zn) }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="fe" class="col-md-3 col-form-label">Fe</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="fe" name="fe" value="{{ old('fe', $datasolder->fe) }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="as" class="col-md-3 col-form-label">As</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="as" name="as" value="{{ old('as', $datasolder->as) }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="ni" class="col-md-3 col-form-label">Ni</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="ni" name="ni" value="{{ old('ni', $datasolder->ni) }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="bi" class="col-md-3 col-form-label">Bi</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="bi" name="bi" value="{{ old('bi', $datasolder->bi) }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="cd" class="col-md-3 col-form-label">Cd</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="cd" name="cd" value="{{ old('cd', $datasolder->cd) }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="ai" class="col-md-3 col-form-label">Ai</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="ai" name="ai" value="{{ old('ai', $datasolder->ai) }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="pe" class="col-md-3 col-form-label">Pe</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="pe" name="pe" value="{{ old('pe', $datasolder->pe) }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="ga" class="col-md-3 col-form-label">Ga</label>
                <div class="mb-3">
                    <input type="text" class="form-control" id="ga" name="ga" value="{{ old('ga', $datasolder->ga) }}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <a href="{{ route('datasolder') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
