@extends('layouts.app')

@section('contents')

<div class="panel-body">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light rounded px-3 py-1">
            <li class="breadcrumb-item">
                <a href="index.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Data Pegawai</li>
        </ol>
        <hr>
    </nav>
</div>

<!-- Success Alert -->
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Main Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold">Data Pegawai</h6>
        <a href="{{ route('user.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light text-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($user->count() > 0)
                        @foreach($user as $rs)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $rs->name }}</td>
                                <td class="align-middle">{{ $rs->level }}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <!-- Detail -->
                                            <li>
                                                <a href="{{ route('user.show', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </li>
                                            <!-- Edit -->
                                            <li>
                                                <a href="{{ route('user.edit', $rs->id) }}" class="dropdown-item">
                                                    <i class="fas fa-pencil-alt"></i> Edit
                                                </a>
                                            </li>
                                            <!-- Delete -->
                                            <li>
                                                <form action="{{ route('user.destroy', $rs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this data?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
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
    </div>
</div>

@endsection
