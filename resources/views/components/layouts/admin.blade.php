<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} | Snefro Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>[x-cloak]{display:none!important}</style>
    @livewireStyles
</head>
<body class="bg-stone-100 text-stone-900 min-h-screen" x-data="{ side: false }">
@php
    $links = [
        ['admin.dashboard', 'Dashboard', '📊'],
        ['admin.products', 'Products', '👕'],
        ['admin.categories', 'Categories', '🏷️'],
        ['admin.orders', 'Orders', '📦'],
    ];
@endphp
<div class="flex min-h-screen">
    <aside class="fixed md:static inset-y-0 left-0 z-40 w-60 bg-stone-900 text-stone-300 flex flex-col transform transition md:translate-x-0"
           :class="side ? 'translate-x-0' : '-translate-x-full'">
        <div class="h-16 flex items-center px-6 text-xl font-black text-white">SNEFRO<span class="text-amber-500">.</span> <span class="ml-2 text-xs font-normal text-stone-400">admin</span></div>
        <nav class="flex-1 px-3 space-y-1 text-sm">
            @foreach ($links as [$route, $label, $icon])
                <a href="{{ route($route) }}" wire:navigate
                   class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-stone-800 {{ request()->routeIs($route) ? 'bg-amber-500 text-stone-900 font-semibold hover:bg-amber-500' : '' }}">
                    <span>{{ $icon }}</span>{{ $label }}
                </a>
            @endforeach
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-stone-800">🌐 View store</a>
        </nav>
        <form method="POST" action="{{ route('logout') }}" class="p-4">
            @csrf
            <button class="w-full text-left text-sm px-3 py-2 rounded-lg hover:bg-stone-800">🚪 Logout</button>
        </form>
    </aside>

    <div class="flex-1 min-w-0">
        <div class="md:hidden h-14 bg-white border-b flex items-center px-4">
            <button @click="side = !side" class="text-2xl">☰</button>
            <span class="ml-3 font-bold">Snefro Admin</span>
        </div>
        <main class="p-4 md:p-8">
            {{ $slot }}
        </main>
    </div>
</div>
@livewireScripts
</body>
</html>
