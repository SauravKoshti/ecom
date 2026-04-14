@extends('admin.layouts.app')
@section('title', 'Edit Category')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Category <span style="font-size:14px;color:var(--text-muted);font-weight:500">#{{ $category->id }}</span></h1>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.categories._form')
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
