<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PropertyOption extends Model
{
    use HasFactory;

    protected $fillable = ['property_id', 'value', 'color_hex'];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_property_option');
    }
}
