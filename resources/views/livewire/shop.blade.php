<div class="max-w-7xl mx-auto px-4 py-12">
    <div data-reveal class="flex items-end justify-between gap-4 flex-wrap">
        <div>
            <span class="text-xs font-semibold uppercase tracking-[.22em] text-brand-rose">{{ __('Snefro for Kids') }}</span>
            <h1 class="text-3xl md:text-4xl font-bold mt-2">{{ __('Shop') }}</h1>
            <span class="title-line mt-4"></span>
        </div>
        <p class="text-neutral-500 text-sm">{{ $products->total() }} {{ __('products available') }}</p>
    </div>

    {{-- أقسام بالصور --}}
    <div class="mt-10 flex gap-3 overflow-x-auto no-scrollbar pb-2">
        <button wire:click="setCategory('')" class="shrink-0 w-24 group">
            <span class="block aspect-square flex items-center justify-center border-2 transition {{ $category === '' ? 'border-brand-ink bg-brand-ink text-white' : 'border-brand-line group-hover:border-brand-pink' }}"><x-heroicon-o-squares-2x2 class="w-9 h-9"/></span>
            <span class="block mt-2 text-xs font-semibold text-center">{{ __('All') }}</span>
        </button>
        @foreach ($categories as $c)
            <button wire:click="setCategory('{{ $c->slug }}')" wire:key="chip-{{ $c->id }}" class="shrink-0 w-24 group">
                <span class="block aspect-square overflow-hidden border-2 transition {{ $category === $c->slug ? 'border-brand-rose' : 'border-brand-line group-hover:border-brand-pink' }}">
                    <img src="{{ $c->image_url }}" alt="{{ $c->tr('name') }}" onerror="this.onerror=null;this.src='https://placehold.co/200x200/F6F6F6/111111?text=+'" class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
                </span>
                <span class="block mt-2 text-xs font-semibold text-center leading-tight {{ $category === $c->slug ? 'text-brand-rose' : '' }}">{{ $c->tr('name') }}</span>
            </button>
        @endforeach
    </div>

    {{-- فلاتر --}}
    <div class="mt-8 border border-brand-line p-3 grid md:grid-cols-12 gap-3 items-center">
        <div class="relative md:col-span-5">
            <x-heroicon-o-magnifying-glass class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-neutral-400"/>
            <input type="search" wire:model.live.debounce.300ms="search" placeholder="{{ __('Search products...') }}"
                   class="w-full border border-brand-line ps-12 pe-4 py-3 focus:outline-none focus:border-brand-ink">
        </div>
        <div class="md:col-span-4 grid grid-cols-3 gap-2">
            @foreach (['' => __('All'), 'boys' => __('Boys'), 'girls' => __('Girls')] as $k => $label)
                <button wire:click="setGender('{{ $k }}')" class="py-3 text-sm font-semibold transition {{ $gender === $k ? 'bg-brand-ink text-white' : 'bg-brand-mist hover:bg-brand-pink' }}">{{ $label }}</button>
            @endforeach
        </div>
        <div class="md:col-span-3 relative">
            <x-heroicon-o-adjustments-horizontal class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-neutral-400 pointer-events-none"/>
            <select wire:model.live="sort" class="w-full appearance-none border border-brand-line ps-12 pe-4 py-3 bg-white font-medium focus:outline-none focus:border-brand-ink">
                <option value="latest">{{ __('Latest') }}</option>
                <option value="price_asc">{{ __('Price: low to high') }}</option>
                <option value="price_desc">{{ __('Price: high to low') }}</option>
            </select>
        </div>
    </div>

    <div wire:loading.class="opacity-40" class="mt-10 grid grid-cols-2 lg:grid-cols-4 gap-x-3 md:gap-x-5 gap-y-10 transition">
        @forelse ($products as $i => $p)
            <x-product-card :product="$p" data-reveal style="--d: {{ ($i % 4) * 70 }}ms" wire:key="shop-{{ $p->id }}" />
        @empty
            <div class="col-span-full text-center py-24">
                <x-heroicon-o-face-frown class="w-16 h-16 mx-auto text-neutral-300"/>
                <p class="mt-4 font-semibold text-lg">{{ __('No products match your search') }}</p>
                <button wire:click="resetFilters" class="mt-5 inline-flex items-center gap-2 bg-brand-ink text-white font-semibold px-6 py-3 hover:bg-brand-rose transition"><x-heroicon-o-arrow-path class="w-6 h-6"/>{{ __('Reset filters') }}</button>
            </div>
        @endforelse
    </div>

    <div class="mt-14">{{ $products->links('pagination.arabic') }}</div>
</div>
