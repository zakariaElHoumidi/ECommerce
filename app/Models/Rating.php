<?php

namespace App\Models;

use App\Observers\RatingObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(RatingObserver::class)]
class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "product_id",
        "rating",
        "review",
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
