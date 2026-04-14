<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePropertyRequest;
use App\Http\Requests\Admin\UpdatePropertyRequest;
use App\Models\Property;
use App\Models\PropertyOption;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::withCount('options')->latest()->paginate(15);

        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('admin.properties.create');
    }

    public function store(StorePropertyRequest $request)
    {
        $property = Property::create($request->safe()->only(['name', 'type']));

        foreach ($request->validated()['options'] ?? [] as $option) {
            $property->options()->create($option);
        }

        return redirect()->route('admin.properties.index')->with('success', 'Property created.');
    }

    public function edit(Property $property)
    {
        $property->load('options');

        return view('admin.properties.edit', compact('property'));
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $property->update($request->safe()->only(['name', 'type']));

        $keepIds = [];

        foreach ($request->validated()['options'] ?? [] as $option) {
            if (!empty($option['id'])) {
                PropertyOption::find($option['id'])->update($option);
                $keepIds[] = $option['id'];
            } else {
                $keepIds[] = $property->options()->create($option)->id;
            }
        }

        $property->options()->whereNotIn('id', $keepIds)->delete();

        return redirect()->route('admin.properties.index')->with('success', 'Property updated.');
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('admin.properties.index')->with('success', 'Property deleted.');
    }
}
