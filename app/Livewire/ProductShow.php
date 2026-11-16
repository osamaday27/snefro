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
        $this->resetErrorBag();

        if ($this->product->stock < 1) {
            $this->addError('stock', 'عذراً، هذا المنتج غير متوفر حالياً.');
            return;
        }
        if (! empty($this->product->sizes) && ! $this->size) {
            $this->addError('size', 'من فضلك اختر المقاس.');
            return;
        }
        if (! empty($this->product->colors) && ! $this->color) {
            $this->addError('color', 'من فضلك اختر اللون.');
            return;
        }

        app(Cart::class)->add($this->product, $this->size, $this->color, $this->qty);
        $this->dispatch('cart-updated');
        $this->dispatch('toast', message: 'تمت إضافة المنتج إلى السلة 🛍️', type: 'success');
    }

    public function render()
    {
        $related = Product::active()->with('category')
            ->where('id', '!=', $this->product->id)
            ->where('category_id', $this->product->category_id)
            ->inRandomOrder()->take(4)->get();

        if ($related->count() < 4) {
            $related = $related->merge(
                Product::active()->with('category')->where('id', '!=', $this->product->id)
                    ->whereNotIn('id', $related->pluck('id'))->inRandomOrder()->take(4 - $related->count())->get()
            );
        }

        return view('livewire.product-show', ['related' => $related])->title($this->product->name);
    }
}
