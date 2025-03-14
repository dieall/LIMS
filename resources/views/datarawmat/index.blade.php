@extends('layouts.app')

@section('contents')
<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Rawmat</li>
        </ol>
        <hr>
    </nav>
</div>

@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
    {{ Session::get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Data Rawmat</h6>
        <div class="d-flex gap-3 align-items-center">
            <!-- Dropdown Filter -->
            <div style="width: 250px;">
                <label for="rawmatFilter" class="sr-only">Filter by Category</label>
                <select class="form-select form-select-sm" id="rawmatFilter" onchange="filterData()">
                    <option value="all" {{ request('filter') === 'all' ? 'selected' : '' }}>Show All</option>
                    <option value="Supplier A" {{ request('filter') === 'Supplier A' ? 'selected' : '' }}>Supplier A</option>
                    <option value="Supplier B" {{ request('filter') === 'Supplier B' ? 'selected' : '' }}>Supplier B</option>
                </select>
            </div>
            <!-- Button Tambah -->
            <a href="{{ route('datarawmat.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah
            </a>
            <a href="" class="btn btn-success btn-sm">
                <i class="fas fa-file-export"></i> Export to Excel
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light text-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama Rawmat</th>
                        <th>Supplier</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($datarawmat->count() > 0)
                        @foreach($datarawmat as $index => $rs)
                            <tr>
                                <td class="text-center align-middle">{{ $index + 1 + (($datarawmat->currentPage() - 1) * $datarawmat->perPage()) }}</td>
                                <td class="align-middle">{{ $rs->nama }}</td>
                                <td class="align-middle">{{ $rs->supplier }}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('datarawmat.show', $rs->id_rawmat) }}" class="dropdown-item"><i class="fas fa-eye"></i> Detail</a></li>
                                            <li><a href="{{ route('datarawmat.edit', $rs->id_rawmat) }}" class="dropdown-item"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                            <li>
                                                <form action="{{ route('datarawmat.destroy', $rs->id_rawmat) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?')" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">Data tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            {{ $datarawmat->appends(request()->except('page'))->links() }}
        </div>
    </div>
</div>

<script>
    function filterData() {
        const filter = document.getElementById('rawmatFilter').value;
        const url = new URL(window.location.href);
        url.searchParams.set('filter', filter);
        url.searchParams.set('page', 1); // Reset ke halaman pertama saat filter diubah
        window.location.href = url.href;
    }
</script>
@endsection
