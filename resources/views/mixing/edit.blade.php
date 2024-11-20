@extends('layouts.app')

@section('title', 'Edit Logam Timah')

@section('contents')
    <div class="container">
        <h1 class="mb-0">Update mixing</h1>
        <hr />
        <form action="{{ route('mixing.update', $mixing->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Nama Logam Timah</label>
                    <input type="text" name="nama_mixing" class="form-control" placeholder="Nama mixing" value="{{ old('nama_mixing', $mixing->nama_mixing) }}" required>
                    @error('nama_mixing')
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
