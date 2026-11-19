<form wire:submit="login" class="w-full max-w-md bg-white border border-brand-line p-8 space-y-6">
    <div class="text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Snefro" class="h-20 w-auto mx-auto mix-blend-multiply">
        <p class="text-neutral-500 mt-2 flex items-center justify-center gap-2">
            <x-heroicon-o-lock-closed class="w-5 h-5"/>لوحة تحكم الإدارة
        </p>
    </div>

    <div>
        <label class="font-semibold text-sm">البريد الإلكتروني</label>
        <div class="relative">
            <x-heroicon-o-envelope class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-neutral-400 pointer-events-none"/>
            <input type="email" wire:model="email" autofocus autocomplete="username"
                   class="mt-1.5 w-full border border-brand-line ps-12 pe-4 py-3.5 focus:border-brand-ink focus:outline-none">
        </div>
        @error('email') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="font-semibold text-sm">كلمة المرور</label>
        <div class="relative">
            <x-heroicon-o-key class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-neutral-400 pointer-events-none"/>
            <input type="password" wire:model="password" autocomplete="current-password"
                   class="mt-1.5 w-full border border-brand-line ps-12 pe-4 py-3.5 focus:border-brand-ink focus:outline-none">
        </div>
        @error('password') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror
    </div>

    <label class="flex items-center gap-2 text-sm font-semibold cursor-pointer">
        <input type="checkbox" wire:model="remember" class="h-5 w-5"> تذكرني
    </label>

    <button type="submit" wire:loading.attr="disabled"
            class="w-full flex items-center justify-center gap-3 bg-brand-ink hover:bg-black disabled:opacity-60 text-white text-lg font-semibold py-4 transition">
        <x-heroicon-o-lock-open class="w-7 h-7" wire:loading.remove wire:target="login"/>
        <x-heroicon-o-arrow-path class="w-7 h-7 animate-spin" wire:loading wire:target="login"/>
        <span wire:loading.remove wire:target="login">تسجيل الدخول</span>
        <span wire:loading wire:target="login">جاري الدخول...</span>
    </button>
</form>