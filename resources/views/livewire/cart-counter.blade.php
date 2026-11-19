<div>
    <a href="{{ route('cart') }}" wire:navigate aria-label="{{ __('Cart') }}"
       class="relative h-12 w-12 border border-brand-line flex items-center justify-center hover:bg-brand-ink hover:text-white hover:border-brand-ink transition">
        <x-heroicon-o-shopping-bag class="w-7 h-7"/>
        @if ($count > 0)
            <span class="absolute -top-2 -end-2 bg-brand-pink text-brand-ink text-[11px] font-bold min-w-5 h-5 px-1 flex items-center justify-center">{{ $count }}</span>
        @endif
    </a>
</div>
