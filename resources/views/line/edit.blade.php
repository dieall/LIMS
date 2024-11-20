@extends('layouts.app')

@section('title', 'Edit Logam Timah')

@section('contents')
    <div class="container">
        <h1 class="mb-0">Update line</h1>
        <hr />
        <form action="{{ route('line.update', $line->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Nama Logam Timah</label>
                    <input type="text" name="nama_line" class="form-control" placeholder="Nama line" value="{{ old('nama_line', $line->nama_line) }}" required>
                    @error('nama_line')
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
