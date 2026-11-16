<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class Cart
{
    public const SHIPPING = 50;

    protected function raw(): array
    {
        return session('cart', []);
    }

    public function items(): Collection
    {
        $cart = $this->raw();
        $products = Product::active()->whereIn('id', collect($cart)->pluck('product_id'))->get()->keyBy('id');

        return collect($cart)->map(function ($row, $key) use ($products) {
            $p = $products->get($row['product_id']);
            if (! $p) return null;
            return (object) [
                'key' => $key,
                'product' => $p,
                'size' => $row['size'],
                'color' => $row['color'],
                'qty' => $row['qty'],
                'line_total' => $p->final_price * $row['qty'],
            ];
        })->filter()->values();
    }

    public function add(Product $product, ?string $size, ?string $color, int $qty): void
    {
        $cart = $this->raw();
        $key = $product->id.'-'.($size ?? '').'-'.($color ?? '');
        $current = $cart[$key]['qty'] ?? 0;

        $cart[$key] = [
            'product_id' => $product->id,
            'size' => $size,
            'color' => $color,
            'qty' => min($current + $qty, max($product->stock, 1)),
        ];
        session(['cart' => $cart]);
    }

    public function setQty(string $key, int $qty): void
    {
        $cart = $this->raw();
        if (! isset($cart[$key])) return;
        $product = Product::find($cart[$key]['product_id']);
        $cart[$key]['qty'] = max(1, min($qty, $product?->stock ?: 1));
        session(['cart' => $cart]);
    }

    public function remove(string $key): void
    {
        $cart = $this->raw();
        unset($cart[$key]);
        session(['cart' => $cart]);
    }

    public function clear(): void
    {
        session()->forget('cart');
    }

    public function count(): int
    {
        return (int) collect($this->raw())->sum('qty');
    }

    public function subtotal(): float
    {
        return (float) $this->items()->sum('line_total');
    }

    public function shipping(): float
    {
        return $this->subtotal() > 0 ? self::SHIPPING : 0;
    }

    public function total(): float
    {
        return $this->subtotal() + $this->shipping();
    }
}
