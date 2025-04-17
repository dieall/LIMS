@extends('layouts.app')

@section('contents')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Add New Raw Material</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('datarawmat.store') }}" method="POST">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2">Basic Information</h6>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                id="nama" name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_rawmat" class="form-label">Nama Rawmat</label>
                            <input type="text" class="form-control @error('nama_rawmat') is-invalid @enderror" 
                                id="nama_rawmat" name="nama_rawmat" value="{{ old('nama_rawmat') }}">
                            @error('nama_rawmat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2">Chemical Properties</h6>
                    </div>
                    @foreach(['sn', 'ag', 'cu', 'pb', 'sb', 'zn', 'as', 'ni', 'bi', 'cd', 'ai', 'pe', 'ga'] as $field)
                        <div class="col-md-3 col-sm-6">
                            <div class="mb-3">
                                <label for="{{ $field }}" class="form-label">{{ strtoupper($field) }}</label>
                                <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" value="{{ old($field) }}">
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2">Physical Properties</h6>
                    </div>
                    @foreach(['purity', 'purity_tmac', 'appreance', 'sg', 'visual', 'color'] as $field)
                        <div class="col-md-4 col-sm-6">
                            <div class="mb-3">
                                <label for="{{ $field }}" class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                                <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" value="{{ old($field) }}">
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary border-bottom pb-2">Additional Properties</h6>
                    </div>
                    @foreach(['fe_amo', 'si_amo', 'sh', 'acid', 'ri', 'free', 'ph', 'fe', 'si', 'sulfur', 'water', 'acidity', 'lodine','densi','clarity','apha'] as $field)
                        <div class="col-md-3 col-sm-6">
                            <div class="mb-3">
                                <label for="{{ $field }}" class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                                <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" value="{{ old($field) }}">
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="border-top pt-3 d-flex justify-content-between">
                    <a href="{{ route('datarawmat') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
