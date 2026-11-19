<div class="max-w-3xl">
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-3"><x-heroicon-o-squares-2x2 class="w-8 h-8 text-brand-rose"/>الأقسام</h1>

    <form wire:submit="save" class="bg-white border border-brand-line p-6 space-y-4">
        <h2 class="font-bold">{{ $editingId ? 'تعديل القسم' : 'إضافة قسم جديد' }}</h2>
        <div class="grid sm:grid-cols-2 gap-3">
            <div>
                <input type="text" wire:model="name" placeholder="اسم القسم (عربي) *" class="w-full border border-brand-line px-4 py-3.5 focus:border-brand-ink focus:outline-none">
                @error('name') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <input type="text" dir="ltr" wire:model="name_en" placeholder="Category name (English)" class="w-full border border-brand-line px-4 py-3.5 text-start focus:border-brand-ink focus:outline-none">
                @error('name_en') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="h-24 w-20 overflow-hidden bg-brand-mist flex items-center justify-center shrink-0">
                @if ($photo) <img src="{{ $photo->temporaryUrl() }}" class="h-full w-full object-cover">
                @elseif ($currentImage) <img src="{{ str_starts_with($currentImage, 'http') ? $currentImage : Storage::url($currentImage) }}" class="h-full w-full object-cover">
                @else <x-heroicon-o-photo class="w-10 h-10 text-neutral-300"/> @endif
            </div>
            <div class="flex-1">
                <label class="inline-flex items-center gap-2 cursor-pointer border border-brand-ink font-semibold px-5 py-3 hover:bg-brand-ink hover:text-white transition">
                    <x-heroicon-o-arrow-up-tray class="w-6 h-6"/>رفع صورة القسم
                    <input type="file" wire:model="photo" accept="image/*" class="hidden">
                </label>
                <p class="text-xs text-neutral-500 mt-2">يفضل صورة طولية 3:4 (حد أقصى 2 ميجا)</p>
                <div wire:loading wire:target="photo" class="text-xs text-brand-rose mt-1">جاري الرفع...</div>
                @error('photo') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex gap-3">
            <button class="inline-flex items-center gap-2 bg-brand-ink hover:bg-black text-white font-semibold px-6 py-3"><x-heroicon-o-check class="w-6 h-6"/>{{ $editingId ? 'تحديث' : 'إضافة' }}</button>
            @if ($editingId) <button type="button" wire:click="cancel" class="px-6 py-3 border border-brand-line font-semibold">إلغاء</button> @endif
        </div>
    </form>

    <div class="mt-6 bg-white border border-brand-line divide-y divide-brand-line">
        @forelse ($categories as $c)
            <div class="px-5 py-4 flex items-center gap-4" wire:key="c-{{ $c->id }}">
                <img src="{{ $c->image_url }}" class="h-16 w-14 object-cover" alt="">
                <div class="flex-1 min-w-0"><p class="font-bold">{{ $c->name }} <span class="text-neutral-400 font-normal text-sm" dir="ltr">{{ $c->name_en }}</span></p><p class="text-xs text-neutral-500">{{ $c->products_count }} منتج</p></div>
                <button wire:click="edit({{ $c->id }})" class="h-11 w-11 border border-brand-line hover:bg-brand-ink hover:text-white flex items-center justify-center transition" aria-label="تعديل"><x-heroicon-o-pencil-square class="w-6 h-6"/></button>
                <button wire:click="delete({{ $c->id }})" wire:confirm="حذف هذا القسم؟ المنتجات ستبقى بدون قسم." class="h-11 w-11 border border-brand-line text-red-600 hover:bg-red-600 hover:text-white hover:border-red-600 flex items-center justify-center transition" aria-label="حذف"><x-heroicon-o-trash class="w-6 h-6"/></button>
            </div>
        @empty
            <p class="p-8 text-center text-neutral-500">لا توجد أقسام بعد.</p>
        @endforelse
    </div>
</div>
