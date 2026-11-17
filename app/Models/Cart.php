<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    //
    use hasFactory;

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
    public function getTotalAttribute()
    {
    return $this->cartItems->sum(function ($item) {
        // We'll also address where price comes from below!
        return $item->product->price * $item->quantity; 
        });
    }
}
