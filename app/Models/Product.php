<?php

namespace App\Models;

use App\Models\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use Translatable;

    public const GENDERS = ['boys', 'girls', 'unisex'];

    public const COLORS = [
        'black'     => ['ar' => 'أسود',    'en' => 'Black',     'hex' => '#111111'],
        'white'     => ['ar' => 'أبيض',    'en' => 'White',     'hex' => '#FFFFFF'],
        'gray'      => ['ar' => 'رمادي',   'en' => 'Gray',      'hex' => '#9CA3AF'],
        'pink'      => ['ar' => 'وردي',    'en' => 'Pink',      'hex' => '#F6B3C8'],
        'red'       => ['ar' => 'أحمر',    'en' => 'Red',       'hex' => '#EF4444'],
        'blue'      => ['ar' => 'أزرق',    'en' => 'Blue',      'hex' => '#3B82F6'],
        'sky'       => ['ar' => 'سماوي',   'en' => 'Sky blue',  'hex' => '#7DD3FC'],
        'navy'      => ['ar' => 'كحلي',    'en' => 'Navy',      'hex' => '#1E3A8A'],
        'green'     => ['ar' => 'أخضر',    'en' => 'Green',     'hex' => '#22C55E'],
        'yellow'    => ['ar' => 'أصفر',    'en' => 'Yellow',    'hex' => '#FACC15'],
        'orange'    => ['ar' => 'برتقالي', 'en' => 'Orange',    'hex' => '#F97316'],
        'purple'    => ['ar' => 'بنفسجي',  'en' => 'Purple',    'hex' => '#A855F7'],
        'beige'     => ['ar' => 'بيج',     'en' => 'Beige',     'hex' => '#E7D3B0'],
        'brown'     => ['ar' => 'بني',     'en' => 'Brown',     'hex' => '#92400E'],
        'turquoise' => ['ar' => 'فيروزي',  'en' => 'Turquoise', 'hex' => '#14B8A6'],
        'gold'      => ['ar' => 'ذهبي',    'en' => 'Gold',      'hex' => '#D4AF37'],
    ];

    protected $fillable = [
        'category_id', 'name', 'name_en', 'slug', 'sku',
        'short_description', 'short_description_en', 'description', 'description_en',
        'price', 'sale_price', 'stock', 'age_range', 'gender',
        'material', 'material_en', 'features', 'features_en', 'care', 'care_en',
        'sizes', 'colors', 'images', 'is_active', 'is_featured',
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'images' => 'array',
        'features' => 'array',
        'features_en' => 'array',
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
        return match ($this->gender) {
            'boys' => __('Boys'),
            'girls' => __('Girls'),
            default => __('Unisex'),
        };
    }

    public static function colorLabel(?string $slug): string
    {
        if (! $slug) return '';
        return self::COLORS[$slug][app()->getLocale() === 'en' ? 'en' : 'ar'] ?? $slug;
    }

    public static function colorHex(?string $slug): string
    {
        return self::COLORS[$slug]['hex'] ?? '#D1D5DB';
    }

    /** يحوّل 2-3Y / 0-12M / 3+Y إلى نص حسب اللغة */
    public static function unit(?string $v): string
    {
        if (! $v) return '';
        $ar = app()->getLocale() !== 'en';

        return preg_replace(
            ['/Y$/', '/M$/'],
            $ar ? [' سنوات', ' شهور'] : [' yrs', ' mo'],
            $v
        );
    }

    public static function urlFor(?string $path): string
    {
        if (! $path) return 'https://placehold.co/600x750/F6F6F6/111111?text=Snefro';
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
