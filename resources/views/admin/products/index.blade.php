@extends('admin.layouts.app')
@section('title', 'Products')

@section('content')
<div class="page-header">
    <h1 class="page-title">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> New Product
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
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Brand</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td style="color:var(--text-muted)">#{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" width="40" height="40"
                                 style="border-radius:8px;object-fit:cover;border:1px solid var(--border)">
                        @else
                            <div style="width:40px;height:40px;border-radius:8px;background:var(--bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--text-muted)">
                                <i class="bi bi-image"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600">{{ $product->name }}</div>
                        @if($product->variants_count > 0)
                            <div style="font-size:11px;color:var(--text-muted)">{{ $product->variants_count }} variant(s)</div>
                        @endif
                    </td>
                    <td><code style="background:var(--bg);padding:2px 7px;border-radius:5px;font-size:12px">{{ $product->sku ?? '—' }}</code></td>
                    <td>
                        <div style="font-weight:600">${{ number_format($product->price, 2) }}</div>
                        @if($product->compare_price)
                            <div style="font-size:11px;color:var(--text-muted);text-decoration:line-through">${{ number_format($product->compare_price, 2) }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">{{ $product->stock }}</span>
                    </td>
                    <td style="color:var(--text-muted)">{{ $product->brand?->name ?? '—' }}</td>
                    <td>
                        <span class="badge bg-{{ $product->active ? 'success' : 'secondary' }}">
                            {{ $product->active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                              class="d-inline" onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:48px;color:var(--text-muted)">
                        <i class="bi bi-box-seam" style="font-size:32px;display:block;margin-bottom:8px;opacity:.4"></i>
                        No products found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $products->links() }}</div>
@endsection
