{{-- _form.blade.php --}}
<div class="card" style="max-width:560px">
    <div class="card-header">Brand Details</div>
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Name <span style="color:var(--danger)">*</span></label>
            <input type="text" name="name" id="nameInput"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $brand->name ?? '') }}">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" id="slugInput"
                   class="form-control @error('slug') is-invalid @enderror"
                   value="{{ old('slug', $brand->slug ?? '') }}"
                   placeholder="Auto-generated from name">
            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Logo</label>
            @if(!empty($brand->logo ?? null))
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $brand->logo) }}" height="56"
                         style="border-radius:8px;border:1px solid var(--border);padding:6px;background:#fff">
                </div>
            @endif
            <input type="file" name="logo" accept="image/*"
                   class="form-control @error('logo') is-invalid @enderror">
            @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Status</label>
            <select name="active" class="form-select @error('active') is-invalid @enderror">
                <option value="1" {{ old('active', $brand->active ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('active', $brand->active ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('active') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg"></i>
            {{ isset($brand) ? 'Update Brand' : 'Create Brand' }}
        </button>
    </div>
</div>
