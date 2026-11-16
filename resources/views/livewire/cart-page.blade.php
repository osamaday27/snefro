<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-8">Your cart</h1>

    @if ($items->isEmpty())
        <div class="text-center py-20 bg-stone-50 rounded-xl">
            <div class="text-5xl">🛒</div>
            <p class="mt-3 text-stone-600">Your cart is empty.</p>
            <a href="{{ route('shop') }}" wire:navigate class="inline-block mt-5 bg-stone-900 text-white px-6 py-3 rounded-lg">Continue shopping</a>
        </div>
    @else
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 divide-y border rounded-xl">
                @foreach ($items as $item)
                    <div class="p-4 flex gap-4" wire:key="item-{{ $item->key }}">
                        <img src="{{ $item->product->image_url }}" class="w-24 h-28 object-cover rounded-lg bg-stone-100" alt="">
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between gap-2">
                                <a href="{{ route('product', $item->product->slug) }}" wire:navigate class="font-semibold hover:underline">{{ $item->product->name }}</a>
                                <button wire:click="remove('{{ $item->key }}')" class="text-stone-400 hover:text-red-600" aria-label="Remove">✕</button>
                            </div>
                            <p class="text-sm text-stone-500">
                                @if ($item->size) Size: {{ $item->size }} @endif
                                @if ($item->color) · Color: {{ $item->color }} @endif
                            </p>
                            <p class="text-sm mt-1">{{ number_format($item->product->final_price) }} EGP</p>

                            <div class="mt-3 flex items-center justify-between">
                                <div class="inline-flex items-center border border-stone-300 rounded-lg">
                                    <button wire:click="decrement('{{ $item->key }}', {{ $item->qty }})" class="w-8 h-8 hover:bg-stone-100 rounded-l-lg">−</button>
                                    <span class="w-10 text-center text-sm">{{ $item->qty }}</span>
                                    <button wire:click="increment('{{ $item->key }}', {{ $item->qty }})" class="w-8 h-8 hover:bg-stone-100 rounded-r-lg">+</button>
                                </div>
                                <p class="font-bold">{{ number_format($item->line_total) }} EGP</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <aside class="border rounded-xl p-6 h-fit space-y-3">
                <h2 class="font-bold text-lg">Order summary</h2>
                <div class="flex justify-between text-sm"><span>Subtotal</span><span>{{ number_format($subtotal) }} EGP</span></div>
                <div class="flex justify-between text-sm"><span>Shipping</span><span>{{ number_format($shipping) }} EGP</span></div>
                <div class="flex justify-between font-bold text-lg border-t pt-3"><span>Total</span><span>{{ number_format($total) }} EGP</span></div>
                <a href="{{ route('checkout') }}" wire:navigate class="block text-center bg-stone-900 hover:bg-stone-700 text-white font-semibold py-3 rounded-lg">Proceed to checkout</a>
                <p class="text-xs text-stone-500 text-center">Payment: Cash on delivery</p>
            </aside>
        </div>
    @endif
</div>
