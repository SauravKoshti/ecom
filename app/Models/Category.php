<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'image', 'parent_id', 'status'];

    protected static function booted(): void
    {
        static::creating(fn ($category) => $category->slug ??= Str::slug($category->name));
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
        return \Illuminate\Support\Facades\Storage::url('public/' . $this->image);
    }
}
