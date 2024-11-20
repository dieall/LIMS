    @extends('layouts.app')

@section('contents')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Detail Data MecL</h6>
    </div>

    <div class="card-body">

            <div class="mb-3">
                <label for="nama_mecl" class="form-label">Nama MecL</label>
                <input type="text" name="nama_mecl" class="form-control" id="nama_mecl" value="{{ $mecl->nama_mecl }}" required readonly>
            </div>

      
    </div>
</div>

@endsection
