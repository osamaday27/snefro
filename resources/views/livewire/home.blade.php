@php
    $dir = app()->getLocale() === 'ar' ? 'rtl' : 'ltr';
    // [الصورة, الشارة, العنوان, الوصف, الرابط, نص الزر]
    $slides = [
        [asset('images/1.jpg'), __('New collection'), __('Soft, safe clothing for every day'), __('Modern pieces in gentle fabrics, made for play and made to last.'), route('shop'), __('Shop now')],
        [asset('images/2.jpg'), __('Toys & gifts'), __('Toys that spark imagination'), __('Thoughtful picks that grow skills and bring hours of fun.'), route('shop', ['category' => 'toys']), __('Discover toys')],
        [asset('images/3.jpg'), __('Newborn'), __('Everything for your little one'), __('Delicate cotton clothing and essentials, kind to newborn skin.'), route('shop', ['category' => 'baby']), __('Shop newborn')],
    ];
    $marquee = [__('Free shipping over :amount EGP', ['amount' => number_format(config('snefro.free_shipping_over'))]), __('Cash on delivery'), __('Safe materials for kids'), __('Easy exchange & returns'), __('Delivery across Egypt')];
@endphp

<div>
    {{-- ===== Hero ===== --}}
    <section class="relative w-full" wire:ignore>
        <div class="swiper hero-swiper" dir="{{ $dir }}" x-data
             @mousemove="const r = $el.getBoundingClientRect(); $el.style.setProperty('--mx', ((event.clientX - r.left) / r.width - .5) * 2); $el.style.setProperty('--my', ((event.clientY - r.top) / r.height - .5) * 2)"
             x-init="new Swiper($el, {
                loop: true, speed: 1200, effect: 'fade', fadeEffect: { crossFade: true },
                autoplay: { delay: 6500, disableOnInteraction: false },
                pagination: { el: $el.querySelector('.swiper-pagination'), clickable: true },
                navigation: { nextEl: $el.querySelector('.hero-next'), prevEl: $el.querySelector('.hero-prev') },
                on: { autoplayTimeLeft(s, t, p) { $el.style.setProperty('--p', 1 - p) } },
             })">
            <div class="swiper-wrapper">
                @foreach ($slides as $n => [$img, $tag, $title, $text, $url, $cta])
                    <div class="swiper-slide relative overflow-hidden h-[540px] sm:h-[600px] lg:h-[700px] bg-brand-mist">
                        <div class="hero-par absolute -inset-6">
                            <img src="{{ $img }}" alt="{{ $title }}" onerror="this.style.display='none'" class="hero-img h-full w-full object-cover">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>

                        <div class="absolute inset-0 flex items-center">
                            <div class="max-w-7xl mx-auto w-full px-4 md:px-8">
                                <div class="hero-panel bg-white p-7 md:p-12 w-full max-w-[30rem] shadow-2xl">
                                    <span class="hero-in flex items-center gap-3 text-xs font-semibold uppercase tracking-[.22em] text-brand-rose" style="--i:0">
                                        <span class="h-0.5 w-10 bg-brand-pink"></span>{{ $tag }}
                                    </span>
                                    <h1 class="hero-in mt-5 text-3xl md:text-5xl font-bold leading-[1.15]" style="--i:1">{{ $title }}</h1>
                                    <p class="hero-in mt-5 text-neutral-600 leading-relaxed" style="--i:2">{{ $text }}</p>
                                    <div class="hero-in mt-8 flex flex-wrap gap-3" style="--i:3">
                                        <a href="{{ $url }}" class="group inline-flex items-center gap-3 bg-brand-ink text-white font-semibold px-7 py-4 hover:bg-brand-rose transition">
                                            {{ $cta }}<x-heroicon-o-arrow-long-right class="w-6 h-6 rtl:rotate-180 transition-transform duration-300 group-hover:translate-x-1.5 rtl:group-hover:-translate-x-1.5"/>
                                        </a>
                                        <a href="https://wa.me/{{ config('snefro.whatsapp') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-3 border border-brand-ink font-semibold px-6 py-4 hover:bg-brand-pink hover:border-brand-pink transition">
                                            <x-whatsapp-icon class="w-6 h-6"/>{{ __('WhatsApp') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="hero-prev hidden md:flex absolute top-1/2 -translate-y-1/2 end-6 z-10 h-14 w-14 bg-white border border-brand-line items-center justify-center hover:bg-brand-ink hover:text-white transition" aria-label="Prev"><x-heroicon-o-chevron-right class="w-7 h-7 ltr:rotate-180"/></button>
            <button class="hero-next hidden md:flex absolute top-1/2 -translate-y-1/2 start-6 z-10 h-14 w-14 bg-white border border-brand-line items-center justify-center hover:bg-brand-ink hover:text-white transition" aria-label="Next"><x-heroicon-o-chevron-left class="w-7 h-7 ltr:rotate-180"/></button>

            <div class="swiper-pagination !bottom-8"></div>
            <div class="absolute bottom-0 inset-x-0 h-[3px] bg-white/30 z-10"><div class="h-full bg-brand-pink" style="width: calc(var(--p, 0) * 100%)"></div></div>
            <div class="hidden lg:flex absolute bottom-6 end-8 z-10 flex-col items-center gap-2 text-white text-[11px] uppercase tracking-[.25em]">
                <span>{{ __('Scroll') }}</span><span class="block h-10 w-px bg-white animate-scrollline"></span>
            </div>
        </div>
    </section>

    {{-- ===== Marquee ===== --}}
    <section class="bg-brand-ink text-white overflow-hidden marquee">
        <div class="marquee-track py-4">
            @for ($k = 0; $k < 2; $k++)
                @for ($j = 0; $j < 3; $j++)
                    @foreach ($marquee as $t)
                        <span class="flex items-center gap-8 pe-8 text-sm font-medium whitespace-nowrap"><span>{{ $t }}</span><span class="h-2 w-2 bg-brand-pink"></span></span>
                    @endforeach
                @endfor
            @endfor
        </div>
    </section>

    {{-- ===== Features ===== --}}
    <section class="max-w-7xl mx-auto px-4 mt-16">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-px bg-brand-line border border-brand-line">
            @foreach ([
                ['truck', __('Delivery across Egypt'), __('Fast delivery to your door')],
                ['banknotes', __('Cash on delivery'), __('Pay after you receive and check')],
                ['arrow-path', __('Easy exchange & returns'), __('A simple, no-hassle policy')],
                ['shield-check', __('Safe materials for kids'), __('Gentle on sensitive skin')],
            ] as $i => [$icon, $t, $d])
                <div data-reveal style="--d: {{ $i * 90 }}ms" class="group bg-white p-6 md:p-8 hover:bg-brand-blush transition duration-300">
                    <span class="block text-brand-ink transition-transform duration-300 group-hover:-translate-y-1.5">@svg('heroicon-o-'.$icon, 'w-11 h-11')</span>
                    <h3 class="mt-5 font-bold">{{ $t }}</h3>
                    <p class="text-sm text-neutral-500 mt-1">{{ $d }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ===== Categories (images) ===== --}}
    <section id="categories" class="max-w-7xl mx-auto px-4 mt-24 scroll-mt-28">
        <div data-reveal class="mb-10">
            <span class="text-xs font-semibold uppercase tracking-[.22em] text-brand-rose">{{ __('Shop by category') }}</span>
            <h2 class="text-3xl md:text-4xl font-bold mt-2">{{ __('Our categories') }}</h2>
            <span class="title-line mt-4"></span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
            @forelse ($categories as $i => $c)
                <a href="{{ route('shop', ['category' => $c->slug]) }}" wire:navigate wire:key="cat-{{ $c->id }}" data-reveal style="--d: {{ $i * 80 }}ms" class="group block relative overflow-hidden aspect-[3/4] bg-brand-mist">
                    <img src="{{ $c->image_url }}" alt="{{ $c->tr('name') }}" loading="lazy"
                         onerror="this.onerror=null;this.src='https://placehold.co/600x800/F6F6F6/111111?text=Snefro'"
                         class="absolute inset-0 h-full w-full object-cover transition duration-[900ms] group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-transparent to-transparent opacity-70 group-hover:opacity-100 transition"></div>
                    <div class="absolute inset-x-0 bottom-0 bg-white m-2 md:m-3 px-4 py-3 flex items-center justify-between gap-2 translate-y-1 group-hover:translate-y-0 group-hover:bg-brand-pink transition duration-300">
                        <div class="min-w-0">
                            <h3 class="font-bold text-sm md:text-base truncate">{{ $c->tr('name') }}</h3>
                            <p class="text-xs text-neutral-500 group-hover:text-brand-ink">{{ $c->products_count }} {{ __('products') }}</p>
                        </div>
                        <x-heroicon-o-arrow-long-right class="w-6 h-6 shrink-0 rtl:rotate-180 transition-transform duration-300 group-hover:translate-x-1 rtl:group-hover:-translate-x-1"/>
                    </div>
                </a>
            @empty
                <p class="text-neutral-500 col-span-full text-center">{{ __('No categories yet.') }}</p>
            @endforelse
        </div>
    </section>

    {{-- ===== Featured ===== --}}
    @if ($featured->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 mt-24">
            <div data-reveal class="flex items-end justify-between gap-4 mb-10">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-[.22em] text-brand-rose">{{ __('Best picks') }}</span>
                    <h2 class="text-3xl md:text-4xl font-bold mt-2">{{ __('Featured products') }}</h2>
                    <span class="title-line mt-4"></span>
                </div>
                <a href="{{ route('shop') }}" wire:navigate class="group hidden sm:inline-flex items-center gap-2 font-semibold border-b-2 border-brand-pink pb-1">{{ __('View all') }}<x-heroicon-o-arrow-long-right class="w-6 h-6 rtl:rotate-180 transition-transform group-hover:translate-x-1 rtl:group-hover:-translate-x-1"/></a>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-3 md:gap-x-5 gap-y-10">
                @foreach ($featured as $i => $p) <x-product-card :product="$p" data-reveal style="--d: {{ $i * 90 }}ms" wire:key="f-{{ $p->id }}" /> @endforeach
            </div>
        </section>
    @endif

    {{-- ===== Boys / Girls ===== --}}
    <section class="max-w-7xl mx-auto px-4 mt-24 grid md:grid-cols-2 gap-4">
        @foreach ([
            ['boys', __('For boys'), __('Sporty, modern, comfortable'), 'https://loremflickr.com/900/600/boy,kids,fashion?lock=21'],
            ['girls', __('For girls'), __('Soft, playful, pretty'), 'https://loremflickr.com/900/600/girl,kids,fashion?lock=22'],
        ] as $i => [$g, $t, $d, $img])
            <a href="{{ route('shop', ['gender' => $g]) }}" wire:navigate data-reveal="{{ $i ? 'right' : 'left' }}" class="group relative block overflow-hidden aspect-[16/10] bg-brand-mist">
                <img src="{{ $img }}" alt="{{ $t }}" loading="lazy" onerror="this.style.display='none'" class="absolute inset-0 h-full w-full object-cover transition duration-[900ms] group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                <div class="absolute bottom-0 start-0 bg-white p-6 md:p-8 m-3 md:m-5 group-hover:bg-brand-pink transition duration-300">
                    <h3 class="text-2xl font-bold">{{ $t }}</h3>
                    <p class="text-sm text-neutral-600 mt-1 group-hover:text-brand-ink">{{ $d }}</p>
                    <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold">{{ __('Shop now') }}<x-heroicon-o-arrow-long-right class="w-5 h-5 rtl:rotate-180 transition-transform duration-300 group-hover:translate-x-1.5 rtl:group-hover:-translate-x-1.5"/></span>
                </div>
            </a>
        @endforeach
    </section>

    {{-- ===== Latest ===== --}}
    <section class="max-w-7xl mx-auto px-4 mt-24">
        <div data-reveal class="flex items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-semibold uppercase tracking-[.22em] text-brand-rose">{{ __('New arrivals') }}</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2">{{ __('Latest products') }}</h2>
                <span class="title-line mt-4"></span>
            </div>
            <a href="{{ route('shop') }}" wire:navigate class="group inline-flex items-center gap-2 font-semibold border-b-2 border-brand-pink pb-1">{{ __('View all') }}<x-heroicon-o-arrow-long-right class="w-6 h-6 rtl:rotate-180 transition-transform group-hover:translate-x-1 rtl:group-hover:-translate-x-1"/></a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-3 md:gap-x-5 gap-y-10">
            @forelse ($latest as $i => $p) <x-product-card :product="$p" data-reveal style="--d: {{ ($i % 4) * 90 }}ms" wire:key="l-{{ $p->id }}" />
            @empty <p class="text-neutral-500 col-span-full text-center py-10">{{ __('No products yet.') }}</p> @endforelse
        </div>
    </section>

    {{-- ===== Contact ===== --}}
    <section class="max-w-7xl mx-auto px-4 mt-24">
        <div data-reveal class="mb-10">
            <span class="text-xs font-semibold uppercase tracking-[.22em] text-brand-rose">{{ __('We are happy to help') }}</span>
            <h2 class="text-3xl md:text-4xl font-bold mt-2">{{ __('Contact us') }}</h2>
            <span class="title-line mt-4"></span>
        </div>
        <div class="grid lg:grid-cols-2 gap-4">
            <div class="grid sm:grid-cols-2 gap-4 content-start">
                <a data-reveal href="https://wa.me/{{ config('snefro.whatsapp') }}" target="_blank" class="group sm:col-span-2 bg-brand-ink text-white p-6 flex items-center gap-5 hover:bg-[#25D366] transition duration-300">
                    <x-whatsapp-icon class="w-12 h-12 shrink-0"/>
                    <div><p class="font-bold text-lg">{{ __('Message us on WhatsApp') }}</p><p class="text-white/70 text-sm mt-1" dir="ltr">{{ config('snefro.phone_display') }}</p></div>
                </a>
                <a data-reveal style="--d:90ms" href="tel:+{{ config('snefro.whatsapp') }}" class="group border border-brand-line p-6 hover:bg-brand-blush transition">
                    <x-heroicon-o-phone class="w-9 h-9 transition-transform duration-300 group-hover:-translate-y-1"/>
                    <p class="font-bold mt-4">{{ __('Call us') }}</p><p class="text-neutral-500 text-sm mt-1" dir="ltr">{{ config('snefro.phone_display') }}</p>
                </a>
                <a data-reveal style="--d:180ms" href="mailto:{{ config('snefro.email') }}" class="group border border-brand-line p-6 hover:bg-brand-blush transition">
                    <x-heroicon-o-envelope class="w-9 h-9 transition-transform duration-300 group-hover:-translate-y-1"/>
                    <p class="font-bold mt-4">{{ __('Email') }}</p><p class="text-neutral-500 text-sm mt-1 break-all">{{ config('snefro.email') }}</p>
                </a>
                <div data-reveal style="--d:270ms" class="sm:col-span-2 border border-brand-line p-6 flex items-center gap-4">
                    <x-heroicon-o-map-pin class="w-9 h-9 shrink-0"/>
                    <div><p class="font-bold">{{ __('Our address') }}</p><p class="text-neutral-500 text-sm mt-1">{{ config('snefro.address.'.app()->getLocale()) }}</p></div>
                </div>
            </div>
            <div data-reveal="fade" class="border border-brand-line min-h-80 bg-brand-mist">
                <iframe title="Map" class="w-full h-full min-h-80 grayscale hover:grayscale-0 transition duration-500" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps?q={{ urlencode(config('snefro.map_query')) }}&output=embed"></iframe>
            </div>
        </div>
    </section>
</div>
