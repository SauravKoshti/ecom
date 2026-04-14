<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['categories', 'brand', 'media', 'cover']);

        // Filtering
        if ($request->has('category_id') && $request->category_id) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        if ($request->has('brand_id') && $request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting
        $sort = $request->get('sort', 'created_at_desc');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'created_at_desc':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $products = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Products fetched successfully',
            'data' => $products->items(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ]);
    }

    public function show($id)
    {
        $product = Product::with(['categories', 'brand', 'media', 'cover', 'propertyOptions.property'])->find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product fetched successfully',
            'data' => $product
        ]);
    }

    public function related($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $related = Product::with(['categories', 'brand', 'cover'])
            ->whereHas('categories', function ($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Related products fetched successfully',
            'data' => $related
        ]);
    }
}
