<div class="max-w-3xl">
    <h1 class="text-2xl font-black mb-6 flex items-center gap-3"><x-heroicon-o-squares-2x2 class="w-8 h-8 text-brand-blue"/>الأقسام</h1>

    <form wire:submit="save" class="bg-white rounded-3xl shadow-sm p-6 space-y-4">
        <h2 class="font-extrabold">{{ $editingId ? 'تعديل القسم' : 'إضافة قسم جديد' }}</h2>
        <div>
            <input type="text" wire:model="name" placeholder="اسم القسم" class="w-full rounded-2xl border border-slate-200 px-4 py-3.5 focus:ring-2 focus:ring-brand-blue focus:outline-none">
            @error('name') <p class="text-brand-red text-xs font-bold mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-4">
            <div class="h-24 w-24 rounded-2xl overflow-hidden bg-brand-sky flex items-center justify-center shrink-0">
                @if ($photo) <img src="{{ $photo->temporaryUrl() }}" class="h-full w-full object-cover">
                @elseif ($currentImage) <img src="{{ str_starts_with($currentImage, 'http') ? $currentImage : Storage::url($currentImage) }}" class="h-full w-full object-cover">
                @else <x-heroicon-o-photo class="w-10 h-10 text-slate-300"/> @endif
            </div>
            <div class="flex-1">
                <label class="inline-flex items-center gap-2 cursor-pointer bg-brand-sky text-brand-blue font-bold px-5 py-3 rounded-2xl hover:bg-sky-100">
                    <x-heroicon-o-arrow-up-tray class="w-6 h-6"/>رفع صورة القسم
                    <input type="file" wire:model="photo" accept="image/*" class="hidden">
                </label>
                <p class="text-xs text-slate-500 mt-2">يفضل صورة مربعة (حد أقصى 2 ميجا)</p>
                <div wire:loading wire:target="photo" class="text-xs text-brand-blue mt-1">جاري الرفع...</div>
                @error('photo') <p class="text-brand-red text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex gap-3">
            <button class="inline-flex items-center gap-2 bg-brand-blue text-white font-bold px-6 py-3 rounded-2xl"><x-heroicon-o-check class="w-6 h-6"/>{{ $editingId ? 'تحديث' : 'إضافة' }}</button>
            @if ($editingId) <button type="button" wire:click="cancel" class="px-6 py-3 border rounded-2xl font-bold">إلغاء</button> @endif
        </div>
    </form>

    <div class="mt-6 bg-white rounded-3xl shadow-sm divide-y">
        @forelse ($categories as $c)
            <div class="px-5 py-4 flex items-center gap-4" wire:key="c-{{ $c->id }}">
                <img src="{{ $c->image_url }}" class="h-16 w-16 rounded-2xl object-cover" alt="">
                <div class="flex-1 min-w-0"><p class="font-extrabold">{{ $c->name }}</p><p class="text-xs text-slate-500">{{ $c->products_count }} منتج</p></div>
                <button wire:click="edit({{ $c->id }})" class="h-11 w-11 rounded-2xl bg-amber-50 text-brand-orange hover:bg-brand-orange hover:text-white flex items-center justify-center transition" aria-label="تعديل"><x-heroicon-o-pencil-square class="w-6 h-6"/></button>
                <button wire:click="delete({{ $c->id }})" wire:confirm="حذف هذا القسم؟ المنتجات ستبقى بدون قسم." class="h-11 w-11 rounded-2xl bg-red-50 text-brand-red hover:bg-brand-red hover:text-white flex items-center justify-center transition" aria-label="حذف"><x-heroicon-o-trash class="w-6 h-6"/></button>
            </div>
        @empty
            <p class="p-8 text-center text-slate-500">لا توجد أقسام بعد.</p>
        @endforelse
    </div>
</div>
