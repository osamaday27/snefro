<div>
    {{-- ===== Hero slider (Swiper) ===== --}}
    @php
        $slides = [
            ['from-sky-100 via-white to-yellow-100', 'bg-brand-blue', 'مجموعة جديدة', 'ألوان وفرحة لكل يوم', 'أحدث ملابس الأطفال بخامات ناعمة وآمنة تناسب لعبهم وحركتهم طوال اليوم.', route('shop'), 'تسوّق الآن', 'https://loremflickr.com/800/800/happy,kids,playing?lock=11'],
            ['from-pink-100 via-white to-purple-100', 'bg-brand-purple', 'ألعاب وهدايا', 'عالم من المرح والخيال', 'ألعاب تعليمية وتركيب تنمّي مهارات طفلك وتمنحه ساعات من المتعة.', route('shop', ['category' => 'toys']), 'اكتشف الألعاب', 'https://loremflickr.com/800/800/toys,children?lock=12'],
            ['from-green-100 via-white to-yellow-100', 'bg-brand-green', 'للمواليد', 'كل ما يحتاجه مولودك', 'ملابس وبطاطين ومستلزمات بخامات قطنية عضوية رقيقة على البشرة.', route('shop', ['category' => 'baby']), 'تسوّق المواليد', 'https://loremflickr.com/800/800/baby,smile?lock=13'],
        ];
    @endphp
   @php
    // [الصورة, الشارة, العنوان, الوصف, رابط الزر, نص الزر]
    $slides = [
        [asset('images/1.webp'), 'مجموعة جديدة',  'ملابس أطفال بخامات ناعمة وآمنة', 'تشكيلة عصرية تناسب لعبهم وحركتهم طوال اليوم.',        route('shop'),                           'تسوّق الآن'],
        [asset('images/2.webp'), 'ألعاب وهدايا',   'ألعاب تنمّي الخيال والمهارات',   'اختيارات مميزة بجودة عالية وأسعار مناسبة.',            route('shop', ['category' => 'toys']),   'اكتشف الألعاب'],
        [asset('images/3.webp'), 'للمواليد',        'كل ما يحتاجه مولودك',            'ملابس ومستلزمات قطنية رقيقة على البشرة.',               route('shop', ['category' => 'baby']),   'تسوّق المواليد'],
    ];
@endphp

<style>
    .hero-swiper { --swiper-pagination-color:#fff; --swiper-pagination-bullet-inactive-color:#fff; --swiper-pagination-bullet-inactive-opacity:.45; --swiper-pagination-bullet-size:9px; }
    .hero-swiper .swiper-pagination-bullet-active { width: 28px; border-radius: 9999px; }
    @keyframes heroIn { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }
    .hero-swiper .swiper-slide-active .hero-in { animation: heroIn .8s ease-out both; }
    .hero-swiper .swiper-slide-active .hero-in:nth-child(2) { animation-delay: .1s; }
    .hero-swiper .swiper-slide-active .hero-in:nth-child(3) { animation-delay: .2s; }
    .hero-swiper .swiper-slide-active .hero-in:nth-child(4) { animation-delay: .3s; }
</style>

<section class="relative w-full" wire:ignore>
    <div class="swiper hero-swiper" dir="rtl" x-data x-init="new Swiper($el, {
            loop: true, speed: 900, effect: 'fade', fadeEffect: { crossFade: true },
            autoplay: { delay: 5500, disableOnInteraction: false },
            pagination: { el: $el.querySelector('.swiper-pagination'), clickable: true },
            navigation: { nextEl: $el.querySelector('.hero-next'), prevEl: $el.querySelector('.hero-prev') },
        })">
        <div class="swiper-wrapper">
            @foreach ($slides as $i => [$img, $tag, $title, $text, $url, $cta])
                <div class="swiper-slide relative h-[440px] sm:h-[520px] lg:h-[640px] bg-brand-ink">
                    {{-- الصورة بعرض الصفحة كاملة --}}
                    <img src="{{ $img }}" alt="{{ $title }}" @if($i > 0) loading="lazy" @endif
                         onerror="this.style.display='none'"
                         class="absolute inset-0 h-full w-full object-cover">
                    {{-- طبقة تظليل لوضوح النص --}}
                    <div class="absolute inset-0 bg-gradient-to-l from-black/75 via-black/40 to-black/5"></div>

                    <div class="relative h-full max-w-7xl mx-auto px-6 md:px-10 flex items-center">
                        <div class="max-w-xl text-white">
                            <span class="hero-in flex items-center gap-3 text-sm font-semibold tracking-wide text-white/80">
                                <span class="h-px w-10 bg-white/70"></span>{{ $tag }}
                            </span>
                            <h1 class="hero-in mt-4 text-3xl sm:text-4xl lg:text-6xl font-black leading-tight">{{ $title }}</h1>
                            <p class="hero-in mt-4 text-base sm:text-lg text-white/80 leading-relaxed">{{ $text }}</p>
                            <div class="hero-in mt-8 flex flex-wrap gap-3">
                                <a href="{{ $url }}" class="inline-flex items-center gap-3 bg-brand-blue hover:bg-sky-600 text-white font-bold px-7 py-3.5 rounded-xl transition">
                                    <x-heroicon-o-shopping-bag class="w-6 h-6"/>{{ $cta }}
                                </a>
                                <a href="https://wa.me/{{ config('snefro.whatsapp') }}" target="_blank" rel="noopener"
                                   class="inline-flex items-center gap-3 border border-white/60 text-white hover:bg-white hover:text-brand-ink font-bold px-7 py-3.5 rounded-xl transition">
                                    <x-whatsapp-icon class="w-6 h-6"/>اطلب عبر واتساب
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="hero-prev hidden md:flex absolute top-1/2 -translate-y-1/2 end-6 z-10 h-12 w-12 rounded-full border border-white/40 bg-white/10 backdrop-blur text-white items-center justify-center hover:bg-white hover:text-brand-ink transition" aria-label="السابق">
            <x-heroicon-o-chevron-right class="w-6 h-6"/>
        </button>
        <button class="hero-next hidden md:flex absolute top-1/2 -translate-y-1/2 start-6 z-10 h-12 w-12 rounded-full border border-white/40 bg-white/10 backdrop-blur text-white items-center justify-center hover:bg-white hover:text-brand-ink transition" aria-label="التالي">
            <x-heroicon-o-chevron-left class="w-6 h-6"/>
        </button>
        <div class="swiper-pagination !bottom-5"></div>
    </div>
    </section>
<section style="height: 30px;"></section>

</section>
    {{-- ===== Features ===== --}}
    <section class="max-w-7xl mx-auto px-4 -mt-0 md:-mt-10 relative z-10 pt-8 md:pt-0">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ([
                ['truck', 'شحن لكل المحافظات', 'توصيل سريع حتى باب البيت', 'bg-brand-blue'],
                ['banknotes', 'الدفع عند الاستلام', 'ادفع بعد ما تستلم وتجرّب', 'bg-brand-green'],
                ['arrow-path', 'استبدال واسترجاع', 'سياسة سهلة وبدون تعقيد', 'bg-brand-orange'],
                ['shield-check', 'خامات آمنة', 'مناسبة لبشرة الأطفال الحساسة', 'bg-brand-purple'],
            ] as [$icon, $t, $d, $bg])
                <div class="bg-white rounded-3xl p-5 shadow-lg flex flex-col md:flex-row items-center md:items-start gap-4 text-center md:text-start hover:-translate-y-1 transition">
                    <span class="shrink-0 h-16 w-16 rounded-2xl {{ $bg }} text-white flex items-center justify-center shadow-lg">
                        @svg('heroicon-o-'.$icon, 'w-9 h-9')
                    </span>
                    <div><h3 class="font-extrabold">{{ $t }}</h3><p class="text-sm text-slate-500 mt-1">{{ $d }}</p></div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ===== Categories (images) ===== --}}
    <section id="categories" class="max-w-7xl mx-auto px-4 mt-20 scroll-mt-28">
        <div class="text-center mb-10">
            <span class="inline-flex items-center gap-2 text-brand-blue font-bold"><x-heroicon-s-squares-2x2 class="w-6 h-6"/>تسوّق حسب القسم</span>
            <h2 class="text-3xl md:text-4xl font-black mt-2">أقسام سنفرو</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @forelse ($categories as $i => $c)
                @php $ring = ['ring-brand-blue','ring-brand-red','ring-brand-green','ring-brand-orange','ring-brand-purple','ring-brand-yellow'][$i % 6]; @endphp
                <a href="{{ route('shop', ['category' => $c->slug]) }}" wire:navigate wire:key="cat-{{ $c->id }}" class="group text-center">
                    <div class="relative aspect-square rounded-[2rem] overflow-hidden ring-4 {{ $ring }} ring-offset-4 ring-offset-brand-cream shadow-lg">
                        <img src="{{ $c->image_url }}" alt="{{ $c->name }}" loading="lazy"
                             onerror="this.onerror=null;this.src='https://placehold.co/600x600/fde68a/1f2a44?text={{ urlencode($c->name) }}'"
                             class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                        <span class="absolute bottom-3 inset-x-0 mx-auto w-fit bg-white/90 text-brand-ink text-xs font-bold px-3 py-1 rounded-full opacity-0 group-hover:opacity-100 transition">
                            {{ $c->products_count }} منتج
                        </span>
                    </div>
                    <h3 class="mt-4 font-extrabold group-hover:text-brand-blue transition">{{ $c->name }}</h3>
                </a>
            @empty
                <p class="text-slate-500 col-span-full text-center">لا توجد أقسام بعد.</p>
            @endforelse
        </div>
    </section>

    {{-- ===== Featured ===== --}}
    @if ($featured->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 mt-20">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="inline-flex items-center gap-2 text-brand-orange font-bold"><x-heroicon-s-fire class="w-6 h-6"/>الأكثر طلباً</span>
                    <h2 class="text-3xl font-black mt-1">منتجات مميزة</h2>
                </div>
                <a href="{{ route('shop') }}" wire:navigate class="hidden sm:inline-flex items-center gap-2 font-bold text-brand-blue hover:gap-3 transition-all">عرض الكل<x-heroicon-o-arrow-left class="w-5 h-5"/></a>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach ($featured as $p) <x-product-card :product="$p" wire:key="f-{{ $p->id }}" /> @endforeach
            </div>
        </section>
    @endif

    {{-- ===== Boys / Girls banners ===== --}}
    <section class="max-w-7xl mx-auto px-4 mt-20 grid md:grid-cols-2 gap-6">
        @foreach ([
            ['boys', 'للأولاد', 'ستايل رياضي وعصري', 'from-brand-blue to-sky-400', 'https://loremflickr.com/700/500/boy,kids,fashion?lock=21'],
            ['girls', 'للبنات', 'فساتين وأطقم بألوان حلوة', 'from-pink-400 to-brand-purple', 'https://loremflickr.com/700/500/girl,kids,fashion?lock=22'],
        ] as [$g, $t, $d, $grad, $img])
            <a href="{{ route('shop', ['gender' => $g]) }}" wire:navigate class="group relative overflow-hidden rounded-[2rem] bg-gradient-to-l {{ $grad }} text-white p-8 min-h-56 flex items-center shadow-xl">
                <img src="{{ $img }}" alt="" loading="lazy" onerror="this.style.display='none'" class="absolute inset-y-0 start-0 h-full w-1/2 object-cover opacity-70 mix-blend-luminosity group-hover:scale-110 transition duration-700">
                <div class="relative max-w-[60%] ms-auto">
                    <h3 class="text-3xl font-black">{{ $t }}</h3>
                    <p class="mt-2 opacity-90">{{ $d }}</p>
                    <span class="mt-5 inline-flex items-center gap-2 bg-white text-brand-ink font-extrabold px-5 py-3 rounded-2xl">تسوّق الآن<x-heroicon-o-arrow-left class="w-5 h-5"/></span>
                </div>
            </a>
        @endforeach
    </section>

    {{-- ===== Latest ===== --}}
    <section class="max-w-7xl mx-auto px-4 mt-20">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="inline-flex items-center gap-2 text-brand-green font-bold"><x-heroicon-s-sparkles class="w-6 h-6"/>وصل حديثاً</span>
                <h2 class="text-3xl font-black mt-1">أحدث المنتجات</h2>
            </div>
            <a href="{{ route('shop') }}" wire:navigate class="inline-flex items-center gap-2 font-bold text-brand-blue hover:gap-3 transition-all">عرض الكل<x-heroicon-o-arrow-left class="w-5 h-5"/></a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            @forelse ($latest as $p) <x-product-card :product="$p" wire:key="l-{{ $p->id }}" />
            @empty <p class="text-slate-500 col-span-full text-center py-10">لا توجد منتجات بعد.</p> @endforelse
        </div>
    </section>

    {{-- ===== Contact ===== --}}
    <section class="max-w-7xl mx-auto px-4 mt-24">
        <div class="text-center mb-10">
            <span class="inline-flex items-center gap-2 text-brand-purple font-bold"><x-heroicon-s-chat-bubble-left-right class="w-6 h-6"/>يسعدنا خدمتك</span>
            <h2 class="text-3xl md:text-4xl font-black mt-2">تواصل معنا</h2>
        </div>
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="grid sm:grid-cols-2 gap-4 content-start">
                <a href="https://wa.me/{{ config('snefro.whatsapp') }}" target="_blank" class="bg-[#25D366] text-white rounded-3xl p-6 shadow-xl hover:scale-[1.03] transition sm:col-span-2 flex items-center gap-5">
                    <span class="h-16 w-16 rounded-2xl bg-white/20 flex items-center justify-center"><x-whatsapp-icon class="w-10 h-10"/></span>
                    <div><p class="font-black text-xl">راسلنا على واتساب</p><p class="text-white/90 text-sm mt-1" dir="ltr">{{ config('snefro.phone_display') }}</p></div>
                </a>
                <a href="tel:+{{ config('snefro.whatsapp') }}" class="bg-white rounded-3xl p-6 shadow hover:shadow-xl transition">
                    <span class="h-14 w-14 rounded-2xl bg-sky-100 text-brand-blue flex items-center justify-center"><x-heroicon-o-phone class="w-8 h-8"/></span>
                    <p class="font-extrabold mt-4">اتصل بنا</p><p class="text-slate-500 text-sm mt-1" dir="ltr">{{ config('snefro.phone_display') }}</p>
                </a>
                <a href="mailto:{{ config('snefro.email') }}" class="bg-white rounded-3xl p-6 shadow hover:shadow-xl transition">
                    <span class="h-14 w-14 rounded-2xl bg-red-100 text-brand-red flex items-center justify-center"><x-heroicon-o-envelope class="w-8 h-8"/></span>
                    <p class="font-extrabold mt-4">البريد الإلكتروني</p><p class="text-slate-500 text-sm mt-1 break-all">{{ config('snefro.email') }}</p>
                </a>
                <div class="bg-white rounded-3xl p-6 shadow sm:col-span-2 flex items-center gap-4">
                    <span class="shrink-0 h-14 w-14 rounded-2xl bg-orange-100 text-brand-orange flex items-center justify-center"><x-heroicon-o-map-pin class="w-8 h-8"/></span>
                    <div><p class="font-extrabold">عنوان المتجر</p><p class="text-slate-500 text-sm mt-1">{{ config('snefro.address') }}</p></div>
                </div>
            </div>
            <div class="rounded-3xl overflow-hidden shadow-xl min-h-72 bg-white">
                <iframe title="الموقع" class="w-full h-full min-h-72" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps?q={{ urlencode(config('snefro.map_query')) }}&output=embed"></iframe>
            </div>
        </div>
    </section>
</div>
