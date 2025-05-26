<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "category_id",
        "label",
        "description",
        "price",
        "quantity",
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function ratings(): HasMany {
        return $this->hasMany(Rating::class);
    }

    public function averageRating() {
        return $this->ratings()->avg('rating');
    }

    public function carts(): HasMany {
        return $this->hasMany(Cart::class);
    }
}
