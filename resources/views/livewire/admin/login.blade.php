<form wire:submit="login" class="w-full max-w-sm bg-white rounded-2xl shadow-lg p-8 space-y-5">
    <div class="text-center">
        <div class="text-3xl font-black">SNEFRO<span class="text-amber-500">.</span></div>
        <p class="text-sm text-stone-500 mt-1">Admin panel</p>
    </div>

    <div>
        <label class="text-sm font-medium">Email</label>
        <input type="email" wire:model="email" autofocus class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
        @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="text-sm font-medium">Password</label>
        <input type="password" wire:model="password" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
        @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <label class="flex items-center gap-2 text-sm"><input type="checkbox" wire:model="remember"> Remember me</label>

    <button class="w-full bg-stone-900 hover:bg-stone-700 text-white font-semibold py-3 rounded-lg" wire:loading.attr="disabled">Sign in</button>
</form>
