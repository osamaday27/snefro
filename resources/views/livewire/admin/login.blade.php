<form wire:submit="login" class="w-full max-w-md bg-white border border-brand-line p-8 space-y-6">
    <div class="text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Snefro" class="h-20 w-auto mx-auto mix-blend-multiply">
        <p class="text-neutral-500 mt-2 flex items-center justify-center gap-2"><x-heroicon-o-lock-closed class="w-5 h-5"/>لوحة تحكم الإدارة</p>
    </div>

    <div>
        <label class="font-bold text-sm">البريد الإلكتروني</label>
        <div class="relative"><x-heroicon-o-envelope class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-slate-400"/>
            <input type="email" dir="ltr" wire:model="email" autofocus class="mt-1.5 w-full border ps-12 pe-4 py-3.5 text-end focus:ring-2 focus:ring-brand-ink focus:outline-none"></div>
        @error('email') <p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="font-bold text-sm">كلمة المرور</label>
        <div class="relative"><x-heroicon-o-key class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-slate-400"/>
            <input type="password" dir="ltr" wire:model="password" class="mt-1.5 w-full border ps-12 pe-4 py-3.5 text-end focus:ring-2 focus:ring-brand-ink focus:outline-none"></div>
        @error('password') <p class="text-red-600 text-xs font-bold mt-1">{{ $message }}</p> @enderror
    </div>

    <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" wire:model="remember" class="h-5 w-5 > تذكرني</label>

    <button class="w-full inline-flex items-center justify-center gap-3 bg-brand-ink hover:bg-black text-white text-lg font-extrabold py-4" wire:loading.attr="disabled">
        <x-heroicon-o-lock-open class="w-7 h-7"/>تسجيل الدخول
    </button>
</form>
