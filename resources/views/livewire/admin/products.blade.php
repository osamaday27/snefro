<div>
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h1 class="text-2xl font-bold flex items-center gap-3"><x-heroicon-o-cube class="w-8 h-8 text-brand-rose"/>المنتجات</h1>
        <div class="flex gap-3">
            <div class="relative"><x-heroicon-o-magnifying-glass class="w-5 h-5 absolute top-1/2 -translate-y-1/2 start-3 text-neutral-400"/>
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="بحث..." class="border border-brand-line ps-10 pe-3 py-3 text-sm bg-white focus:border-brand-ink focus:outline-none"></div>
            <button wire:click="create" class="inline-flex items-center gap-2 bg-brand-ink hover:bg-black text-white font-semibold px-5 py-3"><x-heroicon-o-plus-circle class="w-6 h-6"/>منتج جديد</button>
        </div>
    </div>

    @php $in = 'mt-1.5 w-full border border-brand-line px-4 py-3 focus:border-brand-ink focus:outline-none bg-white'; @endphp

    @if ($showForm)
        <form wire:submit="save" class="bg-white border border-brand-line p-6 md:p-8 mb-8 space-y-7">
            <h2 class="font-bold text-xl">{{ $editingId ? 'تعديل المنتج' : 'منتج جديد' }}</h2>

            <div class="grid md:grid-cols-3 gap-4">
                <div><label class="font-semibold text-sm">اسم المنتج (عربي) *</label><input type="text" wire:model="name" class="{{ $in }}">
                    @error('name') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror</div>
                <div><label class="font-semibold text-sm">Product name (English)</label><input type="text" dir="ltr" wire:model="name_en" class="{{ $in }} text-start"></div>
                <div><label class="font-semibold text-sm">القسم</label>
                    <select wire:model="category_id" class="{{ $in }}"><option value="">— بدون قسم —</option>
                        @foreach ($categories as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach</select></div>
            </div>

            <div class="grid md:grid-cols-4 gap-4">
                <div><label class="font-semibold text-sm">السعر (ج.م) *</label><input type="number" step="0.01" wire:model="price" class="{{ $in }}">
                    @error('price') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror</div>
                <div><label class="font-semibold text-sm">سعر بعد الخصم</label><input type="number" step="0.01" wire:model="sale_price" class="{{ $in }}">
                    @error('sale_price') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror</div>
                <div><label class="font-semibold text-sm">المخزون *</label><input type="number" wire:model="stock" class="{{ $in }}">
                    @error('stock') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror</div>
                <div><label class="font-semibold text-sm">مناسب لـ</label>
                    <select wire:model="gender" class="{{ $in }}"><option value="boys">أولاد</option><option value="girls">بنات</option><option value="unisex">للجنسين</option></select></div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="font-semibold text-sm">الفئة العمرية <span class="text-neutral-400 font-normal">(مثال: 2-9Y أو 0-12M أو 3+Y)</span></label>
                    <input type="text" dir="ltr" wire:model="age_range" placeholder="2-9Y" class="{{ $in }} text-start"></div>
                <div><label class="font-semibold text-sm">المقاسات <span class="text-neutral-400 font-normal">(افصل بفاصلة: 2-3Y, 4-5Y أو 26, 27)</span></label>
                    <input type="text" dir="ltr" wire:model="sizes" placeholder="2-3Y, 4-5Y, 6-7Y" class="{{ $in }} text-start"></div>
            </div>

            <div>
                <label class="font-semibold text-sm">الألوان المتاحة</label>
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach ($palette as $slug => $c)
                        <label class="cursor-pointer" wire:key="pal-{{ $slug }}">
                            <input type="checkbox" wire:model="colors" value="{{ $slug }}" class="peer hidden">
                            <span class="flex items-center gap-2 border border-brand-line px-3 py-2 text-sm peer-checked:border-brand-ink peer-checked:bg-brand-blush transition">
                                <i class="inline-block h-4 w-4 border border-neutral-300" style="background: {{ $c['hex'] }}"></i>{{ $c['ar'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="font-semibold text-sm">وصف مختصر (عربي)</label><input type="text" wire:model="short_description" class="{{ $in }}"></div>
                <div><label class="font-semibold text-sm">Short description (English)</label><input type="text" dir="ltr" wire:model="short_description_en" class="{{ $in }} text-start"></div>
                <div><label class="font-semibold text-sm">الوصف التفصيلي (عربي)</label><textarea wire:model="description" rows="4" class="{{ $in }}"></textarea></div>
                <div><label class="font-semibold text-sm">Full description (English)</label><textarea dir="ltr" wire:model="description_en" rows="4" class="{{ $in }} text-start"></textarea></div>
                <div><label class="font-semibold text-sm">الخامة (عربي)</label><input type="text" wire:model="material" class="{{ $in }}"></div>
                <div><label class="font-semibold text-sm">Material (English)</label><input type="text" dir="ltr" wire:model="material_en" class="{{ $in }} text-start"></div>
                <div><label class="font-semibold text-sm">المميزات (سطر لكل ميزة)</label><textarea wire:model="features" rows="4" class="{{ $in }}"></textarea></div>
                <div><label class="font-semibold text-sm">Features (one per line)</label><textarea dir="ltr" wire:model="features_en" rows="4" class="{{ $in }} text-start"></textarea></div>
                <div><label class="font-semibold text-sm">تعليمات العناية (سطر لكل تعليمة)</label><textarea wire:model="care" rows="4" class="{{ $in }}"></textarea></div>
                <div><label class="font-semibold text-sm">Care instructions (one per line)</label><textarea dir="ltr" wire:model="care_en" rows="4" class="{{ $in }} text-start"></textarea></div>
            </div>

            <div>
                <label class="font-semibold text-sm">صور المنتج <span class="text-neutral-400 font-normal">(الأولى رئيسية والثانية تظهر عند التمرير · حتى 2 ميجا للصورة)</span></label>
                <label class="mt-2 flex items-center justify-center gap-3 border-2 border-dashed border-neutral-300 hover:border-brand-ink py-6 cursor-pointer font-semibold">
                    <x-heroicon-o-photo class="w-8 h-8"/>اضغط لاختيار الصور
                    <input type="file" wire:model="photos" multiple accept="image/*" class="hidden">
                </label>
                <div wire:loading wire:target="photos" class="text-xs text-brand-rose mt-1">جاري الرفع...</div>
                @error('photos.*') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror
                <div class="mt-3 flex flex-wrap gap-3">
                    @foreach ($existing as $i => $img)
                        <div class="relative" wire:key="ex-{{ $i }}">
                            <img src="{{ \App\Models\Product::urlFor($img) }}" class="w-20 h-24 object-cover">
                            <button type="button" wire:click="removeExisting({{ $i }})" class="absolute -top-2 -start-2 bg-red-600 text-white w-7 h-7 flex items-center justify-center"><x-heroicon-s-x-mark class="w-4 h-4"/></button>
                        </div>
                    @endforeach
                    @foreach ($photos as $i => $photo)
                        <div class="relative" wire:key="new-{{ $i }}">
                            <img src="{{ $photo->temporaryUrl() }}" class="w-20 h-24 object-cover ring-2 ring-brand-pink">
                            <button type="button" wire:click="removePhoto({{ $i }})" class="absolute -top-2 -start-2 bg-red-600 text-white w-7 h-7 flex items-center justify-center"><x-heroicon-s-x-mark class="w-4 h-4"/></button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-wrap gap-6 text-sm font-semibold">
                <label class="flex items-center gap-2"><input type="checkbox" wire:model="is_active" class="h-5 w-5"> ظاهر في المتجر</label>
                <label class="flex items-center gap-2"><input type="checkbox" wire:model="is_featured" class="h-5 w-5"> منتج مميز (يظهر في الرئيسية)</label>
            </div>

            <div class="flex gap-3">
                <button class="inline-flex items-center gap-2 bg-brand-ink hover:bg-black text-white font-semibold px-8 py-3.5" wire:loading.attr="disabled" wire:target="save"><x-heroicon-o-check-circle class="w-7 h-7"/>حفظ المنتج</button>
                <button type="button" wire:click="resetForm" class="px-8 py-3.5 border border-brand-line font-semibold">إلغاء</button>
            </div>
        </form>
    @endif

    <div class="bg-white border border-brand-line overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-brand-mist text-neutral-500">
                <tr><th class="px-4 py-4 text-start">المنتج</th><th class="text-start">القسم</th><th class="text-start">السعر</th><th class="text-start">المخزون</th><th class="text-start">الحالة</th><th class="px-4 text-start">إجراءات</th></tr>
            </thead>
            <tbody>
            @forelse ($products as $p)
                <tr class="border-t border-brand-line" wire:key="row-{{ $p->id }}">
                    <td class="px-4 py-3"><div class="flex items-center gap-3">
                        <img src="{{ $p->image_url }}" class="w-12 h-14 object-cover" alt="">
                        <div><p class="font-semibold">{{ $p->name }}</p><p class="text-xs text-neutral-400" dir="ltr">{{ $p->name_en }} · {{ $p->sku }}</p></div></div></td>
                    <td>{{ $p->category?->name ?? '—' }}</td>
                    <td class="font-semibold">{{ number_format($p->final_price) }} @if($p->on_sale)<span class="text-xs text-neutral-400 line-through">{{ number_format($p->price) }}</span>@endif</td>
                    <td class="{{ $p->stock <= 5 ? 'text-red-600 font-bold' : '' }}">{{ $p->stock }}</td>
                    <td><button wire:click="toggle({{ $p->id }})" class="text-xs font-semibold px-3 py-1.5 {{ $p->is_active ? 'bg-green-100 text-green-800' : 'bg-neutral-200 text-neutral-600' }}">{{ $p->is_active ? 'ظاهر' : 'مخفي' }}</button></td>
                    <td class="px-4"><div class="flex gap-2">
                        <button wire:click="edit({{ $p->id }})" class="h-11 w-11 border border-brand-line hover:bg-brand-ink hover:text-white flex items-center justify-center transition" aria-label="تعديل"><x-heroicon-o-pencil-square class="w-6 h-6"/></button>
                        <button wire:click="delete({{ $p->id }})" wire:confirm="حذف هذا المنتج نهائياً؟" class="h-11 w-11 border border-brand-line text-red-600 hover:bg-red-600 hover:text-white hover:border-red-600 flex items-center justify-center transition" aria-label="حذف"><x-heroicon-o-trash class="w-6 h-6"/></button>
                    </div></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-neutral-500">لا توجد منتجات.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links('pagination.arabic') }}</div>
</div>
