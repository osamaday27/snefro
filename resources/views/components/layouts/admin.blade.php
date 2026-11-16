<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @include('partials.head')
    <title>{{ $title ?? 'الإدارة' }} | لوحة سنفرو</title>
    @livewireStyles
</head>
<body class="bg-slate-100 text-brand-ink min-h-screen" x-data="{ side: false }">
@php
    $links = [
        ['admin.dashboard', 'لوحة التحكم', 'chart-bar'],
        ['admin.products', 'المنتجات', 'cube'],
        ['admin.categories', 'الأقسام', 'squares-2x2'],
        ['admin.orders', 'الطلبات', 'clipboard-document-list'],
    ];
@endphp
<div class="flex min-h-screen">
    <aside class="fixed md:sticky md:top-0 md:h-screen inset-y-0 start-0 z-40 w-64 bg-white border-e border-slate-200 flex flex-col transform transition md:translate-x-0"
           :class="side ? 'translate-x-0' : 'translate-x-full'">
        <div class="h-20 flex items-center justify-center border-b border-slate-100">
            <img src="{{ asset('images/logo.png') }}" alt="Snefro" class="h-14 w-auto mix-blend-multiply">
        </div>
        <nav class="flex-1 p-4 space-y-2 font-bold">
            @foreach ($links as [$route, $label, $icon])
                <a href="{{ route($route) }}" wire:navigate @click="side=false"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs($route) ? 'bg-brand-blue text-white shadow-lg shadow-sky-200' : 'text-slate-600 hover:bg-brand-sky' }}">
                    @svg('heroicon-o-'.$icon, 'w-7 h-7'){{ $label }}
                </a>
            @endforeach
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-brand-sky">
                <x-heroicon-o-building-storefront class="w-7 h-7"/>عرض المتجر
            </a>
        </nav>
        <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-slate-100">
            @csrf
            <button class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-brand-red hover:bg-red-50">
                <x-heroicon-o-lock-closed class="w-7 h-7"/>تسجيل الخروج
            </button>
        </form>
    </aside>
    <div x-show="side" x-cloak @click="side=false" class="fixed inset-0 bg-black/40 z-30 md:hidden"></div>

    <div class="flex-1 min-w-0">
        <div class="md:hidden h-16 bg-white border-b flex items-center px-4 gap-3">
            <button @click="side = !side" class="h-11 w-11 rounded-2xl bg-brand-sky flex items-center justify-center"><x-heroicon-o-bars-3 class="w-7 h-7"/></button>
            <span class="font-extrabold">لوحة سنفرو</span>
        </div>
        <main class="p-4 md:p-8">{{ $slot }}</main>
    </div>
</div>
@livewireScripts
@include('partials.toast')
</body>
</html>
