<div class="max-w-5xl">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3"><x-heroicon-o-photo class="w-8 h-8 text-brand-rose"/>صور الهيرو (سلايدر الرئيسية)</h1>
            <p class="text-sm text-neutral-500 mt-2">مقاس الصورة المناسب: <span dir="ltr">1920×800</span> بكسل · حد أقصى 5 ميجا · يفضّل أن يكون موضوع الصورة في الجهة المقابلة للنص.</p>
        </div>
        <button wire:click="create" class="inline-flex items-center gap-2 bg-brand-ink hover:bg-black text-white font-semibold px-5 py-3"><x-heroicon-o-plus-circle class="w-6 h-6"/>إضافة صورة</button>
    </div>

    @php $in = 'mt-1.5 w-full border border-brand-line px-4 py-3 focus:border-brand-ink focus:outline-none bg-white'; @endphp

    @if ($showForm)
        <form wire:submit="save" class="bg-white border border-brand-line p-6 md:p-8 mb-8 space-y-6">
            <h2 class="font-bold text-xl">{{ $editingId ? 'تعديل الصورة' : 'إضافة صورة جديدة' }}</h2>

            <div>
                <label class="font-semibold text-sm">الصورة {{ $editingId ? '' : '*' }}</label>
                <label class="mt-2 block cursor-pointer border-2 border-dashed border-neutral-300 hover:border-brand-ink overflow-hidden">
                    @if ($photo)
                        <img src="{{ $photo->temporaryUrl() }}" class="w-full h-48 object-cover">
                    @elseif ($currentImage)
                        <img src="{{ str_starts_with($currentImage, 'http') ? $currentImage : Storage::url($currentImage) }}" class="w-full h-48 object-cover">
                    @else
                        <span class="flex items-center justify-center gap-3 py-12 font-semibold"><x-heroicon-o-arrow-up-tray class="w-8 h-8"/>اضغط لاختيار الصورة</span>
                    @endif
                    <input type="file" wire:model="photo" accept="image/*" class="hidden">
                </label>
                <div wire:loading wire:target="photo" class="text-xs text-brand-rose mt-1">جاري رفع الصورة...</div>
                @error('photo') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror
                @if ($photo || $currentImage)<p class="text-xs text-neutral-500 mt-1">اضغط على الصورة لتغييرها.</p>@endif
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="font-semibold text-sm">العنوان الرئيسي (عربي) *</label><input type="text" wire:model="heading" class="{{ $in }}">
                    @error('heading') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror</div>
                <div><label class="font-semibold text-sm">Main title (English)</label><input type="text" dir="ltr" wire:model="heading_en" class="{{ $in }} text-start"></div>
                <div><label class="font-semibold text-sm">عنوان صغير فوق العنوان (عربي)</label><input type="text" wire:model="label" placeholder="مثال: مجموعة جديدة" class="{{ $in }}"></div>
                <div><label class="font-semibold text-sm">Small label (English)</label><input type="text" dir="ltr" wire:model="label_en" placeholder="e.g. New collection" class="{{ $in }} text-start"></div>
                <div><label class="font-semibold text-sm">الوصف (عربي)</label><textarea wire:model="body" rows="3" class="{{ $in }}"></textarea></div>
                <div><label class="font-semibold text-sm">Description (English)</label><textarea dir="ltr" wire:model="body_en" rows="3" class="{{ $in }} text-start"></textarea></div>
                <div><label class="font-semibold text-sm">نص الزر (عربي)</label><input type="text" wire:model="btn" placeholder="تسوّق الآن" class="{{ $in }}"></div>
                <div><label class="font-semibold text-sm">Button text (English)</label><input type="text" dir="ltr" wire:model="btn_en" placeholder="Shop now" class="{{ $in }} text-start"></div>
            </div>

            <div>
                <label class="font-semibold text-sm">رابط الزر <span class="text-neutral-400 font-normal">(اتركه فارغاً للانتقال لصفحة المتجر)</span></label>
                <input type="text" dir="ltr" wire:model="link" placeholder="/shop?category=toys" class="{{ $in }} text-start">
            </div>

            <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" wire:model="is_active" class="h-5 w-5"> ظاهرة في الموقع</label>

            <div class="flex gap-3">
                <button class="inline-flex items-center gap-2 bg-brand-ink hover:bg-black text-white font-semibold px-8 py-3.5" wire:loading.attr="disabled" wire:target="save,photo"><x-heroicon-o-check-circle class="w-7 h-7"/>حفظ</button>
                <button type="button" wire:click="resetForm" class="px-8 py-3.5 border border-brand-line font-semibold">إلغاء</button>
            </div>
        </form>
    @endif

    <div class="space-y-3">
        @forelse ($slides as $i => $s)
            <div class="bg-white border border-brand-line flex flex-col sm:flex-row gap-4 p-4 {{ $s->is_active ? '' : 'opacity-60' }}" wire:key="slide-{{ $s->id }}">
                <img src="{{ $s->image_url }}" class="w-full sm:w-64 h-32 object-cover bg-brand-mist shrink-0" alt="">
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-brand-rose font-semibold">{{ $s->tag }}</p>
                    <h3 class="font-bold truncate">{{ $s->title }}</h3>
                    <p class="text-sm text-neutral-500 line-clamp-2">{{ $s->text }}</p>
                    <p class="text-xs text-neutral-400 mt-1" dir="ltr">{{ $s->title_en }}</p>
                </div>
                <div class="flex sm:flex-col gap-2 items-center justify-end">
                    <div class="flex gap-2">
                        <button wire:click="move({{ $s->id }}, 'up')" @disabled($loop->first) class="h-11 w-11 border border-brand-line hover:bg-brand-ink hover:text-white flex items-center justify-center transition disabled:opacity-30" aria-label="أعلى"><x-heroicon-o-arrow-up class="w-6 h-6"/></button>
                        <button wire:click="move({{ $s->id }}, 'down')" @disabled($loop->last) class="h-11 w-11 border border-brand-line hover:bg-brand-ink hover:text-white flex items-center justify-center transition disabled:opacity-30" aria-label="أسفل"><x-heroicon-o-arrow-down class="w-6 h-6"/></button>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="toggle({{ $s->id }})" class="h-11 w-11 border border-brand-line hover:bg-brand-pink flex items-center justify-center transition" aria-label="إظهار/إخفاء" title="{{ $s->is_active ? 'إخفاء' : 'إظهار' }}">
                            @if ($s->is_active)<x-heroicon-o-eye class="w-6 h-6"/>@else<x-heroicon-o-eye-slash class="w-6 h-6"/>@endif
                        </button>
                        <button wire:click="edit({{ $s->id }})" class="h-11 w-11 border border-brand-line hover:bg-brand-ink hover:text-white flex items-center justify-center transition" aria-label="تعديل"><x-heroicon-o-pencil-square class="w-6 h-6"/></button>
                        <button wire:click="delete({{ $s->id }})" wire:confirm="حذف هذه الصورة نهائياً؟" class="h-11 w-11 border border-brand-line text-red-600 hover:bg-red-600 hover:text-white hover:border-red-600 flex items-center justify-center transition" aria-label="حذف"><x-heroicon-o-trash class="w-6 h-6"/></button>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-brand-line p-10 text-center text-neutral-500">
                <x-heroicon-o-photo class="w-14 h-14 mx-auto text-neutral-300"/>
                <p class="mt-3 font-semibold">لا توجد صور بعد.</p>
                <p class="text-sm mt-1">حتى تضيف صوراً، يعرض الموقع الصور الافتراضية <span dir="ltr">(images/1.jpg · 2.jpg · 3.jpg)</span>.</p>
            </div>
        @endforelse
    </div>
</div>
