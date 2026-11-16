<div class="max-w-7xl mx-auto px-4 py-10">
    <nav class="text-sm text-slate-500 mb-6 flex items-center gap-2 flex-wrap">
        <a href="{{ route('home') }}" wire:navigate class="hover:text-brand-blue">الرئيسية</a><x-heroicon-o-chevron-left class="w-4 h-4"/>
        <a href="{{ route('shop') }}" wire:navigate class="hover:text-brand-blue">المتجر</a><x-heroicon-o-chevron-left class="w-4 h-4"/>
        @if ($product->category)
            <a href="{{ route('shop', ['category' => $product->category->slug]) }}" wire:navigate class="hover:text-brand-blue">{{ $product->category->name }}</a><x-heroicon-o-chevron-left class="w-4 h-4"/>
        @endif
        <span class="text-brand-ink font-bold">{{ $product->name }}</span>
    </nav>

    @php
        $gallery = $product->gallery;
        $waText = "مرحباً سنفرو للأطفال 👋\nأريد الاستفسار عن المنتج:\n{$product->name}\nكود: {$product->sku}\n".route('product', $product->slug);
    @endphp

    <div class="grid lg:grid-cols-2 gap-10">
        {{-- Gallery --}}
        <div>
            <div class="relative aspect-[4/5] rounded-[2rem] overflow-hidden bg-brand-sky shadow-xl group">
                <img src="{{ $gallery[$activeImage] ?? $gallery[0] }}" alt="{{ $product->name }}"
                     onerror="this.onerror=null;this.src='https://placehold.co/600x750/fde68a/1f2a44?text=Snefro'"
                     class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                @if ($product->on_sale)
                    <span class="absolute top-4 start-4 bg-brand-red text-white font-black px-4 py-1.5 rounded-full shadow-lg">وفّر {{ $product->discount_percent }}%</span>
                @endif
            </div>
            @if (count($gallery) > 1)
                <div class="mt-4 grid grid-cols-5 gap-3">
                    @foreach ($gallery as $i => $img)
                        <button wire:click="$set('activeImage', {{ $i }})" wire:key="g-{{ $i }}"
                                class="aspect-square rounded-2xl overflow-hidden ring-4 transition {{ $activeImage === $i ? 'ring-brand-blue' : 'ring-transparent opacity-70 hover:opacity-100' }}">
                            <img src="{{ $img }}" class="w-full h-full object-cover" alt="">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div>
            <div class="flex flex-wrap items-center gap-2 text-sm font-bold">
                @if ($product->category)<span class="bg-sky-100 text-brand-blue px-3 py-1 rounded-full">{{ $product->category->name }}</span>@endif
                <span class="bg-purple-100 text-brand-purple px-3 py-1 rounded-full">{{ $product->gender_label }}</span>
                @if ($product->age_range)<span class="bg-orange-100 text-brand-orange px-3 py-1 rounded-full flex items-center gap-1"><x-heroicon-o-cake class="w-4 h-4"/>{{ $product->age_range }}</span>@endif
            </div>

            <h1 class="text-3xl md:text-4xl font-black mt-4 leading-snug">{{ $product->name }}</h1>
            @if ($product->short_description)<p class="text-slate-500 mt-2">{{ $product->short_description }}</p>@endif

            <div class="mt-5 flex items-end gap-3">
                <span class="text-4xl font-black text-brand-blue">{{ number_format($product->final_price) }} <small class="text-base">{{ config('snefro.currency') }}</small></span>
                @if ($product->on_sale)<span class="text-xl text-slate-400 line-through mb-1">{{ number_format($product->price) }}</span>@endif
            </div>

            <div class="mt-3 flex flex-wrap items-center gap-4 text-sm">
                @if ($product->stock > 0)
                    <span class="flex items-center gap-1.5 text-green-600 font-bold"><x-heroicon-s-check-circle class="w-6 h-6"/>متوفر{{ $product->stock <= 5 ? ' — باقي '.$product->stock.' فقط!' : '' }}</span>
                @else
                    <span class="flex items-center gap-1.5 text-brand-red font-bold"><x-heroicon-s-x-circle class="w-6 h-6"/>غير متوفر حالياً</span>
                @endif
                @if ($product->sku)<span class="text-slate-400 flex items-center gap-1"><x-heroicon-o-tag class="w-5 h-5"/>كود: {{ $product->sku }}</span>@endif
            </div>

            @if (! empty($product->features))
                <ul class="mt-6 grid sm:grid-cols-2 gap-2.5">
                    @foreach ($product->features as $f)
                        <li class="flex items-start gap-2 text-sm text-slate-700"><x-heroicon-s-check-circle class="w-5 h-5 text-brand-green shrink-0 mt-0.5"/>{{ $f }}</li>
                    @endforeach
                </ul>
            @endif

            @if (! empty($product->sizes))
                <div class="mt-7">
                    <p class="font-extrabold mb-3 flex items-center gap-2"><x-heroicon-o-swatch class="w-6 h-6 text-brand-blue"/>المقاس</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($product->sizes as $s)
                            <button wire:click="$set('size', '{{ $s }}')" wire:key="s-{{ $s }}"
                                    class="px-5 py-2.5 rounded-2xl border-2 font-bold transition {{ $size === $s ? 'bg-brand-blue border-brand-blue text-white shadow-lg' : 'border-slate-200 bg-white hover:border-brand-blue' }}">{{ $s }}</button>
                        @endforeach
                    </div>
                    @error('size') <p class="text-brand-red text-sm font-bold mt-2 flex items-center gap-1"><x-heroicon-o-exclamation-circle class="w-5 h-5"/>{{ $message }}</p> @enderror
                </div>
            @endif

            @if (! empty($product->colors))
                <div class="mt-7">
                    <p class="font-extrabold mb-3 flex items-center gap-2"><x-heroicon-o-paint-brush class="w-6 h-6 text-brand-purple"/>اللون @if($color)<span class="text-slate-500 font-semibold">: {{ $color }}</span>@endif</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($product->colors as $c)
                            <button wire:click="$set('color', '{{ $c }}')" wire:key="c-{{ $c }}" title="{{ $c }}"
                                    class="h-12 w-12 rounded-full border-2 flex items-center justify-center transition {{ $color === $c ? 'ring-4 ring-brand-blue ring-offset-2 border-white' : 'border-slate-200 hover:scale-110' }}"
                                    style="background: {{ \App\Models\Product::colorHex($c) }}">
                                @if ($color === $c)<x-heroicon-s-check class="w-6 h-6 {{ in_array($c, ['أبيض','أصفر','بيج']) ? 'text-brand-ink' : 'text-white' }}"/>@endif
                            </button>
                        @endforeach
                    </div>
                    @error('color') <p class="text-brand-red text-sm font-bold mt-2 flex items-center gap-1"><x-heroicon-o-exclamation-circle class="w-5 h-5"/>{{ $message }}</p> @enderror
                </div>
            @endif

            <div class="mt-7">
                <p class="font-extrabold mb-3 flex items-center gap-2"><x-heroicon-o-calculator class="w-6 h-6 text-brand-orange"/>الكمية</p>
                <div class="inline-flex items-center gap-2 bg-white border-2 border-slate-200 rounded-2xl p-1.5">
                    <button wire:click="decrement" class="h-12 w-12 rounded-xl bg-slate-100 hover:bg-brand-red hover:text-white flex items-center justify-center transition"><x-heroicon-o-minus class="w-7 h-7"/></button>
                    <span class="w-14 text-center text-xl font-black">{{ $qty }}</span>
                    <button wire:click="increment" class="h-12 w-12 rounded-xl bg-slate-100 hover:bg-brand-green hover:text-white flex items-center justify-center transition"><x-heroicon-o-plus class="w-7 h-7"/></button>
                </div>
                @error('stock') <p class="text-brand-red text-sm font-bold mt-2">{{ $message }}</p> @enderror
            </div>

            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                <button wire:click="addToCart" wire:loading.attr="disabled" @disabled($product->stock < 1)
                        class="flex-1 inline-flex items-center justify-center gap-3 bg-brand-blue hover:bg-sky-600 disabled:opacity-40 text-white text-lg font-extrabold py-4 rounded-2xl shadow-xl shadow-sky-200 transition">
                    <x-heroicon-o-shopping-bag class="w-8 h-8" wire:loading.remove wire:target="addToCart"/>
                    <x-heroicon-o-arrow-path class="w-8 h-8 animate-spin" wire:loading wire:target="addToCart"/>
                    أضف إلى السلة
                </button>
                <a href="https://wa.me/{{ config('snefro.whatsapp') }}?text={{ urlencode($waText) }}" target="_blank"
                   class="inline-flex items-center justify-center gap-3 bg-[#25D366] hover:bg-green-600 text-white font-extrabold py-4 px-6 rounded-2xl shadow-xl shadow-green-200 transition">
                    <x-whatsapp-icon class="w-8 h-8"/>اسأل عبر واتساب
                </a>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3 text-sm font-bold">
                @foreach ([['banknotes','الدفع عند الاستلام','text-brand-green'],['truck','شحن لكل المحافظات','text-brand-blue'],['arrow-path','استبدال واسترجاع','text-brand-orange'],['shield-check','خامات آمنة للأطفال','text-brand-purple']] as [$i,$t,$c])
                    <div class="bg-white rounded-2xl p-3 flex items-center gap-3 shadow-sm">@svg('heroicon-o-'.$i, 'w-8 h-8 '.$c){{ $t }}</div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Details tabs --}}
    <section class="mt-16 bg-white rounded-[2rem] shadow-sm p-6 md:p-8" x-data="{ tab: 'desc' }">
        <div class="flex gap-2 overflow-x-auto no-scrollbar border-b border-slate-100 pb-4">
            @foreach ([['desc','الوصف','document-text'],['specs','المواصفات','clipboard-document-list'],['care','العناية والغسيل','sparkles'],['ship','الشحن والاسترجاع','truck']] as [$k,$l,$i])
                <button @click="tab='{{ $k }}'" :class="tab==='{{ $k }}' ? 'bg-brand-blue text-white shadow-lg' : 'bg-slate-100 hover:bg-slate-200'"
                        class="shrink-0 inline-flex items-center gap-2 px-5 py-3 rounded-2xl font-bold transition">@svg('heroicon-o-'.$i, 'w-6 h-6'){{ $l }}</button>
            @endforeach
        </div>

        <div class="pt-6 leading-8 text-slate-700">
            <div x-show="tab==='desc'"><p class="whitespace-pre-line">{{ $product->description ?: 'لا يوجد وصف لهذا المنتج.' }}</p></div>

            <div x-show="tab==='specs'" x-cloak>
                <dl class="grid sm:grid-cols-2 gap-3 max-w-3xl">
                    @foreach ([
                        'القسم' => $product->category?->name,
                        'مناسب لـ' => $product->gender_label,
                        'الفئة العمرية' => $product->age_range,
                        'الخامة' => $product->material,
                        'المقاسات المتاحة' => $product->sizes ? implode('، ', $product->sizes) : null,
                        'الألوان المتاحة' => $product->colors ? implode('، ', $product->colors) : null,
                        'كود المنتج' => $product->sku,
                    ] as $label => $value)
                        @if ($value)
                            <div class="flex justify-between gap-4 bg-brand-sky rounded-2xl px-4 py-3"><dt class="font-bold text-slate-500">{{ $label }}</dt><dd class="font-extrabold text-end">{{ $value }}</dd></div>
                        @endif
                    @endforeach
                </dl>
            </div>

            <div x-show="tab==='care'" x-cloak>
                @if ($product->care)
                    <ul class="space-y-2">
                        @foreach (preg_split('/\r\n|\r|\n/', $product->care) as $line)
                            @if (trim($line))<li class="flex items-start gap-3"><x-heroicon-s-check-circle class="w-6 h-6 text-brand-green shrink-0 mt-1"/>{{ $line }}</li>@endif
                        @endforeach
                    </ul>
                @else <p>لا توجد تعليمات عناية لهذا المنتج.</p> @endif
            </div>

            <div x-show="tab==='ship'" x-cloak class="space-y-3">
                <p class="flex items-start gap-3"><x-heroicon-o-truck class="w-7 h-7 text-brand-blue shrink-0"/>الشحن لجميع محافظات مصر خلال 2 – 4 أيام عمل بتكلفة {{ config('snefro.shipping_cost') }} {{ config('snefro.currency') }}، ومجاناً للطلبات فوق {{ number_format(config('snefro.free_shipping_over')) }} {{ config('snefro.currency') }}.</p>
                <p class="flex items-start gap-3"><x-heroicon-o-banknotes class="w-7 h-7 text-brand-green shrink-0"/>الدفع عند الاستلام، افحص المنتج قبل الدفع.</p>
                <p class="flex items-start gap-3"><x-heroicon-o-arrow-path class="w-7 h-7 text-brand-orange shrink-0"/>يمكن الاستبدال أو الاسترجاع خلال 14 يوماً بشرط أن يكون المنتج بحالته الأصلية.</p>
            </div>
        </div>
    </section>

    {{-- Related --}}
    @if ($related->isNotEmpty())
        <section class="mt-16">
            <h2 class="text-2xl font-black mb-6 flex items-center gap-3"><x-heroicon-s-heart class="w-8 h-8 text-brand-red"/>منتجات قد تعجبك</h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach ($related as $p) <x-product-card :product="$p" wire:key="rel-{{ $p->id }}" /> @endforeach
            </div>
        </section>
    @endif
</div>
