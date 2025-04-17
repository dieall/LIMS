@extends('layouts.app')

@section('contents')
    <div class="container mt-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Edit Data Rawmat</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('datarawmat.update', $dataRawmat->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        @foreach($fields as $field)
                            <div class="col-md-6 mb-3">
                                <label for="{{ $field }}" class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                                <input type="text" name="{{ $field }}" class="form-control" id="{{ $field }}" 
                                    value="{{ old($field, $dataRawmat->{$field}) }}" {{ $field == 'nama' || $field == 'supplier' ? 'required' : '' }}>
                                
                                @error($field)
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('datarawmat') }}" class="btn btn-secondary">Back to List</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
