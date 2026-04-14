<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products'   => Product::whereNull('parent_id')->count(),
            'categories' => Category::count(),
            'brands'     => Brand::count(),
            'properties' => Property::count(),
            'low_stock'  => Product::whereNull('parent_id')->where('stock', '<=', 5)->count(),
            'inactive'   => Product::whereNull('parent_id')->where('active', false)->count(),
        ];

        $recentProducts = Product::with('brand')
            ->whereNull('parent_id')
            ->latest()
            ->take(8)
            ->get();

        $topBrands = Brand::withCount('products')
            ->orderByDesc('products_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'topBrands'));
    }
}
