<?php

namespace App\Livewire;

use App\Livewire\Concerns\HasLocale;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Home extends Component
{
    use HasLocale;

    public function render()
    {
        return view('livewire.home', [
            'heroSlides' => HeroSlide::active()->orderBy('sort_order')->orderBy('id')->get(),
            'categories' => Category::withCount(['products' => fn ($q) => $q->active()])->get(),
            'featured' => Product::active()->with('category')->where('is_featured', true)->latest()->take(4)->get(),
            'latest' => Product::active()->with('category')->latest()->take(8)->get(),
        ])->title(__('Home'));
    }
}
