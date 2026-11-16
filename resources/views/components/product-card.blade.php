@props(['product'])
<a {{ $attributes }} href="{{ route('product', $product->slug) }}" wire:navigate
   class="group block bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 overflow-hidden">
    <div class="relative aspect-[4/5] overflow-hidden bg-brand-sky">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy"
             onerror="this.onerror=null;this.src='https://placehold.co/600x750/fde68a/1f2a44?text=Snefro'"
             class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
        <div class="absolute top-3 start-3 flex flex-col gap-1.5">
            @if ($product->on_sale)
                <span class="bg-brand-red text-white text-xs font-extrabold px-2.5 py-1 rounded-full shadow">خصم {{ $product->discount_percent }}%</span>
            @endif
            @if ($product->is_featured)
                <span class="bg-brand-yellow text-brand-ink text-xs font-extrabold px-2.5 py-1 rounded-full shadow flex items-center gap-1"><x-heroicon-s-star class="w-3.5 h-3.5"/>مميز</span>
            @endif
        </div>
        @if ($product->stock < 1)
            <div class="absolute inset-0 bg-white/70 flex items-center justify-center"><span class="bg-brand-ink text-white font-bold px-4 py-1.5 rounded-full text-sm">نفد المخزون</span></div>
        @endif
        <span class="absolute bottom-3 end-3 h-11 w-11 rounded-2xl bg-white shadow-lg flex items-center justify-center text-brand-blue
                     translate-y-14 group-hover:translate-y-0 transition duration-300">
            <x-heroicon-o-shopping-bag class="w-6 h-6"/>
        </span>
    </div>
    <div class="p-4">
        <div class="flex items-center justify-between gap-2 text-xs text-slate-500">
            <span class="truncate">{{ $product->category?->name }}</span>
            @if ($product->age_range)<span class="shrink-0 flex items-center gap-1"><x-heroicon-o-cake class="w-4 h-4"/>{{ $product->age_range }}</span>@endif
        </div>
        <h3 class="mt-1 font-bold text-brand-ink line-clamp-1">{{ $product->name }}</h3>
        @if ($product->short_description)
            <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">{{ $product->short_description }}</p>
        @endif
        <div class="mt-3 flex items-baseline gap-2">
            <span class="text-lg font-black text-brand-blue">{{ number_format($product->final_price) }} <small class="text-xs font-bold">{{ config('snefro.currency') }}</small></span>
            @if ($product->on_sale)
                <span class="text-sm text-slate-400 line-through">{{ number_format($product->price) }}</span>
            @endif
        </div>
    </div>
</a>
