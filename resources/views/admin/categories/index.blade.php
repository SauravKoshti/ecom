@extends('admin.layouts.app')
@section('title', 'Categories')

@section('content')
<div class="page-header">
    <h1 class="page-title">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> New Category
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td style="color:var(--text-muted)">#{{ $category->id }}</td>
                    <td>
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" width="40" height="40"
                                 style="border-radius:8px;object-fit:cover;border:1px solid var(--border)">
                        @else
                            <div style="width:40px;height:40px;border-radius:8px;background:var(--bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--text-muted)">
                                <i class="bi bi-image"></i>
                            </div>
                        @endif
                    </td>
                    <td style="font-weight:600">{{ $category->name }}</td>
                    <td style="color:var(--text-muted)">{{ $category->parent?->name ?? '—' }}</td>
                    <td>
                        <span class="badge bg-{{ $category->status ? 'success' : 'secondary' }}">
                            {{ $category->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                              class="d-inline" onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:48px;color:var(--text-muted)">
                        <i class="bi bi-diagram-3" style="font-size:32px;display:block;margin-bottom:8px;opacity:.4"></i>
                        No categories found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $categories->links() }}</div>
@endsection
