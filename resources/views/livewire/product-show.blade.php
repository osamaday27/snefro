@php
    $gallery = $product->gallery;
    $waText = __('Hello Snefro for Kids, I would like to ask about').":\n".$product->tr('name')."\n".__('Code').": ".$product->sku."\n".route('product', $product->slug);
    $sizes = $product->sizes ?? []; $colors = $product->colors ?? [];
    $features = app()->getLocale() === 'en' && ! empty($product->features_en) ? $product->features_en : ($product->features ?? []);
@endphp
<div class="max-w-7xl mx-auto px-4 py-10">
    <nav class="text-sm text-neutral-500 mb-8 flex items-center gap-2 flex-wrap">
        <a href="{{ route('home') }}" wire:navigate class="hover:text-brand-rose transition">{{ __('Home') }}</a><x-heroicon-o-chevron-left class="w-4 h-4 ltr:rotate-180"/>
        <a href="{{ route('shop') }}" wire:navigate class="hover:text-brand-rose transition">{{ __('Shop') }}</a><x-heroicon-o-chevron-left class="w-4 h-4 ltr:rotate-180"/>
        @if ($product->category)
            <a href="{{ route('shop', ['category' => $product->category->slug]) }}" wire:navigate class="hover:text-brand-rose transition">{{ $product->category->tr('name') }}</a><x-heroicon-o-chevron-left class="w-4 h-4 ltr:rotate-180"/>
        @endif
        <span class="text-brand-ink font-semibold">{{ $product->tr('name') }}</span>
    </nav>

    <div class="grid lg:grid-cols-2 gap-10 lg:gap-14">
        {{-- المعرض --}}
        <div data-reveal="left" class="grid grid-cols-[5rem_1fr] gap-3 items-start">
            <div class="flex flex-col gap-3 order-1">
                @foreach ($gallery as $i => $img)
                    <button wire:click="$set('activeImage', {{ $i }})" wire:key="g-{{ $i }}" class="aspect-square overflow-hidden border-2 transition {{ $activeImage === $i ? 'border-brand-ink' : 'border-transparent opacity-60 hover:opacity-100' }}">
                        <img src="{{ $img }}" class="w-full h-full object-cover" alt="">
                    </button>
                @endforeach
            </div>
            <div class="relative aspect-[4/5] overflow-hidden bg-brand-mist group order-2">
                <img wire:key="main-{{ $activeImage }}" src="{{ $gallery[$activeImage] ?? $gallery[0] }}" alt="{{ $product->tr('name') }}"
                     onerror="this.onerror=null;this.src='https://placehold.co/600x750/F6F6F6/111111?text=Snefro'"
                     class="absolute inset-0 w-full h-full object-cover animate-fadeup transition duration-700 group-hover:scale-110">
                @if ($product->on_sale)
                    <span class="absolute top-0 start-0 bg-brand-ink text-white text-xs font-semibold px-4 py-2">{{ __('Save :percent%', ['percent' => $product->discount_percent]) }}</span>
                @endif
            </div>
        </div>

        {{-- المعلومات --}}
        <div data-reveal="right">
            <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                @if ($product->category)<span class="bg-brand-mist px-3 py-1.5">{{ $product->category->tr('name') }}</span>@endif
                <span class="bg-brand-pink px-3 py-1.5">{{ $product->gender_label }}</span>
                @if ($product->age_range)<span class="border border-brand-line px-3 py-1.5 flex items-center gap-1"><x-heroicon-o-cake class="w-4 h-4"/>{{ \App\Models\Product::unit($product->age_range) }}</span>@endif
            </div>

            <h1 class="text-3xl md:text-4xl font-bold mt-5 leading-snug">{{ $product->tr('name') }}</h1>
            @if ($product->tr('short_description'))<p class="text-neutral-500 mt-3">{{ $product->tr('short_description') }}</p>@endif

            <div class="mt-6 flex items-end gap-3">
                <span class="text-4xl font-bold">{{ number_format($product->final_price) }} <small class="text-base font-semibold">{{ __('EGP') }}</small></span>
                @if ($product->on_sale)<span class="text-xl text-neutral-400 line-through mb-1">{{ number_format($product->price) }}</span>@endif
            </div>

            <div class="mt-4 flex flex-wrap items-center gap-5 text-sm">
                @if ($product->stock > 0)
                    <span class="flex items-center gap-1.5 text-green-700 font-semibold"><x-heroicon-s-check-circle class="w-6 h-6"/>{{ $product->stock <= 5 ? __('Only :count left!', ['count' => $product->stock]) : __('In stock') }}</span>
                @else
                    <span class="flex items-center gap-1.5 text-red-600 font-semibold"><x-heroicon-s-x-circle class="w-6 h-6"/>{{ __('Out of stock') }}</span>
                @endif
                @if ($product->sku)<span class="text-neutral-400 flex items-center gap-1"><x-heroicon-o-tag class="w-5 h-5"/>{{ __('Code') }}: {{ $product->sku }}</span>@endif
            </div>

            @if (! empty($features))
                <ul class="mt-6 grid sm:grid-cols-2 gap-x-6 gap-y-2.5 border-y border-brand-line py-5">
                    @foreach ($features as $f)
                        <li class="flex items-start gap-2 text-sm text-neutral-700"><x-heroicon-s-check class="w-5 h-5 text-brand-rose shrink-0 mt-0.5"/>{{ $f }}</li>
                    @endforeach
                </ul>
            @endif

            @if (! empty($sizes))
                <div class="mt-7">
                    <p class="font-bold mb-3 text-sm uppercase tracking-wider">{{ __('Size') }}</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($sizes as $s)
                            <button wire:click="$set('size', '{{ $s }}')" wire:key="s-{{ $s }}"
                                    class="min-w-14 px-5 py-3 border text-sm font-semibold transition {{ $size === $s ? 'bg-brand-ink border-brand-ink text-white' : 'border-brand-line hover:border-brand-ink' }}">{{ \App\Models\Product::unit($s) }}</button>
                        @endforeach
                    </div>
                    @error('size') <p class="text-red-600 text-sm font-semibold mt-2 flex items-center gap-1"><x-heroicon-o-exclamation-circle class="w-5 h-5"/>{{ $message }}</p> @enderror
                </div>
            @endif

            @if (! empty($colors))
                <div class="mt-7">
                    <p class="font-bold mb-3 text-sm uppercase tracking-wider">{{ __('Color') }} @if($color)<span class="text-neutral-500 font-medium normal-case">· {{ \App\Models\Product::colorLabel($color) }}</span>@endif</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($colors as $c)
                            <button wire:click="$set('color', '{{ $c }}')" wire:key="c-{{ $c }}" title="{{ \App\Models\Product::colorLabel($c) }}"
                                    class="h-12 w-12 border-2 flex items-center justify-center transition {{ $color === $c ? 'border-brand-ink ring-2 ring-brand-pink ring-offset-2' : 'border-brand-line hover:scale-105' }}"
                                    style="background: {{ \App\Models\Product::colorHex($c) }}">
                                @if ($color === $c)<x-heroicon-s-check class="w-6 h-6 {{ in_array($c, ['white', 'yellow', 'beige', 'pink', 'sky']) ? 'text-brand-ink' : 'text-white' }}"/>@endif
                            </button>
                        @endforeach
                    </div>
                    @error('color') <p class="text-red-600 text-sm font-semibold mt-2 flex items-center gap-1"><x-heroicon-o-exclamation-circle class="w-5 h-5"/>{{ $message }}</p> @enderror
                </div>
            @endif

            <div class="mt-7">
                <p class="font-bold mb-3 text-sm uppercase tracking-wider">{{ __('Quantity') }}</p>
                <div class="inline-flex items-center border border-brand-line">
                    <button wire:click="decrement" class="h-12 w-12 hover:bg-brand-ink hover:text-white flex items-center justify-center transition" aria-label="-"><x-heroicon-o-minus class="w-6 h-6"/></button>
                    <span class="w-14 text-center text-lg font-bold">{{ $qty }}</span>
                    <button wire:click="increment" class="h-12 w-12 hover:bg-brand-ink hover:text-white flex items-center justify-center transition" aria-label="+"><x-heroicon-o-plus class="w-6 h-6"/></button>
                </div>
                @error('stock') <p class="text-red-600 text-sm font-semibold mt-2">{{ $message }}</p> @enderror
            </div>

            <div class="mt-9 flex flex-col sm:flex-row gap-3">
                <button wire:click="addToCart" wire:loading.attr="disabled" @disabled($product->stock < 1)
                        class="group flex-1 inline-flex items-center justify-center gap-3 bg-brand-ink hover:bg-brand-rose disabled:opacity-40 text-white text-lg font-semibold py-4 transition">
                    <x-heroicon-o-shopping-bag class="w-7 h-7 transition-transform group-hover:-translate-y-0.5" wire:loading.remove wire:target="addToCart"/>
                    <x-heroicon-o-arrow-path class="w-7 h-7 animate-spin" wire:loading wire:target="addToCart"/>
                    {{ __('Add to cart') }}
                </button>
                <a href="https://wa.me/{{ config('snefro.whatsapp') }}?text={{ urlencode($waText) }}" target="_blank"
                   class="inline-flex items-center justify-center gap-3 border border-brand-ink font-semibold py-4 px-6 hover:bg-[#25D366] hover:border-[#25D366] hover:text-white transition">
                    <x-whatsapp-icon class="w-7 h-7"/>{{ __('Ask on WhatsApp') }}
                </a>
            </div>

            <div class="mt-7 grid grid-cols-2 gap-px bg-brand-line border border-brand-line text-sm font-semibold">
                @foreach ([['banknotes', __('Cash on delivery')], ['truck', __('Delivery across Egypt')], ['arrow-path', __('Easy exchange & returns')], ['shield-check', __('Safe materials for kids')]] as [$i, $t])
                    <div class="bg-white p-4 flex items-center gap-3">@svg('heroicon-o-'.$i, 'w-8 h-8 shrink-0 text-brand-rose'){{ $t }}</div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- التفاصيل --}}
    <section data-reveal class="mt-20 border border-brand-line" x-data="{ tab: 'desc' }">
        <div class="flex overflow-x-auto no-scrollbar border-b border-brand-line">
            @foreach ([['desc', __('Description'), 'document-text'], ['specs', __('Specifications'), 'clipboard-document-list'], ['care', __('Care & washing'), 'sparkles'], ['ship', __('Shipping & returns'), 'truck']] as [$k, $l, $i])
                <button @click="tab='{{ $k }}'" :class="tab==='{{ $k }}' ? 'bg-brand-ink text-white' : 'hover:bg-brand-blush'"
                        class="shrink-0 inline-flex items-center gap-2 px-6 py-4 font-semibold text-sm transition">@svg('heroicon-o-'.$i, 'w-6 h-6'){{ $l }}</button>
            @endforeach
        </div>

        <div class="p-6 md:p-10 leading-8 text-neutral-700">
            <div x-show="tab==='desc'"><p class="whitespace-pre-line max-w-3xl">{{ $product->tr('description') ?: __('No description yet.') }}</p></div>

            <div x-show="tab==='specs'" x-cloak>
                <dl class="grid sm:grid-cols-2 gap-px bg-brand-line border border-brand-line max-w-3xl">
                    @foreach ([
                        __('Category') => $product->category?->tr('name'),
                        __('Suitable for') => $product->gender_label,
                        __('Age range') => \App\Models\Product::unit($product->age_range),
                        __('Material') => $product->tr('material'),
                        __('Available sizes') => $sizes ? implode(' · ', array_map([\App\Models\Product::class, 'unit'], $sizes)) : null,
                        __('Available colors') => $colors ? implode(' · ', array_map([\App\Models\Product::class, 'colorLabel'], $colors)) : null,
                        __('Product code') => $product->sku,
                    ] as $label => $value)
                        @if ($value)<div class="flex justify-between gap-4 bg-white px-5 py-3"><dt class="text-neutral-500">{{ $label }}</dt><dd class="font-semibold text-end">{{ $value }}</dd></div>@endif
                    @endforeach
                </dl>
            </div>

            <div x-show="tab==='care'" x-cloak>
                @if ($product->tr('care'))
                    <ul class="space-y-2">
                        @foreach (preg_split('/\r\n|\r|\n/', $product->tr('care')) as $line)
                            @if (trim($line))<li class="flex items-start gap-3"><x-heroicon-s-check class="w-6 h-6 text-brand-rose shrink-0 mt-1"/>{{ $line }}</li>@endif
                        @endforeach
                    </ul>
                @else <p>{{ __('No care instructions for this product.') }}</p> @endif
            </div>

            <div x-show="tab==='ship'" x-cloak class="space-y-4 max-w-3xl">
                <p class="flex items-start gap-3"><x-heroicon-o-truck class="w-7 h-7 text-brand-rose shrink-0"/>{{ __('Delivery to all governorates in Egypt within 2–4 working days for :cost EGP, free for orders over :over EGP.', ['cost' => config('snefro.shipping_cost'), 'over' => number_format(config('snefro.free_shipping_over'))]) }}</p>
                <p class="flex items-start gap-3"><x-heroicon-o-banknotes class="w-7 h-7 text-brand-rose shrink-0"/>{{ __('Cash on delivery. Check your order before paying.') }}</p>
                <p class="flex items-start gap-3"><x-heroicon-o-arrow-path class="w-7 h-7 text-brand-rose shrink-0"/>{{ __('Exchange or return within 14 days if the product is in its original condition.') }}</p>
            </div>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="mt-20">
            <div data-reveal class="mb-10">
                <h2 class="text-2xl md:text-3xl font-bold">{{ __('You may also like') }}</h2>
                <span class="title-line mt-4"></span>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-3 md:gap-x-5 gap-y-10">
                @foreach ($related as $i => $p) <x-product-card :product="$p" data-reveal style="--d: {{ $i * 90 }}ms" wire:key="rel-{{ $p->id }}" /> @endforeach
            </div>
        </section>
    @endif
</div>
