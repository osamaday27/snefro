@php $locale = app()->getLocale(); $dir = $locale === 'ar' ? 'rtl' : 'ltr'; @endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    @include('partials.head')
    <title>{{ isset($title) ? $title.' | ' : '' }}{{ config('snefro.name.'.$locale) }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.js"></script>
    @livewireStyles
</head>
<body class="bg-white text-brand-ink min-h-screen flex flex-col" x-data="{ menu: false }">

    {{-- شريط علوي --}}
    <div class="bg-brand-ink text-white text-xs">
        <div class="max-w-7xl mx-auto px-4 h-10 flex items-center justify-between gap-4">
            <p class="flex items-center gap-2"><x-heroicon-o-truck class="w-5 h-5 text-brand-pink"/>{{ __('Free shipping on orders over :amount EGP', ['amount' => number_format(config('snefro.free_shipping_over'))]) }}</p>
            <div class="flex items-center gap-5">
                <a href="tel:+{{ config('snefro.whatsapp') }}" class="hidden sm:flex items-center gap-1.5 hover:text-brand-pink transition"><x-heroicon-o-phone class="w-4 h-4"/><span dir="ltr">{{ config('snefro.phone_display') }}</span></a>
                <a href="{{ route('lang', $locale === 'ar' ? 'en' : 'ar') }}" class="flex items-center gap-1.5 font-semibold hover:text-brand-pink transition">
                    <x-heroicon-o-language class="w-5 h-5"/>{{ $locale === 'ar' ? 'English' : 'العربية' }}
                </a>
            </div>
        </div>
    </div>

    {{-- الهيدر --}}
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-brand-line">
        <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" wire:navigate class="shrink-0" aria-label="{{ config('snefro.name.'.$locale) }}">
                <img src="{{ asset('images/logo.png') }}" alt="Snefro For Kids" class="h-14 w-auto mix-blend-multiply">
            </a>

            <nav class="hidden md:flex items-center gap-9 text-sm font-semibold">
                @foreach ([
                    [route('home'), __('Home'), request()->routeIs('home')],
                    [route('shop'), __('Shop'), request()->routeIs('shop')],
                    [route('home').'#categories', __('Categories'), false],
                    ['#contact', __('Contact us'), false],
                ] as [$url, $label, $active])
                    <a href="{{ $url }}" @if(! str_contains($url, '#')) wire:navigate @endif class="relative py-2 group">
                        {{ $label }}
                        <span class="absolute bottom-0 start-0 h-0.5 bg-brand-pink transition-all duration-300 {{ $active ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('shop') }}" wire:navigate aria-label="{{ __('Search') }}" class="h-12 w-12 border border-brand-line flex items-center justify-center hover:bg-brand-ink hover:text-white hover:border-brand-ink transition">
                    <x-heroicon-o-magnifying-glass class="w-7 h-7"/>
                </a>
                <livewire:cart-counter />
                <button class="md:hidden h-12 w-12 border border-brand-line flex items-center justify-center" @click="menu = !menu" aria-label="{{ __('Menu') }}">
                    <x-heroicon-o-bars-3 class="w-7 h-7" x-show="!menu"/><x-heroicon-o-x-mark class="w-7 h-7" x-show="menu" x-cloak/>
                </button>
            </div>
        </div>

        <div x-cloak x-show="menu" x-transition class="md:hidden border-t border-brand-line bg-white px-4 py-2 font-semibold">
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3 py-4 border-b border-brand-line"><x-heroicon-o-home class="w-6 h-6"/>{{ __('Home') }}</a>
            <a href="{{ route('shop') }}" wire:navigate class="flex items-center gap-3 py-4 border-b border-brand-line"><x-heroicon-o-shopping-bag class="w-6 h-6"/>{{ __('Shop') }}</a>
            <a href="{{ route('home') }}#categories" @click="menu=false" class="flex items-center gap-3 py-4 border-b border-brand-line"><x-heroicon-o-squares-2x2 class="w-6 h-6"/>{{ __('Categories') }}</a>
            <a href="#contact" @click="menu=false" class="flex items-center gap-3 py-4"><x-heroicon-o-phone class="w-6 h-6"/>{{ __('Contact us') }}</a>
        </div>
    </header>

    <main class="flex-1">{{ $slot }}</main>

    {{-- الفوتر --}}
    <footer id="contact" class="bg-brand-mist mt-24 border-t border-brand-line">
        <div class="max-w-7xl mx-auto px-4 py-16 grid gap-12 md:grid-cols-3">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Snefro For Kids" class="h-20 w-auto mix-blend-multiply">
                <p class="mt-5 text-neutral-600 leading-relaxed max-w-sm">{{ __('Clothing, toys and essentials with safe materials and cheerful design, delivered to your door. Pay when you receive.') }}</p>
            </div>

            <div>
                <h4 class="font-bold mb-5 text-sm uppercase tracking-wider">{{ __('Quick links') }}</h4>
                <ul class="space-y-3 text-neutral-600">
                    <li><a class="hover:text-brand-rose transition" href="{{ route('home') }}" wire:navigate>{{ __('Home') }}</a></li>
                    <li><a class="hover:text-brand-rose transition" href="{{ route('shop') }}" wire:navigate>{{ __('Shop') }}</a></li>
                    <li><a class="hover:text-brand-rose transition" href="{{ route('cart') }}" wire:navigate>{{ __('Shopping cart') }}</a></li>
                    <li><a class="hover:text-brand-rose transition" href="{{ route('login') }}">{{ __('Admin login') }}</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-5 text-sm uppercase tracking-wider">{{ __('Contact us') }}</h4>
                <ul class="space-y-4 text-neutral-700">
                    <li><a href="tel:+{{ config('snefro.whatsapp') }}" class="flex items-center gap-3 hover:text-brand-rose transition"><x-heroicon-o-phone class="w-6 h-6"/><span dir="ltr">{{ config('snefro.phone_display') }}</span></a></li>
                    <li><a href="https://wa.me/{{ config('snefro.whatsapp') }}" target="_blank" class="flex items-center gap-3 hover:text-brand-rose transition"><x-whatsapp-icon class="w-6 h-6"/>{{ __('Message us on WhatsApp') }}</a></li>
                    <li><a href="mailto:{{ config('snefro.email') }}" class="flex items-center gap-3 hover:text-brand-rose transition"><x-heroicon-o-envelope class="w-6 h-6"/>{{ config('snefro.email') }}</a></li>
                    <li class="flex items-center gap-3"><x-heroicon-o-map-pin class="w-6 h-6 shrink-0"/>{{ config('snefro.address.'.$locale) }}</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-brand-line text-center text-xs text-neutral-500 py-5">© {{ date('Y') }} {{ config('snefro.name.'.$locale) }}. {{ __('All rights reserved.') }}</div>
    </footer>

    <x-whatsapp-float />

    @livewireScripts
    @include('partials.toast')
</body>
</html>
