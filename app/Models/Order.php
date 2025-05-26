<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }

}
