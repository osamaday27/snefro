<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use App\Services\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Checkout')]
class Checkout extends Component
{
    public string $customer_name = '';
    public string $phone = '';
    public string $email = '';
    public string $address = '';
    public string $city = '';
    public string $notes = '';

    protected function rules(): array
    {
        return [
            'customer_name' => 'required|string|min:3|max:100',
            'phone' => ['required', 'regex:/^[0-9+\s-]{8,15}$/'],
            'email' => 'nullable|email|max:150',
            'address' => 'required|string|min:5|max:255',
            'city' => 'required|string|max:100',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function mount()
    {
        if (app(Cart::class)->items()->isEmpty()) {
            return redirect()->route('shop');
        }
    }

    public function placeOrder()
    {
        $data = $this->validate();
        $cart = app(Cart::class);
        $items = $cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('shop');
        }

        $order = DB::transaction(function () use ($data, $cart, $items) {
            // check stock first
            foreach ($items as $i) {
                $p = Product::lockForUpdate()->find($i->product->id);
                if (! $p || $p->stock < $i->qty) {
                    throw ValidationException::withMessages([
                        'cart' => "Sorry, '{$i->product->name}' doesn't have enough stock.",
                    ]);
                }
            }

            $order = Order::create($data + [
                'order_number' => 'SNF-'.strtoupper(Str::random(8)),
                'subtotal' => $cart->subtotal(),
                'shipping' => $cart->shipping(),
                'total' => $cart->total(),
                'status' => 'pending',
                'payment_method' => 'cod',
            ]);

            foreach ($items as $i) {
                $order->items()->create([
                    'product_id' => $i->product->id,
                    'product_name' => $i->product->name,
                    'size' => $i->size,
                    'color' => $i->color,
                    'price' => $i->product->final_price,
                    'quantity' => $i->qty,
                ]);
                $i->product->decrement('stock', $i->qty);
            }

            return $order;
        });

        $cart->clear();
        $this->dispatch('cart-updated');

        return redirect()->route('order.success', $order->order_number);
    }

    public function render()
    {
        $cart = app(Cart::class);

        return view('livewire.checkout', [
            'items' => $cart->items(),
            'subtotal' => $cart->subtotal(),
            'shipping' => $cart->shipping(),
            'total' => $cart->total(),
        ]);
    }
}
