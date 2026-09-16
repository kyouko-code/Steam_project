<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'discount_price',
        'cover_image',
        'publisher',
        'developer',
        'release_date',
        'featured',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'release_date' => 'date',
        'featured' => 'boolean',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getEffectivePriceAttribute()
    {
        return $this->discount_price ?: $this->price;
    }

    public function getIsDiscountedAttribute()
    {
        return $this->discount_price && $this->discount_price < $this->price;
    }

    public function getDiscountPercentAttribute()
    {
        if (!$this->is_discounted) {
            return 0;
        }
        return round((($this->price - $this->discount_price) / $this->price) * 100);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public static function booted()
    {
        static::creating(function ($game) {
            $game->slug = $game->slug ?? \Illuminate\Support\Str::slug($game->title);
        });
    }
}