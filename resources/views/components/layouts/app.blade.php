<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' | ' : '' }}Snefro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>[x-cloak]{display:none!important}</style>
    @livewireStyles
</head>
<body class="bg-white text-stone-900 antialiased min-h-screen flex flex-col" x-data="{ menu: false }">

    <div class="bg-stone-900 text-stone-100 text-center text-xs py-2 tracking-wide">
        Cash on delivery available · Fast shipping across Egypt
    </div>

    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-stone-200">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" wire:navigate class="text-2xl font-black tracking-tight">SNEFRO<span class="text-amber-500">.</span></a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="{{ route('home') }}" wire:navigate class="hover:text-amber-600 {{ request()->routeIs('home') ? 'text-amber-600' : '' }}">Home</a>
                <a href="{{ route('shop') }}" wire:navigate class="hover:text-amber-600 {{ request()->routeIs('shop') ? 'text-amber-600' : '' }}">Shop</a>
                <a href="{{ route('shop') }}#categories" class="hover:text-amber-600">Categories</a>
                <a href="#contact" class="hover:text-amber-600">Contact</a>
            </nav>

            <div class="flex items-center gap-4">
                <livewire:cart-counter />
                <button class="md:hidden" @click="menu = !menu" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <div x-cloak x-show="menu" x-transition class="md:hidden border-t border-stone-200 bg-white px-4 py-3 space-y-3 text-sm font-medium">
            <a href="{{ route('home') }}" wire:navigate class="block">Home</a>
            <a href="{{ route('shop') }}" wire:navigate class="block">Shop</a>
            <a href="#contact" class="block">Contact</a>
        </div>
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    <footer id="contact" class="bg-stone-900 text-stone-300 mt-20">
        <div class="max-w-7xl mx-auto px-4 py-12 grid gap-8 md:grid-cols-4">
            <div class="md:col-span-2">
                <div class="text-2xl font-black text-white">SNEFRO<span class="text-amber-500">.</span></div>
                <p class="mt-3 text-sm max-w-sm">Modern everyday fashion with quality you can feel. Order online and pay when you receive.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Quick links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a class="hover:text-white" href="{{ route('shop') }}" wire:navigate>Shop</a></li>
                    <li><a class="hover:text-white" href="{{ route('cart') }}" wire:navigate>Cart</a></li>
                    <li><a class="hover:text-white" href="{{ route('login') }}">Admin</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Contact</h4>
                <ul class="space-y-2 text-sm">
                    <li>📞 +20 100 000 0000</li>
                    <li>✉️ hello@snefro.com</li>
                    <li>📍 Cairo, Egypt</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-stone-800 text-center text-xs py-4">© {{ date('Y') }} Snefro. All rights reserved.</div>
    </footer>

    @livewireScripts
</body>
</html>
