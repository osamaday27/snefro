<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    public const GENDERS = ['boys' => 'أولاد', 'girls' => 'بنات', 'unisex' => 'للجنسين'];

    public const COLORS = [
        'أسود' => '#111827', 'أبيض' => '#ffffff', 'أحمر' => '#ef4444', 'أزرق' => '#3b82f6',
        'سماوي' => '#38bdf8', 'أخضر' => '#22c55e', 'أصفر' => '#facc15', 'برتقالي' => '#f97316',
        'وردي' => '#f472b6', 'بنفسجي' => '#a855f7', 'رمادي' => '#9ca3af', 'بيج' => '#e7d3b0',
        'بني' => '#92400e', 'كحلي' => '#1e3a8a', 'فيروزي' => '#14b8a6', 'ذهبي' => '#d4af37',
    ];

    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'short_description', 'description',
        'price', 'sale_price', 'stock', 'age_range', 'gender', 'material',
        'features', 'care', 'sizes', 'colors', 'images', 'is_active', 'is_featured',
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'images' => 'array',
        'features' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
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

    public function getDiscountPercentAttribute(): int
    {
        return $this->on_sale ? (int) round((1 - $this->sale_price / $this->price) * 100) : 0;
    }

    public function getGenderLabelAttribute(): string
    {
        return self::GENDERS[$this->gender] ?? 'للجنسين';
    }

    public static function colorHex(string $name): string
    {
        return self::COLORS[trim($name)] ?? '#d1d5db';
    }

    public static function urlFor(?string $path): string
    {
        if (! $path) return 'https://placehold.co/600x750/fde68a/1f2a44?text=Snefro';
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
