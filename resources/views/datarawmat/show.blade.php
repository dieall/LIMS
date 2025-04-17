@extends('layouts.app')

@section('contents')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Raw Material Details</h4>
            <div>
                <a href="{{ route('datarawmat') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('datarawmat.edit', $dataRawmat->id) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
        <div class="card-body">
            @foreach($fieldGroups as $groupName => $fields)
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5>{{ $groupName }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($fields as $field)
                                @if(!is_null($dataRawmat->$field))
                                <div class="col-md-4 mb-3">
                                    <p><strong>{{ ucwords(str_replace('_', ' ', $field)) }}: </strong>{{ $dataRawmat->$field }}</p>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h5>System Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <p><strong>Created At: </strong>{{ $dataRawmat->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p><strong>Updated At: </strong>{{ $dataRawmat->updated_at ? $dataRawmat->updated_at->format('Y-m-d H:i:s') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
