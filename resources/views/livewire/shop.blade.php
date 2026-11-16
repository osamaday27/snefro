<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold">Shop</h1>

    <div class="mt-6 flex flex-col md:flex-row gap-4 md:items-center md:justify-between">
        <div class="relative md:w-80">
            <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search products..."
                   class="w-full rounded-lg border border-stone-300 px-4 py-2.5 pl-10 focus:outline-none focus:ring-2 focus:ring-amber-500">
            <span class="absolute left-3 top-2.5 text-stone-400">🔍</span>
        </div>

        <div id="categories" class="flex flex-wrap gap-2">
            <button wire:click="setCategory('')"
                    class="px-4 py-1.5 rounded-full text-sm border {{ $category === '' ? 'bg-stone-900 text-white border-stone-900' : 'border-stone-300 hover:border-stone-900' }}">All</button>
            @foreach ($categories as $c)
                <button wire:click="setCategory('{{ $c->slug }}')" wire:key="cat-{{ $c->id }}"
                        class="px-4 py-1.5 rounded-full text-sm border {{ $category === $c->slug ? 'bg-stone-900 text-white border-stone-900' : 'border-stone-300 hover:border-stone-900' }}">{{ $c->name }}</button>
            @endforeach
        </div>
    </div>

    <div wire:loading.class="opacity-50" class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-8 transition">
        @forelse ($products as $p)
            <x-product-card :product="$p" wire:key="shop-{{ $p->id }}" />
        @empty
            <div class="col-span-full text-center py-20 text-stone-500">No products match your search.</div>
        @endforelse
    </div>

    <div class="mt-10">{{ $products->links() }}</div>
</div>
