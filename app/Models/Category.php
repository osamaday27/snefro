<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) return 'https://placehold.co/600x600/fde68a/1f2a44?text='.urlencode($this->name);
        return str_starts_with($this->image, 'http') ? $this->image : Storage::url($this->image);
    }
}
