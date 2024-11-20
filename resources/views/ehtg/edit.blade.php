@extends('layouts.app')

@section('title', 'Edit EHTG')

@section('contents')
    <div class="container">
        <h1 class="mb-0">Update Mecl</h1>
        <hr />
        <form action="{{ route('ehtg.update', $ehtg->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Nama EHTG</label>
                    <input type="text" name="nama_ehtg" class="form-control" placeholder="Nama EHTG" value="{{ old('nama_ehtg', $ehtg->nama_ehtg) }}" required>
                    @error('nama_mecl')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="d-grid">
                    <button class="btn btn-warning">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection
