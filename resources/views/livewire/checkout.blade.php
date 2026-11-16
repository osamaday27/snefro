<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-8">Checkout</h1>

    @error('cart') <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">{{ $message }}</div> @enderror

    <div class="grid lg:grid-cols-3 gap-8">
        <form wire:submit="placeOrder" class="lg:col-span-2 space-y-5 border rounded-xl p-6">
            <h2 class="font-bold text-lg">Delivery details</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium">Full name *</label>
                    <input type="text" wire:model="customer_name" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    @error('customer_name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium">Phone *</label>
                    <input type="tel" wire:model="phone" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    @error('phone') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="text-sm font-medium">Email (optional)</label>
                <input type="email" wire:model="email" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="text-sm font-medium">Address *</label>
                    <input type="text" wire:model="address" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    @error('address') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium">City *</label>
                    <input type="text" wire:model="city" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    @error('city') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="text-sm font-medium">Order notes</label>
                <textarea wire:model="notes" rows="3" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none"></textarea>
            </div>

            <div class="rounded-lg bg-amber-50 border border-amber-200 px-4 py-3 text-sm">
                <strong>Payment method:</strong> Cash on delivery (COD)
            </div>

            <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-stone-900 hover:bg-stone-700 disabled:opacity-50 text-white font-semibold py-3.5 rounded-lg">
                <span wire:loading.remove wire:target="placeOrder">Confirm order · {{ number_format($total) }} EGP</span>
                <span wire:loading wire:target="placeOrder">Placing order...</span>
            </button>
        </form>

        <aside class="border rounded-xl p-6 h-fit space-y-3">
            <h2 class="font-bold text-lg">Your order</h2>
            @foreach ($items as $item)
                <div class="flex justify-between gap-3 text-sm" wire:key="co-{{ $item->key }}">
                    <span class="truncate">{{ $item->qty }}× {{ $item->product->name }}
                        <span class="text-stone-500">{{ $item->size }} {{ $item->color }}</span></span>
                    <span>{{ number_format($item->line_total) }}</span>
                </div>
            @endforeach
            <div class="border-t pt-3 flex justify-between text-sm"><span>Subtotal</span><span>{{ number_format($subtotal) }} EGP</span></div>
            <div class="flex justify-between text-sm"><span>Shipping</span><span>{{ number_format($shipping) }} EGP</span></div>
            <div class="flex justify-between font-bold text-lg border-t pt-3"><span>Total</span><span>{{ number_format($total) }} EGP</span></div>
        </aside>
    </div>
</div>
