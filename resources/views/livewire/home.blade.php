<div>
    {{-- Hero --}}
    <section class="relative bg-stone-900 text-white overflow-hidden">
        <img src="https://picsum.photos/seed/snefro-hero/1600/700" alt="" class="absolute inset-0 w-full h-full object-cover opacity-40">
        <div class="relative max-w-7xl mx-auto px-4 py-24 md:py-36">
            <p class="text-amber-400 text-sm font-semibold tracking-widest uppercase">New collection</p>
            <h1 class="mt-3 text-4xl md:text-6xl font-black leading-tight max-w-2xl">Wear what moves you.</h1>
            <p class="mt-4 text-stone-200 max-w-lg">Fresh styles, honest prices, and cash on delivery. Discover the latest drops from Snefro.</p>
            <div class="mt-8 flex gap-3">
                <a href="{{ route('shop') }}" wire:navigate class="bg-amber-500 hover:bg-amber-400 text-stone-900 font-semibold px-6 py-3 rounded-lg transition">Shop now</a>
                <a href="#categories" class="border border-white/50 hover:bg-white/10 px-6 py-3 rounded-lg transition">Browse categories</a>
            </div>
        </div>
    </section>

    {{-- Promo banner --}}
    <section class="max-w-7xl mx-auto px-4 -mt-8 relative z-10">
        <div class="bg-amber-500 text-stone-900 rounded-xl px-6 py-5 flex flex-col md:flex-row items-center justify-between gap-2 shadow-lg">
            <p class="font-bold text-lg">Up to 20% off selected items</p>
            <p class="text-sm">Pay on delivery · Easy returns</p>
        </div>
    </section>

    {{-- Categories --}}
    <section id="categories" class="max-w-7xl mx-auto px-4 mt-20">
        <h2 class="text-2xl font-bold mb-6">Shop by category</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse ($categories as $c)
                <a href="{{ route('shop', ['category' => $c->slug]) }}" wire:navigate
                   class="group rounded-xl border border-stone-200 p-6 hover:border-amber-500 hover:shadow-md transition">
                    <div class="text-3xl">🛍️</div>
                    <h3 class="mt-3 font-semibold group-hover:text-amber-600">{{ $c->name }}</h3>
                    <p class="text-xs text-stone-500">{{ $c->products_count }} products</p>
                </a>
            @empty
                <p class="text-stone-500 col-span-full">No categories yet.</p>
            @endforelse
        </div>
    </section>

    {{-- Latest products --}}
    <section class="max-w-7xl mx-auto px-4 mt-20">
        <div class="flex items-end justify-between mb-6">
            <h2 class="text-2xl font-bold">Latest products</h2>
            <a href="{{ route('shop') }}" wire:navigate class="text-sm font-medium text-amber-600 hover:underline">View all →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-8">
            @forelse ($products as $p)
                <x-product-card :product="$p" wire:key="p-{{ $p->id }}" />
            @empty
                <p class="text-stone-500 col-span-full">No products yet.</p>
            @endforelse
        </div>
    </section>

    {{-- Perks --}}
    <section class="max-w-7xl mx-auto px-4 mt-20 grid gap-4 md:grid-cols-3 text-center">
        @foreach ([['🚚','Fast delivery','2–4 working days'],['💵','Cash on delivery','Pay when you receive'],['🔁','Easy returns','Hassle-free exchange']] as [$i,$t,$d])
            <div class="rounded-xl bg-stone-50 p-6">
                <div class="text-3xl">{{ $i }}</div>
                <h3 class="mt-2 font-semibold">{{ $t }}</h3>
                <p class="text-sm text-stone-500">{{ $d }}</p>
            </div>
        @endforeach
    </section>
</div>
