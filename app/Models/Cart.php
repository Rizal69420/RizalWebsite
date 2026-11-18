<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Alias for cartItems to ensure compatibility.
     */
    public function items(): HasMany
    {
        return $this->cartItems();
    }

    public function getTotalAttribute(): float
    {
        return (float) $this->cartItems->sum(function ($item) {
            $price = $item->product ? $item->product->price : ($item->price ?? 0);
            return $price * $item->quantity;
        });
    }
}
