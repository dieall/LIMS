@extends('layouts.app')

@section('title', 'Edit Logam Timah')

@section('contents')
    <div class="container">
        <h1 class="mb-0">Update nh3</h1>
        <hr />
        <form action="{{ route('nh3.update', $nh3->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Nama Logam Timah</label>
                    <input type="text" name="nama_nh3" class="form-control" placeholder="Nama nh3" value="{{ old('nama_nh3', $nh3->nama_nh3) }}" required>
                    @error('nama_nh3')
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
