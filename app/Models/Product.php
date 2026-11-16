<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'sale_price',
        'stock', 'sizes', 'colors', 'images', 'is_active',
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
        'price' => 'float',
        'sale_price' => 'float',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function getFinalPriceAttribute(): float
    {
        return (float) ($this->sale_price ?: $this->price);
    }

    public function getOnSaleAttribute(): bool
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    public static function urlFor(?string $path): string
    {
        if (! $path) return 'https://placehold.co/600x750?text=Snefro';
        if (str_starts_with($path, 'http')) return $path;
        return Storage::url($path);
    }

    public function getImageUrlAttribute(): string
    {
        return self::urlFor($this->images[0] ?? null);
    }

    public function getGalleryAttribute(): array
    {
        $imgs = $this->images ?: [null];
        return array_map(fn ($i) => self::urlFor($i), $imgs);
    }
}
