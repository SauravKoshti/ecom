@extends('admin.layouts.app')
@section('title', 'Properties')

@section('content')
<div class="page-header">
    <h1 class="page-title">Properties</h1>
    <a href="{{ route('admin.properties.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> New Property
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Options</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($properties as $property)
                <tr>
                    <td style="color:var(--text-muted)">#{{ $property->id }}</td>
                    <td style="font-weight:600">{{ $property->name }}</td>
                    <td>
                        <span class="badge bg-secondary">{{ ucfirst($property->type) }}</span>
                    </td>
                    <td>
                        <span style="font-size:12px;background:var(--bg);border:1px solid var(--border);padding:3px 10px;border-radius:20px;color:var(--text-muted)">
                            {{ $property->options_count }} option(s)
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.properties.edit', $property) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.properties.destroy', $property) }}" method="POST"
                              class="d-inline" onsubmit="return confirm('Delete this property and all its options?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:48px;color:var(--text-muted)">
                        <i class="bi bi-sliders" style="font-size:32px;display:block;margin-bottom:8px;opacity:.4"></i>
                        No properties found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $properties->links() }}</div>
@endsection
