<div>
    <a href="{{ route('cart') }}" wire:navigate aria-label="السلة"
       class="relative h-12 w-12 rounded-2xl bg-brand-yellow text-brand-ink flex items-center justify-center hover:scale-105 transition shadow">
        <x-heroicon-o-shopping-cart class="w-7 h-7"/>
        @if ($count > 0)
            <span class="absolute -top-2 -start-2 bg-brand-red text-white text-xs font-black rounded-full min-w-6 h-6 px-1 flex items-center justify-center ring-2 ring-white">{{ $count }}</span>
        @endif
    </a>
</div>
