<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @include('partials.head')
    <title>{{ $title ?? 'دخول' }} | {{ config('snefro.name') }}</title>
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-brand-sky via-white to-brand-cream min-h-screen flex items-center justify-center p-4">
    {{ $slot }}
    @livewireScripts
    @include('partials.toast')
</body>
</html>
