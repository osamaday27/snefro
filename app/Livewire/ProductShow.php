<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\Cart;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ProductShow extends Component
{
    public Product $product;
    public ?string $size = null;
    public ?string $color = null;
    public int $qty = 1;
    public int $activeImage = 0;
    public bool $added = false;

    public function mount(Product $product): void
    {
        abort_unless($product->is_active, 404);
        $this->product = $product;
    }

    public function increment(): void
    {
        if ($this->qty < max($this->product->stock, 1)) $this->qty++;
    }

    public function decrement(): void
    {
        if ($this->qty > 1) $this->qty--;
    }

    public function addToCart(): void
    {
        $this->added = false;

        if ($this->product->stock < 1) {
            $this->addError('stock', 'This product is out of stock.');
            return;
        }
        if (! empty($this->product->sizes) && ! $this->size) {
            $this->addError('size', 'Please choose a size.');
            return;
        }
        if (! empty($this->product->colors) && ! $this->color) {
            $this->addError('color', 'Please choose a color.');
            return;
        }

        app(Cart::class)->add($this->product, $this->size, $this->color, $this->qty);
        $this->dispatch('cart-updated');
        $this->resetErrorBag();
        $this->added = true;
    }

    public function render()
    {
        return view('livewire.product-show')->title($this->product->name);
    }
}
