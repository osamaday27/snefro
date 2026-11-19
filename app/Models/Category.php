<?php

namespace App\Models;

use App\Models\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use Translatable;

    protected $fillable = ['name', 'name_en', 'slug', 'image'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) return 'https://placehold.co/600x750/F6F6F6/111111?text='.urlencode($this->name_en ?: 'Snefro');
        return str_starts_with($this->image, 'http') ? $this->image : Storage::url($this->image);
    }
}
