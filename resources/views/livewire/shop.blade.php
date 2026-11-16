<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex items-center gap-4">
        <span class="h-14 w-14 rounded-2xl bg-brand-blue text-white flex items-center justify-center shadow-lg"><x-heroicon-o-shopping-bag class="w-8 h-8"/></span>
        <div><h1 class="text-3xl font-black">المتجر</h1><p class="text-slate-500 text-sm">{{ $products->total() }} منتج متاح</p></div>
    </div>

    {{-- Categories with images --}}
    <div class="mt-8 flex gap-3 overflow-x-auto no-scrollbar pb-2">
        <button wire:click="setCategory('')" class="shrink-0 flex flex-col items-center gap-2 w-20">
            <span class="h-16 w-16 rounded-full flex items-center justify-center {{ $category === '' ? 'bg-brand-blue text-white ring-4 ring-sky-200' : 'bg-white text-brand-ink border border-slate-200' }}"><x-heroicon-o-squares-2x2 class="w-8 h-8"/></span>
            <span class="text-xs font-bold {{ $category === '' ? 'text-brand-blue' : '' }}">الكل</span>
        </button>
        @foreach ($categories as $c)
            <button wire:click="setCategory('{{ $c->slug }}')" wire:key="chip-{{ $c->id }}" class="shrink-0 flex flex-col items-center gap-2 w-20">
                <img src="{{ $c->image_url }}" alt="{{ $c->name }}" onerror="this.onerror=null;this.src='https://placehold.co/200x200/fde68a/1f2a44?text=+'"
                     class="h-16 w-16 rounded-full object-cover {{ $category === $c->slug ? 'ring-4 ring-brand-blue' : 'ring-2 ring-slate-200' }}">
                <span class="text-xs font-bold text-center leading-tight {{ $category === $c->slug ? 'text-brand-blue' : '' }}">{{ $c->name }}</span>
            </button>
        @endforeach
    </div>

    {{-- Filters --}}
    <div class="mt-6 bg-white rounded-3xl shadow-sm p-4 grid md:grid-cols-12 gap-3 items-center">
        <div class="relative md:col-span-5">
            <x-heroicon-o-magnifying-glass class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-slate-400"/>
            <input type="search" wire:model.live.debounce.300ms="search" placeholder="ابحث عن منتج..."
                   class="w-full rounded-2xl border border-slate-200 ps-12 pe-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-blue">
        </div>
        <div class="md:col-span-4 flex gap-2">
            @foreach ([''=>'الكل', 'boys'=>'أولاد', 'girls'=>'بنات'] as $k => $label)
                <button wire:click="setGender('{{ $k }}')" class="flex-1 py-3 rounded-2xl font-bold text-sm transition {{ $gender === $k ? 'bg-brand-ink text-white' : 'bg-slate-100 hover:bg-slate-200' }}">{{ $label }}</button>
            @endforeach
        </div>
        <div class="md:col-span-3 relative">
            <x-heroicon-o-adjustments-horizontal class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-slate-400 pointer-events-none"/>
            <select wire:model.live="sort" class="w-full appearance-none rounded-2xl border border-slate-200 ps-12 pe-4 py-3 bg-white font-semibold focus:outline-none focus:ring-2 focus:ring-brand-blue">
                <option value="latest">الأحدث</option>
                <option value="price_asc">السعر: الأقل أولاً</option>
                <option value="price_desc">السعر: الأعلى أولاً</option>
            </select>
        </div>
    </div>

    <div wire:loading.class="opacity-50" class="mt-8 grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 transition">
        @forelse ($products as $p)
            <x-product-card :product="$p" wire:key="shop-{{ $p->id }}" />
        @empty
            <div class="col-span-full text-center py-20">
                <span class="mx-auto h-24 w-24 rounded-full bg-brand-sky text-brand-blue flex items-center justify-center"><x-heroicon-o-face-frown class="w-14 h-14"/></span>
                <p class="mt-4 font-bold text-lg">لا توجد منتجات مطابقة لبحثك</p>
                <button wire:click="resetFilters" class="mt-4 inline-flex items-center gap-2 bg-brand-blue text-white font-bold px-6 py-3 rounded-2xl"><x-heroicon-o-arrow-path class="w-6 h-6"/>مسح الفلاتر</button>
            </div>
        @endforelse
    </div>

    <div class="mt-12">{{ $products->links('pagination.arabic') }}</div>
</div>
