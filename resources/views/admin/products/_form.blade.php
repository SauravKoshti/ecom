{{-- _form.blade.php — included by create.blade.php and edit.blade.php --}}

<div class="row g-4">

    {{-- LEFT COLUMN --}}
    <div class="col-lg-8">

        {{-- Basic Info --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold">Basic Information</div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="nameInput"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $product->name ?? '') }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" id="slugInput"
                           class="form-control @error('slug') is-invalid @enderror"
                           value="{{ old('slug', $product->slug ?? '') }}"
                           placeholder="Auto-generated from name">
                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

            </div>
        </div>

        {{-- Pricing & Stock --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold">Pricing & Stock</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-4">
                        <label class="form-label">Price <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="price" step="0.01" min="0"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $product->price ?? '') }}">
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">Compare Price</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="compare_price" step="0.01" min="0"
                                   class="form-control @error('compare_price') is-invalid @enderror"
                                   value="{{ old('compare_price', $product->compare_price ?? '') }}">
                            @error('compare_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">Stock <span class="text-danger">*</span></label>
                        <input type="number" name="stock" min="0"
                               class="form-control @error('stock') is-invalid @enderror"
                               value="{{ old('stock', $product->stock ?? 0) }}">
                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Identifiers --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold">Identifiers</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-4">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku"
                               class="form-control @error('sku') is-invalid @enderror"
                               value="{{ old('sku', $product->sku ?? '') }}">
                        @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">Product Number</label>
                        <input type="text" name="product_number"
                               class="form-control @error('product_number') is-invalid @enderror"
                               value="{{ old('product_number', $product->product_number ?? '') }}">
                        @error('product_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">EAN</label>
                        <input type="text" name="ean"
                               class="form-control @error('ean') is-invalid @enderror"
                               value="{{ old('ean', $product->ean ?? '') }}">
                        @error('ean') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Properties --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold">Properties</div>
            <div class="card-body">
                @foreach($properties as $property)
                <div class="mb-3">
                    <label class="form-label">{{ $property->name }}</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($property->options as $option)
                            @php
                                $selected = in_array($option->id,
                                    old('property_options', $product->propertyOptions?->pluck('id')->toArray() ?? [])
                                );
                            @endphp
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox"
                                       name="property_options[]"
                                       id="opt_{{ $option->id }}"
                                       value="{{ $option->id }}"
                                       {{ $selected ? 'checked' : '' }}>
                                <label class="form-check-label d-flex align-items-center gap-1"
                                       for="opt_{{ $option->id }}">
                                    @if($option->color_hex)
                                        <span class="rounded-circle border d-inline-block"
                                              style="width:14px;height:14px;background:{{ $option->color_hex }}"></span>
                                    @endif
                                    {{ $option->value }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- RIGHT COLUMN --}}
    <div class="col-lg-4">

        {{-- Status --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold">Status</div>
            <div class="card-body">
                <select name="active" class="form-select @error('active') is-invalid @enderror">
                    <option value="1" {{ old('active', $product->active ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('active', $product->active ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('active') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Brand --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold">Brand</div>
            <div class="card-body">
                <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                    <option value="">— None —</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Categories --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold">Categories</div>
            <div class="card-body" style="max-height:220px;overflow-y:auto">
                @foreach($categories as $category)
                    @php
                        $checked = in_array($category->id,
                            old('categories', $product->categories?->pluck('id')->toArray() ?? [])
                        );
                    @endphp
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               name="categories[]"
                               id="cat_{{ $category->id }}"
                               value="{{ $category->id }}"
                               {{ $checked ? 'checked' : '' }}>
                        <label class="form-check-label" for="cat_{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Cover Image --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold">Cover Image</div>
            <div class="card-body">
                @if(!empty($product->image))
                    <img src="{{ asset('storage/' . $product->image) }}"
                         class="img-fluid rounded mb-2" alt="cover">
                @endif
                <input type="file" name="image" accept="image/*"
                       class="form-control @error('image') is-invalid @enderror">
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

    </div>
</div>
