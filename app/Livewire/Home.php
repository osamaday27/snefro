<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Home')]
class Home extends Component
{
    public function render()
    {
        return view('livewire.home', [
            'products' => Product::active()->latest()->take(8)->get(),
            'categories' => Category::withCount('products')->get(),
        ]);
    }
}
