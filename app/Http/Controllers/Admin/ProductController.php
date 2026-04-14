<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('brand')
            ->withCount('variants')
            ->whereNull('parent_id')
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $product    = new Product(['active' => 1]);
        $product->setRelation('propertyOptions', collect());
        $product->setRelation('categories', collect());

        return view('admin.products.create', [
            'product'    => $product,
            'categories' => Category::orderBy('name')->get(),
            'brands'     => Brand::orderBy('name')->get(),
            'properties' => Property::with('options')->get(),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->safe()->except(['property_options', 'categories', 'image']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);
        $product->propertyOptions()->sync($request->validated()['property_options'] ?? []);
        $product->categories()->sync($request->validated()['categories'] ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $product->load('propertyOptions', 'categories');

        return view('admin.products.edit', [
            'product'    => $product,
            'categories' => Category::orderBy('name')->get(),
            'brands'     => Brand::orderBy('name')->get(),
            'properties' => Property::with('options')->get(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->safe()->except(['property_options', 'categories', 'image']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        $product->propertyOptions()->sync($request->validated()['property_options'] ?? []);
        $product->categories()->sync($request->validated()['categories'] ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}
