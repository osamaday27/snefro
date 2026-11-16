<div>
    <a href="{{ route('cart') }}" wire:navigate class="relative inline-flex" aria-label="Cart">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 3h2l.4 2M7 13h10l3-8H5.4M7 13L5.4 5M7 13l-2 4h12M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/></svg>
        @if ($count > 0)
            <span class="absolute -top-2 -right-2 bg-amber-500 text-stone-900 text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $count }}</span>
        @endif
    </a>
</div>
