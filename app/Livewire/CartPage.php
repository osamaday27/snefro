<?php

namespace App\Livewire;

use App\Services\Cart;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Cart')]
class CartPage extends Component
{
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
    }

    public function render()
    {
        $cart = app(Cart::class);

        return view('livewire.cart-page', [
            'items' => $cart->items(),
            'subtotal' => $cart->subtotal(),
            'shipping' => $cart->shipping(),
            'total' => $cart->total(),
        ]);
    }
}
