@extends('admin.layouts.app')
@section('title', 'New Product')

@section('content')
<div class="page-header">
    <h1 class="page-title">New Product</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.products._form')
    <div class="mt-3 mb-4">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg"></i> Create Product
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.getElementById('nameInput').addEventListener('input', function () {
        const slug = document.getElementById('slugInput');
        if (!slug.dataset.manual)
            slug.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    });
    document.getElementById('slugInput').addEventListener('input', function () { this.dataset.manual = '1'; });
</script>
@endpush
