<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'airport',
        'is_featured',
        'is_limited',
        'is_new',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_limited' => 'boolean',
        'is_new' => 'boolean',
    ];

    /**
     * 画像URLを取得
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        $disk = config('filesystems.images', 'public');
        return Storage::disk($disk)->url($this->image);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }
}
