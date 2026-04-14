<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'compare_price',
        'stock', 'sku', 'product_number', 'ean', 'image',
        'brand_id', 'active', 'parent_id',
    ];

    protected $casts = ['active' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(fn ($product) => $product->slug ??= Str::slug($product->name));
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function propertyOptions(): BelongsToMany
    {
        return $this->belongsToMany(PropertyOption::class, 'product_property_option');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Product::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(ProductMedia::class);
    }

    public function cover()
    {
        return $this->hasOne(ProductMedia::class)->where('is_cover', true);
    }

    public function variantOptions(): BelongsToMany
    {
        return $this->belongsToMany(PropertyOption::class, 'product_variant_options');
    }

    public function isVariant(): bool
    {
        return $this->parent_id !== null;
    }
}
