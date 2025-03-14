@extends('layouts.app')

@section('contents')

    <div class="card shadow-sm">
        <div class="card-header bg-light py-3">
            <h6 class="m-0 font-weight-bold">Edit Data | Data Chemical</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('datachemical.update', $dataChemical->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama" class="font-weight-medium">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama', $dataChemical->nama) }}">
                    @error('nama')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kategori" class="font-weight-medium">Kategori</label>
                    <input type="text" name="kategori" class="form-control" id="kategori" value="{{ old('kategori', $dataChemical->kategori) }}">
                    @error('kategori')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tgl" class="font-weight-medium">Tanggal</label>
                    <input type="date" name="tgl" class="form-control" id="tgl" value="{{ old('tgl', $dataChemical->tgl) }}">
                    @error('tgl')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="batch" class="font-weight-medium">Batch</label>
                    <input type="text" name="batch" class="form-control" id="batch" value="{{ old('batch', $dataChemical->batch) }}">
                    @error('batch')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="desc" class="font-weight-medium">Description</label>
                    <input type="text" name="desc" class="form-control" id="desc" value="{{ old('desc', $dataChemical->desc) }}">
                    @error('desc')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="orang" class="font-weight-medium">Orang</label>
                    <input type="text" name="orang" class="form-control" id="orang" value="{{ old('orang', $dataChemical->orang) }}">
                    @error('orang')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="clarity" class="font-weight-medium">Clarity</label>
                    <input type="text" name="clarity" class="form-control" id="clarity" value="{{ old('clarity', $dataChemical->clarity) }}">
                    @error('clarity')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="transmission" class="font-weight-medium">Transmission</label>
                    <input type="text" name="transmission" class="form-control" id="transmission" value="{{ old('transmission', $dataChemical->transmission) }}">
                    @error('transmission')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ape" class="font-weight-medium">Ape</label>
                    <input type="text" name="ape" class="form-control" id="ape" value="{{ old('ape', $dataChemical->ape) }}">
                    @error('ape')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="dimet" class="font-weight-medium">Dimet</label>
                    <input type="text" name="dimet" class="form-control" id="dimet" value="{{ old('dimet', $dataChemical->dimet) }}">
                    @error('dimet')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="trime" class="font-weight-medium">Trime</label>
                    <input type="text" name="trime" class="form-control" id="trime" value="{{ old('trime', $dataChemical->trime) }}">
                    @error('trime')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tin" class="font-weight-medium">Tin</label>
                    <input type="text" name="tin" class="form-control" id="tin" value="{{ old('tin', $dataChemical->tin) }}">
                    @error('tin')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Add the other fields manually here in the same way -->

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary px-4 py-2">Update</button>
                    <a href="{{ route('datachemical.index') }}" class="btn btn-secondary px-4 py-2">Kembali</a>
                </div>
            </form>
        </div>
    </div>

@endsection
