@extends('layouts.app')

@section('contents')
<style>
    /* Card and form styling */
    .card {
        border-radius: 8px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
    }
    
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    /* Field grouping */
    .field-section {
        border-bottom: 1px solid #e3e6f0;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-weight: 600;
        color: #4e73df;
        margin-bottom: 1rem;
    }
</style>

<div class="panel-body mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('datachemical.index') }}"><i class="fas fa-flask"></i> Data Chemical</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-edit"></i> Edit Data</li>
        </ol>
    </nav>
</div>

@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-1"></i> {{ Session::get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-1"></i> {{ Session::get('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-header bg-gradient-primary text-white py-3">
        <h6 class="m-0 font-weight-bold"><i class="fas fa-edit me-2"></i> Edit Data Chemical</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('datachemical.update', $dataChemical->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="field-section">
                <h5 class="section-title"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama Chemical</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama', $dataChemical->nama) }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" id="kategori" value="{{ old('kategori', $dataChemical->kategori) }}">
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tgl" class="form-label">Tanggal</label>
                            <input type="date" name="tgl" class="form-control @error('tgl') is-invalid @enderror" id="tgl" value="{{ old('tgl', $dataChemical->tgl) }}">
                            @error('tgl')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="batch" class="form-label">Batch</label>
                            <input type="text" name="batch" class="form-control @error('batch') is-invalid @enderror" id="batch" value="{{ old('batch', $dataChemical->batch) }}">
                            @error('batch')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="desc" class="form-label">Description</label>
                            <input type="text" name="desc" class="form-control @error('desc') is-invalid @enderror" id="desc" value="{{ old('desc', $dataChemical->desc) }}">
                            @error('desc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="orang" class="form-label">Operator</label>
                            <input type="text" name="orang" class="form-control @error('orang') is-invalid @enderror" id="orang" value="{{ old('orang', $dataChemical->orang) }}">
                            @error('orang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Physical Properties Section -->
            <div class="field-section">
                <h5 class="section-title"><i class="fas fa-tint me-2"></i>Physical Properties</h5>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="clarity" class="form-label">Clarity</label>
                            <input type="text" name="clarity" class="form-control @error('clarity') is-invalid @enderror" id="clarity" value="{{ old('clarity', $dataChemical->clarity) }}">
                            @error('clarity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="transmission" class="form-label">Transmission</label>
                            <input type="text" name="transmission" class="form-control @error('transmission') is-invalid @enderror" id="transmission" value="{{ old('transmission', $dataChemical->transmission) }}">
                            @error('transmission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="solid" class="form-label">Solid</label>
                            <input type="text" name="solid" class="form-control @error('solid') is-invalid @enderror" id="solid" value="{{ old('solid', $dataChemical->solid) }}">
                            @error('solid')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="moisture" class="form-label">Moisture</label>
                            <input type="text" name="moisture" class="form-control @error('moisture') is-invalid @enderror" id="moisture" value="{{ old('moisture', $dataChemical->moisture) }}">
                            @error('moisture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ri" class="form-label">RI</label>
                            <input type="text" name="ri" class="form-control @error('ri') is-invalid @enderror" id="ri" value="{{ old('ri', $dataChemical->ri) }}">
                            @error('ri')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sg" class="form-label">SG</label>
                            <input type="text" name="sg" class="form-control @error('sg') is-invalid @enderror" id="sg" value="{{ old('sg', $dataChemical->sg) }}">
                            @error('sg')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="densi" class="form-label">Densitas</label>
                            <input type="text" name="densi" class="form-control @error('densi') is-invalid @enderror" id="densi" value="{{ old('densi', $dataChemical->densi) }}">
                            @error('densi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="visco" class="form-label">Viscositas</label>
                            <input type="text" name="visco" class="form-control @error('visco') is-invalid @enderror" id="visco" value="{{ old('visco', $dataChemical->visco) }}">
                            @error('visco')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="pt" class="form-label">PT</label>
                            <input type="text" name="pt" class="form-control @error('pt') is-invalid @enderror" id="pt" value="{{ old('pt', $dataChemical->pt) }}">
                            @error('pt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="yellow" class="form-label">Yellow Index</label>
                            <input type="text" name="yellow" class="form-control @error('yellow') is-invalid @enderror" id="yellow" value="{{ old('yellow', $dataChemical->yellow) }}">
                            @error('yellow')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="eh" class="form-label">EH</label>
                            <input type="text" name="eh" class="form-control @error('eh') is-invalid @enderror" id="eh" value="{{ old('eh', $dataChemical->eh) }}">
                            @error('eh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Chemical Properties Section -->
            <div class="field-section">
                <h5 class="section-title"><i class="fas fa-flask me-2"></i>Chemical Properties</h5>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ape" class="form-label">APE</label>
                            <input type="text" name="ape" class="form-control @error('ape') is-invalid @enderror" id="ape" value="{{ old('ape', $dataChemical->ape) }}">
                            @error('ape')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="dimet" class="form-label">Dimet</label>
                            <input type="text" name="dimet" class="form-control @error('dimet') is-invalid @enderror" id="dimet" value="{{ old('dimet', $dataChemical->dimet) }}">
                            @error('dimet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="trime" class="form-label">Trime</label>
                            <input type="text" name="trime" class="form-control @error('trime') is-invalid @enderror" id="trime" value="{{ old('trime', $dataChemical->trime) }}">
                            @error('trime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tin" class="form-label">Tin</label>
                            <input type="text" name="tin" class="form-control @error('tin') is-invalid @enderror" id="tin" value="{{ old('tin', $dataChemical->tin) }}">
                            @error('tin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="acid" class="form-label">Acid</label>
                            <input type="text" name="acid" class="form-control @error('acid') is-invalid @enderror" id="acid" value="{{ old('acid', $dataChemical->acid) }}">
                            @error('acid')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sulfur" class="form-label">Sulfur</label>
                            <input type="text" name="sulfur" class="form-control @error('sulfur') is-invalid @enderror" id="sulfur" value="{{ old('sulfur', $dataChemical->sulfur) }}">
                            @error('sulfur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="water" class="form-label">Water</label>
                            <input type="text" name="water" class="form-control @error('water') is-invalid @enderror" id="water" value="{{ old('water', $dataChemical->water) }}">
                            @error('water')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cloride" class="form-label">Chloride</label>
                            <input type="text" name="cloride" class="form-control @error('cloride') is-invalid @enderror" id="cloride" value="{{ old('cloride', $dataChemical->cloride) }}">
                            @error('cloride')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mono" class="form-label">Mono</label>
                            <input type="text" name="mono" class="form-control @error('mono') is-invalid @enderror" id="mono" value="{{ old('mono', $dataChemical->mono) }}">
                            @error('mono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="spec" class="form-label">Spec</label>
                            <input type="text" name="spec" class="form-control @error('spec') is-invalid @enderror" id="spec" value="{{ old('spec', $dataChemical->spec) }}">
                            @error('spec')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cla" class="form-label">CLA</label>
                            <input type="text" name="cla" class="form-control @error('cla') is-invalid @enderror" id="cla" value="{{ old('cla', $dataChemical->cla) }}">
                            @error('cla')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('datachemical.index') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
