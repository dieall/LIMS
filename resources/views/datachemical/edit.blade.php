@extends('layouts.app')

@section('contents')
    <div class="container">
        <h2>Edit Data Chemical</h2>

        <form action="{{ route('datachemical.update', $dataChemical->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                @foreach($fieldsWithData as $field)
                    <label for="{{ $field }}">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                    <input type="text" name="{{ $field }}" class="form-control" id="{{ $field }}" 
                        value="{{ old($field, $dataChemical->{$field}) }}" {{ $field == 'batch' || $field == 'desc' || $field == 'orang' || $field == 'status' ? 'required' : '' }}>

                    @error($field)
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
