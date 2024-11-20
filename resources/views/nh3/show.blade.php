@extends('layouts.app')
  
@section('title', 'Show Product')
  
@section('contents')
    <h1 class="mb-0">Detail Product</h1>
    <hr />
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" placeholder="Title" value="{{ $nh3->nama_nh3 }}" readonly>
        </div>
       
    </div>
@endsection