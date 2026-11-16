<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('الرئيسية')]
class Home extends Component
{
    public function render()
    {
        return view('livewire.home', [
            'categories' => Category::withCount(['products' => fn ($q) => $q->active()])->get(),
            'featured' => Product::active()->with('category')->where('is_featured', true)->latest()->take(4)->get(),
            'latest' => Product::active()->with('category')->latest()->take(8)->get(),
        ]);
    }
}
