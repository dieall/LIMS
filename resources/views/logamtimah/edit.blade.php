@extends('layouts.app')

@section('title', 'Edit Logam Timah')

@section('contents')


    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Tambah Data MecL</h6>
    </div>
    <div class="container">
        <h1 class="mb-0">Edit Logam Timah</h1>
        <hr />
        <form action="{{ route('logamtimah.update', $logamtimah->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Nama Logam Timah</label>
                    <input type="text" name="nama_logamtimah" class="form-control" placeholder="Nama Logam Timah" value="{{ old('nama_logamtimah', $logamtimah->nama_logamtimah) }}" required>
                    @error('nama_logamtimah')
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
