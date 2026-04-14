<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Categories fetched successfully',
            'data' => $categories->items(),
            'meta' => [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
            ]
        ]);
    }

    public function show($id)
    {
        $category = Category::with('children')->find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Category fetched successfully',
            'data' => $category
        ]);
    }
}
