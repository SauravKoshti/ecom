<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(15);

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create', ['brand' => new Brand()]);
    }

    public function store(StoreBrandRequest $request)
    {
        $data = $request->safe()->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }

        Brand::create($data);

        return redirect()->route('admin.brands.index')->with('success', 'Brand created.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $data = $request->safe()->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $brand->update($data);

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted.');
    }
}
