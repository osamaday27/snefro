<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @include('partials.head')
    <title>{{ $title ?? 'الإدارة' }} | لوحة سنفرو</title>
    @livewireStyles
</head>
<body class="bg-brand-mist text-brand-ink min-h-screen" x-data="{ side: false }">
@php
    $links = [
        ['admin.dashboard', 'لوحة التحكم', 'chart-bar'],
        ['admin.products', 'المنتجات', 'cube'],
        ['admin.categories', 'الأقسام', 'squares-2x2'],
        ['admin.orders', 'الطلبات', 'clipboard-document-list'],
    ];
@endphp
<div class="flex min-h-screen">
    <aside class="fixed md:sticky md:top-0 md:h-screen inset-y-0 start-0 z-40 w-64 bg-white border-e border-brand-line flex flex-col transform transition md:translate-x-0"
           :class="side ? 'translate-x-0' : 'translate-x-full'">
        <div class="h-20 flex items-center justify-center border-b border-brand-line">
            <img src="{{ asset('images/logo.png') }}" alt="Snefro" class="h-14 w-auto mix-blend-multiply">
        </div>
        <nav class="flex-1 p-4 space-y-1 font-semibold text-sm">
            @foreach ($links as [$route, $label, $icon])
                <a href="{{ route($route) }}" wire:navigate @click="side=false"
                   class="flex items-center gap-3 px-4 py-3 transition {{ request()->routeIs($route) ? 'bg-brand-ink text-white' : 'text-neutral-600 hover:bg-brand-blush' }}">
                    @svg('heroicon-o-'.$icon, 'w-6 h-6'){{ $label }}
                </a>
            @endforeach
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 text-neutral-600 hover:bg-brand-blush">
                <x-heroicon-o-building-storefront class="w-6 h-6"/>عرض المتجر
            </a>
        </nav>
        <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-brand-line">
            @csrf
            <button class="w-full flex items-center gap-3 px-4 py-3 font-semibold text-red-600 hover:bg-red-50 text-sm">
                <x-heroicon-o-lock-closed class="w-6 h-6"/>تسجيل الخروج
            </button>
        </form>
    </aside>
    <div x-show="side" x-cloak @click="side=false" class="fixed inset-0 bg-black/40 z-30 md:hidden"></div>

    <div class="flex-1 min-w-0">
        <div class="md:hidden h-16 bg-white border-b border-brand-line flex items-center px-4 gap-3">
            <button @click="side = !side" class="h-11 w-11 border border-brand-line flex items-center justify-center"><x-heroicon-o-bars-3 class="w-6 h-6"/></button>
            <span class="font-bold">لوحة سنفرو</span>
        </div>
        <main class="p-4 md:p-8">{{ $slot }}</main>
    </div>
</div>
@livewireScripts
@include('partials.toast')
</body>
</html>
