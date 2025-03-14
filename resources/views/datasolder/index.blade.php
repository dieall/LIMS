@extends('layouts.app')

@section('contents')
<style>
    .alert {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        font-weight: bold;
        transition: opacity 1s ease-out;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .pagination-container {
        text-align: center;
        margin-top: 20px;
    }

    .pagination-link {
        display: inline-block;
        padding: 8px 12px;
        margin: 0 5px;
        text-decoration: none;
        color: #007bff;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .pagination-link:hover {
        background-color: #f1f1f1;
    }

    .pagination-link.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination-link.disabled {
        color: #ccc;
        pointer-events: none;
    }
</style>

<div class="panel-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Solder</li>
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
        <h6 class="m-0 font-weight-bold">Data Solder</h6>
        <div class="d-flex gap-3 align-items-center">
            <!-- Dropdown Filter -->
            <div style="width: 250px;">
                <label for="solderFilter" class="sr-only">Filter by Category</label>
                <select class="form-select form-select-sm" id="solderFilter">
                    <option value="all">Show All</option>
                    <option value="Sn/Cu Series">Sn/Cu Series</option>
                    <option value="Sn/Ag/Cu Series">Sn/Ag/Cu Series</option>
                    <option value="Sn/Ag Series">Sn/Ag Series</option>
                    <option value="Tin-Lead Solder Bar">Tin-Lead Solder Bar</option>
                </select>
            </div>
            <!-- Button Tambah -->
            <a href="{{ route('datasolder.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light text-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Name Category</th>
                        <th>Type Solder</th>
                        <th>Specification</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($datasolder->count() > 0)
                        @foreach($datasolder as $index => $rs)
                            <tr class="datasolder-row" data-id="{{ $rs->id }}">
                                <td class="text-center align-middle">{{ $index + 1 + (($datasolder->currentPage() - 1) * $datasolder->perPage()) }}</td>
                                <td class="align-middle">{{ $rs->nama_kategori }}</td>
                                <td class="align-middle">{{ $rs->tipe_solder }}</td>
                                <td class="align-middle">{{ $rs->spesification }}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('datasolder.show', $rs->id) }}" class="dropdown-item"><i class="fas fa-eye"></i> Detail</a></li>
                                            <li><a href="{{ route('datasolder.edit', $rs->id) }}" class="dropdown-item"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                            <li>
                                                <form action="{{ route('datasolder.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?')" style="display: inline;">
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
                            <td colspan="5" class="text-center">Data tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination -->
        <div class="pagination-container">
            <a href="{{ $datasolder->previousPageUrl() }}" class="pagination-link {{ $datasolder->onFirstPage() ? 'disabled' : '' }}">&laquo;</a>
            @for($i = 1; $i <= $datasolder->lastPage(); $i++)
                <a href="{{ $datasolder->url($i) }}" class="pagination-link {{ $datasolder->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
            @endfor
            <a href="{{ $datasolder->nextPageUrl() }}" class="pagination-link {{ $datasolder->currentPage() == $datasolder->lastPage() ? 'disabled' : '' }}">&raquo;</a>
        </div>
    </div>
</div>

<script>
    document.getElementById('solderFilter').addEventListener('change', function() {
        const filterValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
            const category = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            row.style.display = filterValue === 'all' || category.includes(filterValue) ? '' : 'none';
        });
    });
</script>
@endsection
