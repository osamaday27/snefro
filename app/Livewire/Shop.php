<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('المتجر')]
class Shop extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $category = '';

    #[Url(except: '')]
    public string $gender = '';

    #[Url(except: 'latest')]
    public string $sort = 'latest';

    public function updating($name): void
    {
        if (in_array($name, ['search', 'category', 'gender', 'sort'])) $this->resetPage();
    }

    public function setCategory(string $slug): void
    {
        $this->category = $slug;
    }

    public function setGender(string $g): void
    {
        $this->gender = $g;
    }

    public function resetFilters(): void
    {
        $this->reset('search', 'category', 'gender', 'sort');
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::active()->with('category')
            ->when($this->search, fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('short_description', 'like', '%'.$this->search.'%')))
            ->when($this->category, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $this->category)))
            ->when($this->gender, fn ($q) => $q->whereIn('gender', [$this->gender, 'unisex']));

        match ($this->sort) {
            'price_asc' => $query->orderByRaw('COALESCE(sale_price, price) asc'),
            'price_desc' => $query->orderByRaw('COALESCE(sale_price, price) desc'),
            default => $query->latest(),
        };

        return view('livewire.shop', [
            'products' => $query->paginate(12),
            'categories' => Category::orderBy('id')->get(),
        ]);
    }
}
