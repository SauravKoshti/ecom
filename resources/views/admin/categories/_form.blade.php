{{-- _form.blade.php --}}
<div class="card" style="max-width:640px">
    <div class="card-header">Category Details</div>
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Name <span style="color:var(--danger)">*</span></label>
            <input type="text" name="name" id="nameInput"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $category->name ?? '') }}">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" id="slugInput"
                   class="form-control @error('slug') is-invalid @enderror"
                   value="{{ old('slug', $category->slug ?? '') }}"
                   placeholder="Auto-generated from name">
            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Parent Category</label>
            <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                <option value="">— None —</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}"
                        {{ old('parent_id', $category->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="3"
                class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description ?? '') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            @if(!empty($category->image ?? null))
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $category->image) }}" height="72"
                         style="border-radius:8px;border:1px solid var(--border);padding:4px">
                </div>
            @endif
            <input type="file" name="image" accept="image/*"
                   class="form-control @error('image') is-invalid @enderror">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror">
                <option value="1" {{ old('status', $category->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $category->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg"></i>
            {{ isset($category) && $category->exists ? 'Update Category' : 'Create Category' }}
        </button>
    </div>
</div>
