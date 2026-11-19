<?php

namespace App\Livewire;

use App\Livewire\Concerns\HasLocale;
use App\Services\Cart;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class CartPage extends Component
{
    use HasLocale;

    public function increment(string $key, int $current): void
    {
        app(Cart::class)->setQty($key, $current + 1);
        $this->dispatch('cart-updated');
    }

    public function decrement(string $key, int $current): void
    {
        app(Cart::class)->setQty($key, $current - 1);
        $this->dispatch('cart-updated');
    }

    public function remove(string $key): void
    {
        app(Cart::class)->remove($key);
        $this->dispatch('cart-updated');
        $this->dispatch('toast', message: __('Item removed from cart'), type: 'info');
    }

    public function render()
    {
        $cart = app(Cart::class);

        return view('livewire.cart-page', [
            'items' => $cart->items(),
            'subtotal' => $cart->subtotal(),
            'shipping' => $cart->shipping(),
            'total' => $cart->total(),
            'freeOver' => (float) config('snefro.free_shipping_over'),
        ])->title(__('Shopping cart'));
    }
}
