<?php

namespace App\Models;

use App\Models\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSlide extends Model
{
    use Translatable;

    protected $fillable = [
        'image', 'tag', 'tag_en', 'title', 'title_en', 'text', 'text_en',
        'button_text', 'button_text_en', 'button_url', 'sort_order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function getImageUrlAttribute(): string
    {
        if (str_starts_with($this->image, 'http')) return $this->image;
        return Storage::url($this->image);
    }
}
