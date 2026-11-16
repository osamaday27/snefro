<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @include('partials.head')
    <title>{{ isset($title) ? $title.' | ' : '' }}{{ config('snefro.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.js"></script>
    @livewireStyles
</head>
<body class="bg-brand-cream text-brand-ink antialiased min-h-screen flex flex-col" x-data="{ menu: false }">

    {{-- Top bar --}}
    <div class="bg-brand-ink text-white text-xs sm:text-sm">
        <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between gap-4">
            <p class="flex items-center gap-2"><x-heroicon-o-truck class="w-5 h-5 text-brand-yellow"/>شحن مجاني للطلبات فوق {{ number_format(config('snefro.free_shipping_over')) }} {{ config('snefro.currency') }}</p>
            <div class="hidden sm:flex items-center gap-5">
                <a href="tel:+{{ config('snefro.whatsapp') }}" class="flex items-center gap-1.5 hover:text-brand-yellow"><x-heroicon-o-phone class="w-5 h-5"/><span dir="ltr">{{ config('snefro.phone_display') }}</span></a>
                <a href="mailto:{{ config('snefro.email') }}" class="flex items-center gap-1.5 hover:text-brand-yellow"><x-heroicon-o-envelope class="w-5 h-5"/>{{ config('snefro.email') }}</a>
            </div>
        </div>
    </div>

    {{-- Header --}}
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" wire:navigate class="shrink-0" aria-label="سنفرو للأطفال">
                <img src="{{ asset('images/logo.png') }}" alt="Snefro For Kids" class="h-14 md:h-16 w-auto mix-blend-multiply">
            </a>

            <nav class="hidden md:flex items-center gap-2 font-bold">
                @foreach ([
                    ['home', 'الرئيسية', 'home', route('home')],
                    ['shop', 'المتجر', 'shopping-bag', route('shop')],
                ] as [$r, $label, $icon, $url])
                    <a href="{{ $url }}" wire:navigate
                       class="flex items-center gap-2 px-4 py-2 rounded-2xl hover:bg-brand-sky {{ request()->routeIs($r) ? 'bg-brand-sky text-brand-blue' : '' }}">
                        @svg('heroicon-o-'.$icon, 'w-6 h-6'){{ $label }}
                    </a>
                @endforeach
                <a href="{{ route('home') }}#categories" class="flex items-center gap-2 px-4 py-2 rounded-2xl hover:bg-brand-sky"><x-heroicon-o-squares-2x2 class="w-6 h-6"/>الأقسام</a>
                <a href="#contact" class="flex items-center gap-2 px-4 py-2 rounded-2xl hover:bg-brand-sky"><x-heroicon-o-phone class="w-6 h-6"/>تواصل معنا</a>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('shop') }}" wire:navigate class="h-12 w-12 rounded-2xl bg-brand-sky text-brand-blue flex items-center justify-center hover:bg-brand-blue hover:text-white transition" aria-label="بحث">
                    <x-heroicon-o-magnifying-glass class="w-7 h-7"/>
                </a>
                <livewire:cart-counter />
                <button class="md:hidden h-12 w-12 rounded-2xl bg-brand-sky text-brand-ink flex items-center justify-center" @click="menu = !menu" aria-label="القائمة">
                    <x-heroicon-o-bars-3 class="w-7 h-7" x-show="!menu"/><x-heroicon-o-x-mark class="w-7 h-7" x-show="menu" x-cloak/>
                </button>
            </div>
        </div>

        <div x-cloak x-show="menu" x-transition class="md:hidden border-t border-slate-100 bg-white px-4 py-3 grid gap-1 font-bold">
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3 px-3 py-3 rounded-2xl hover:bg-brand-sky"><x-heroicon-o-home class="w-7 h-7 text-brand-blue"/>الرئيسية</a>
            <a href="{{ route('shop') }}" wire:navigate class="flex items-center gap-3 px-3 py-3 rounded-2xl hover:bg-brand-sky"><x-heroicon-o-shopping-bag class="w-7 h-7 text-brand-orange"/>المتجر</a>
            <a href="{{ route('home') }}#categories" @click="menu=false" class="flex items-center gap-3 px-3 py-3 rounded-2xl hover:bg-brand-sky"><x-heroicon-o-squares-2x2 class="w-7 h-7 text-brand-green"/>الأقسام</a>
            <a href="#contact" @click="menu=false" class="flex items-center gap-3 px-3 py-3 rounded-2xl hover:bg-brand-sky"><x-heroicon-o-phone class="w-7 h-7 text-brand-purple"/>تواصل معنا</a>
        </div>
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer id="contact" class="bg-brand-sky mt-20 border-t border-sky-100">
        <div class="max-w-7xl mx-auto px-4 py-14 grid gap-10 md:grid-cols-3">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Snefro For Kids" class="h-20 w-auto mix-blend-multiply">
                <p class="mt-4 text-slate-600 leading-relaxed">سنفرو للأطفال.. ملابس وألعاب ومستلزمات بخامات آمنة وألوان مبهجة، بتوصلك لحد باب البيت وتدفع عند الاستلام.</p>
            </div>

            <div>
                <h4 class="font-extrabold text-lg mb-4">روابط سريعة</h4>
                <ul class="space-y-3 font-semibold text-slate-600">
                    <li><a class="flex items-center gap-2 hover:text-brand-blue" href="{{ route('home') }}" wire:navigate><x-heroicon-o-chevron-left class="w-4 h-4"/>الرئيسية</a></li>
                    <li><a class="flex items-center gap-2 hover:text-brand-blue" href="{{ route('shop') }}" wire:navigate><x-heroicon-o-chevron-left class="w-4 h-4"/>المتجر</a></li>
                    <li><a class="flex items-center gap-2 hover:text-brand-blue" href="{{ route('cart') }}" wire:navigate><x-heroicon-o-chevron-left class="w-4 h-4"/>سلة المشتريات</a></li>
                    <li><a class="flex items-center gap-2 hover:text-brand-blue" href="{{ route('login') }}"><x-heroicon-o-chevron-left class="w-4 h-4"/>دخول الإدارة</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-extrabold text-lg mb-4">تواصل معنا</h4>
                <ul class="space-y-4 text-slate-700 font-semibold">
                    <li><a href="tel:+{{ config('snefro.whatsapp') }}" class="flex items-center gap-3 hover:text-brand-blue">
                        <span class="h-11 w-11 rounded-2xl bg-white shadow flex items-center justify-center text-brand-blue"><x-heroicon-o-phone class="w-6 h-6"/></span>
                        <span dir="ltr">{{ config('snefro.phone_display') }}</span></a></li>
                    <li><a href="https://wa.me/{{ config('snefro.whatsapp') }}" target="_blank" class="flex items-center gap-3 hover:text-green-600">
                        <span class="h-11 w-11 rounded-2xl bg-white shadow flex items-center justify-center text-[#25D366]"><x-whatsapp-icon class="w-6 h-6"/></span>
                        راسلنا على واتساب</a></li>
                    <li><a href="mailto:{{ config('snefro.email') }}" class="flex items-center gap-3 hover:text-brand-blue">
                        <span class="h-11 w-11 rounded-2xl bg-white shadow flex items-center justify-center text-brand-red"><x-heroicon-o-envelope class="w-6 h-6"/></span>
                        {{ config('snefro.email') }}</a></li>
                    <li class="flex items-center gap-3">
                        <span class="h-11 w-11 rounded-2xl bg-white shadow flex items-center justify-center text-brand-orange"><x-heroicon-o-map-pin class="w-6 h-6"/></span>
                        {{ config('snefro.address') }}</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-sky-100 text-center text-sm text-slate-500 py-5">© {{ date('Y') }} سنفرو للأطفال. جميع الحقوق محفوظة.</div>
    </footer>

    <x-whatsapp-float />

    @livewireScripts
    @include('partials.toast')
</body>
</html>
