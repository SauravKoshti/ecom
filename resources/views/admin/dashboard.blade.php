@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- ── STAT CARDS ── --}}
<div class="row g-3 mb-4">

    <div class="col-sm-6 col-xl-4">
        <div class="stat-card indigo">
            <div class="stat-top">
                <div class="stat-icon indigo"><i class="bi bi-box-seam"></i></div>
                <span class="stat-trend up"><i class="bi bi-arrow-up"></i> Active</span>
            </div>
            <div class="stat-val">{{ $stats['products'] }}</div>
            <div class="stat-label">Total Products</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="stat-card emerald">
            <div class="stat-top">
                <div class="stat-icon emerald"><i class="bi bi-diagram-3"></i></div>
                <span class="stat-trend neu">Catalogue</span>
            </div>
            <div class="stat-val">{{ $stats['categories'] }}</div>
            <div class="stat-label">Categories</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="stat-card amber">
            <div class="stat-top">
                <div class="stat-icon amber"><i class="bi bi-award"></i></div>
                <span class="stat-trend neu">Brands</span>
            </div>
            <div class="stat-val">{{ $stats['brands'] }}</div>
            <div class="stat-label">Total Brands</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="stat-card violet">
            <div class="stat-top">
                <div class="stat-icon violet"><i class="bi bi-sliders2"></i></div>
                <span class="stat-trend neu">Config</span>
            </div>
            <div class="stat-val">{{ $stats['properties'] }}</div>
            <div class="stat-label">Properties</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="stat-card rose">
            <div class="stat-top">
                <div class="stat-icon rose"><i class="bi bi-exclamation-triangle"></i></div>
                <span class="stat-trend down">Low</span>
            </div>
            <div class="stat-val">{{ $stats['low_stock'] }}</div>
            <div class="stat-label">Low Stock (≤ 5)</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="stat-card sky">
            <div class="stat-top">
                <div class="stat-icon sky"><i class="bi bi-toggle-off"></i></div>
                <span class="stat-trend down">Inactive</span>
            </div>
            <div class="stat-val">{{ $stats['inactive'] }}</div>
            <div class="stat-label">Inactive Products</div>
        </div>
    </div>

</div>

{{-- ── BOTTOM ROW ── --}}
<div class="row g-3">

    {{-- Recent Products --}}
    <div class="col-xl-8">
        <div class="card h-100">
            <div class="card-header">
                <span><i class="bi bi-clock-history me-2" style="color:var(--indigo)"></i>Recent Products</span>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProducts as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" width="34" height="34"
                                             style="border-radius:8px;object-fit:cover;border:1px solid var(--border);flex-shrink:0">
                                    @else
                                        <div style="width:34px;height:34px;border-radius:8px;background:#f1f5f9;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                            <i class="bi bi-image" style="color:var(--muted);font-size:13px"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight:600;font-size:13px">{{ Str::limit($product->name, 28) }}</div>
                                        <div style="font-size:11px;color:var(--muted)">{{ $product->sku ?? 'No SKU' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:var(--muted)">{{ $product->brand?->name ?? '—' }}</td>
                            <td style="font-weight:600">${{ number_format($product->price, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $product->stock > 5 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $product->active ? 'success' : 'secondary' }}">
                                    {{ $product->active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="bi bi-box-seam"></i>
                                    <p>No products yet.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top Brands --}}
    <div class="col-xl-4">
        <div class="card h-100">
            <div class="card-header">
                <span><i class="bi bi-bar-chart me-2" style="color:var(--indigo)"></i>Top Brands</span>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @php $maxCount = $topBrands->max('products_count') ?: 1; @endphp
                @forelse($topBrands as $brand)
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <div class="d-flex align-items-center gap-2">
                            @if($brand->logo)
                                <img src="{{ asset('storage/' . $brand->logo) }}" width="22" height="22"
                                     style="border-radius:5px;object-fit:contain;border:1px solid var(--border)">
                            @else
                                <div style="width:22px;height:22px;border-radius:5px;background:#eef2ff;display:flex;align-items:center;justify-content:center">
                                    <i class="bi bi-award" style="font-size:11px;color:var(--indigo)"></i>
                                </div>
                            @endif
                            <span style="font-size:13px;font-weight:600">{{ $brand->name }}</span>
                        </div>
                        <span style="font-size:12px;color:var(--muted);font-weight:500">{{ $brand->products_count }}</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar"
                             style="width:{{ round(($brand->products_count / $maxCount) * 100) }}%;background:linear-gradient(90deg,#6366f1,#818cf8)">
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="bi bi-award"></i>
                    <p>No brands yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
