<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @include('partials.head')
    <title>{{ $title ?? 'دخول' }} | سنفرو</title>
    @livewireStyles
</head>
<body class="bg-brand-mist min-h-screen flex items-center justify-center p-4">
    {{ $slot }}
    @livewireScripts
    @include('partials.toast')
</body>
</html>