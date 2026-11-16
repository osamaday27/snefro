@props(['product'])
<a href="{{ route('product', $product->slug) }}" wire:navigate class="group block">
    <div class="relative aspect-[4/5] overflow-hidden rounded-xl bg-stone-100">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy"
             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @if ($product->on_sale)
            <span class="absolute top-3 left-3 bg-amber-500 text-stone-900 text-xs font-bold px-2 py-1 rounded">SALE</span>
        @endif
        @if ($product->stock < 1)
            <span class="absolute top-3 right-3 bg-stone-900 text-white text-xs px-2 py-1 rounded">Sold out</span>
        @endif
    </div>
    <div class="mt-3">
        <p class="text-xs text-stone-500">{{ $product->category?->name }}</p>
        <h3 class="font-semibold truncate">{{ $product->name }}</h3>
        <p class="text-sm">
            <span class="font-bold">{{ number_format($product->final_price) }} EGP</span>
            @if ($product->on_sale)
                <span class="text-stone-400 line-through ml-1">{{ number_format($product->price) }}</span>
            @endif
        </p>
    </div>
</a>
