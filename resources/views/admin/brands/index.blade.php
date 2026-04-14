@extends('admin.layouts.app')
@section('title', 'Brands')

@section('content')
<div class="page-header">
    <h1 class="page-title">Brands</h1>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> New Brand
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $brand)
                <tr>
                    <td style="color:var(--text-muted)">#{{ $brand->id }}</td>
                    <td>
                        @if($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" width="40" height="40"
                                 style="border-radius:8px;object-fit:contain;border:1px solid var(--border);padding:4px;background:#fff">
                        @else
                            <div style="width:40px;height:40px;border-radius:8px;background:var(--bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--text-muted)">
                                <i class="bi bi-award"></i>
                            </div>
                        @endif
                    </td>
                    <td style="font-weight:600">{{ $brand->name }}</td>
                    <td><code style="background:var(--bg);padding:2px 7px;border-radius:5px;font-size:12px">{{ $brand->slug }}</code></td>
                    <td>
                        <span class="badge bg-{{ $brand->active ? 'success' : 'secondary' }}">
                            {{ $brand->active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST"
                              class="d-inline" onsubmit="return confirm('Delete this brand?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:48px;color:var(--text-muted)">
                        <i class="bi bi-award" style="font-size:32px;display:block;margin-bottom:8px;opacity:.4"></i>
                        No brands found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $brands->links() }}</div>
@endsection
