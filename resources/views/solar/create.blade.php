@extends('layouts.app')

@section('title', 'Create Product')

@section('contents')
<div class="container mt-7">
    <div class="card shadow mb-2">
        <div class="card-header py-3">
            <h1 class="m-0 font-weight-bold text-primary">Tambah solar</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('solar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="nama_solar" class="form-control" placeholder="Title" required>
                    </div>
                </div>
                <div class="row">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
