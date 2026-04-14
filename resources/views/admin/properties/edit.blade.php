@extends('admin.layouts.app')
@section('title', 'Edit Property')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Property <span style="font-size:14px;color:var(--text-muted);font-weight:500">#{{ $property->id }}</span></h1>
    <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<form action="{{ route('admin.properties.update', $property) }}" method="POST">
    @csrf
    @method('PUT')
    @include('admin.properties._form')
    <div class="mt-3 mb-4">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg"></i> Update Property
        </button>
    </div>
</form>
@endsection

@push('scripts')
@include('admin.properties._form_scripts')
@endpush
