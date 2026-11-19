@props(['product'])
@php $imgs = $product->gallery; @endphp
<a {{ $attributes }} href="{{ route('product', $product->slug) }}" wire:navigate class="group block bg-white">
    <div class="relative aspect-[4/5] overflow-hidden bg-brand-mist">
        <img src="{{ $imgs[0] }}" alt="{{ $product->tr('name') }}" loading="lazy"
             onerror="this.onerror=null;this.src='https://placehold.co/600x750/F6F6F6/111111?text=Snefro'"
             class="absolute inset-0 h-full w-full object-cover transition duration-700 {{ isset($imgs[1]) ? 'group-hover:opacity-0' : 'group-hover:scale-105' }}">
        @if (isset($imgs[1]))
            <img src="{{ $imgs[1] }}" alt="" loading="lazy" class="absolute inset-0 h-full w-full object-cover opacity-0 scale-105 transition duration-700 group-hover:opacity-100 group-hover:scale-100">
        @endif

        <div class="absolute top-0 start-0 flex flex-col items-start">
            @if ($product->on_sale)
                <span class="bg-brand-ink text-white text-[11px] font-semibold tracking-wide px-3 py-1.5">-{{ $product->discount_percent }}%</span>
            @elseif ($product->is_featured)
                <span class="bg-brand-pink text-brand-ink text-[11px] font-semibold tracking-wide px-3 py-1.5">{{ __('Featured') }}</span>
            @endif
        </div>

        @if ($product->stock < 1)
            <div class="absolute inset-0 bg-white/70 flex items-center justify-center"><span class="bg-brand-ink text-white text-xs font-semibold px-4 py-2">{{ __('Sold out') }}</span></div>
        @endif

        {{-- شريط يصعد عند التمرير --}}
        <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition duration-500 bg-brand-ink text-white flex items-center justify-between px-4 py-3 text-sm font-medium">
            <span>{{ __('View product') }}</span>
            <x-heroicon-o-arrow-long-right class="w-6 h-6 rtl:rotate-180 transition-transform duration-300 group-hover:translate-x-1 rtl:group-hover:-translate-x-1"/>
        </div>
    </div>

    <div class="pt-4">
        <p class="text-xs text-neutral-500 flex items-center justify-between gap-2">
            <span class="truncate">{{ $product->category?->tr('name') }}</span>
            @if ($product->age_range)<span class="shrink-0">{{ \App\Models\Product::unit($product->age_range) }}</span>@endif
        </p>
        <h3 class="mt-1 font-semibold text-brand-ink truncate group-hover:text-brand-rose transition">{{ $product->tr('name') }}</h3>
        <p class="mt-1 flex items-baseline gap-2">
            <span class="font-bold text-brand-ink">{{ number_format($product->final_price) }} <span class="text-xs font-semibold">{{ __('EGP') }}</span></span>
            @if ($product->on_sale)<span class="text-sm text-neutral-400 line-through">{{ number_format($product->price) }}</span>@endif
        </p>
    </div>
</a>
