@extends('layouts.app')

@section('title', 'Edit Logam Timah')

@section('contents')
    <div class="container">
        <h1 class="mb-0">Update solar</h1>
        <hr />
        <form action="{{ route('solar.update', $solar->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Nama Logam Timah</label>
                    <input type="text" name="nama_solar" class="form-control" placeholder="Nama solar" value="{{ old('nama_solar', $solar->nama_solar) }}" required>
                    @error('nama_solar')
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
