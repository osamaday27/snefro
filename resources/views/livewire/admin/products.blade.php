<div>
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h1 class="text-2xl font-black flex items-center gap-3"><x-heroicon-o-cube class="w-8 h-8 text-brand-blue"/>المنتجات</h1>
        <div class="flex gap-3">
            <div class="relative"><x-heroicon-o-magnifying-glass class="w-5 h-5 absolute top-1/2 -translate-y-1/2 start-3 text-slate-400"/>
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="بحث..." class="rounded-2xl border border-slate-200 ps-10 pe-3 py-3 text-sm bg-white"></div>
            <button wire:click="create" class="inline-flex items-center gap-2 bg-brand-blue text-white font-bold px-5 py-3 rounded-2xl shadow-lg shadow-sky-200"><x-heroicon-o-plus-circle class="w-6 h-6"/>منتج جديد</button>
        </div>
    </div>

    @php $in = 'mt-1.5 w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-brand-blue focus:outline-none bg-white'; @endphp

    @if ($showForm)
        <form wire:submit="save" class="bg-white rounded-3xl shadow-sm p-6 md:p-8 mb-8 space-y-6">
            <h2 class="font-extrabold text-xl">{{ $editingId ? 'تعديل المنتج' : 'منتج جديد' }}</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="font-bold text-sm">اسم المنتج *</label><input type="text" wire:model="name" class="{{ $in }}">
                    @error('name') <p class="text-brand-red text-xs font-bold mt-1">{{ $message }}</p> @enderror</div>
                <div><label class="font-bold text-sm">القسم</label>
                    <select wire:model="category_id" class="{{ $in }}"><option value="">— بدون قسم —</option>
                        @foreach ($categories as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach</select></div>
            </div>

            <div><label class="font-bold text-sm">وصف مختصر (يظهر في البطاقة)</label><input type="text" wire:model="short_description" class="{{ $in }}">
                @error('short_description') <p class="text-brand-red text-xs font-bold mt-1">{{ $message }}</p> @enderror</div>

            <div class="grid md:grid-cols-3 gap-4">
                <div><label class="font-bold text-sm">السعر ({{ config('snefro.currency') }}) *</label><input type="number" step="0.01" wire:model="price" class="{{ $in }}">
                    @error('price') <p class="text-brand-red text-xs font-bold mt-1">{{ $message }}</p> @enderror</div>
                <div><label class="font-bold text-sm">سعر بعد الخصم</label><input type="number" step="0.01" wire:model="sale_price" class="{{ $in }}">
                    @error('sale_price') <p class="text-brand-red text-xs font-bold mt-1">{{ $message }}</p> @enderror</div>
                <div><label class="font-bold text-sm">الكمية في المخزون *</label><input type="number" wire:model="stock" class="{{ $in }}">
                    @error('stock') <p class="text-brand-red text-xs font-bold mt-1">{{ $message }}</p> @enderror</div>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div><label class="font-bold text-sm">مناسب لـ</label>
                    <select wire:model="gender" class="{{ $in }}">@foreach ($genders as $k => $l) <option value="{{ $k }}">{{ $l }}</option> @endforeach</select></div>
                <div><label class="font-bold text-sm">الفئة العمرية</label><input type="text" wire:model="age_range" placeholder="مثال: 2 - 8 سنوات" class="{{ $in }}"></div>
                <div><label class="font-bold text-sm">الخامة</label><input type="text" wire:model="material" placeholder="مثال: قطن 100%" class="{{ $in }}"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="font-bold text-sm">المقاسات <span class="text-slate-400 font-normal">(افصل بفاصلة)</span></label>
                    <input type="text" wire:model="sizes" placeholder="2-3 سنوات، 4-5 سنوات، 6-7 سنوات" class="{{ $in }}"></div>
                <div><label class="font-bold text-sm">الألوان <span class="text-slate-400 font-normal">(افصل بفاصلة)</span></label>
                    <input type="text" wire:model="colors" placeholder="أزرق، أبيض، وردي" class="{{ $in }}">
                    <p class="text-xs text-slate-400 mt-1">ألوان مدعومة: {{ implode('، ', array_keys(\App\Models\Product::COLORS)) }}</p></div>
            </div>

            <div><label class="font-bold text-sm">الوصف التفصيلي</label><textarea wire:model="description" rows="4" class="{{ $in }}"></textarea></div>

            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="font-bold text-sm">مميزات المنتج <span class="text-slate-400 font-normal">(ميزة في كل سطر)</span></label>
                    <textarea wire:model="features" rows="5" class="{{ $in }}" placeholder="قطن ناعم على البشرة&#10;ألوان ثابتة لا تبهت"></textarea></div>
                <div><label class="font-bold text-sm">تعليمات العناية والغسيل <span class="text-slate-400 font-normal">(سطر لكل تعليمة)</span></label>
                    <textarea wire:model="care" rows="5" class="{{ $in }}"></textarea></div>
            </div>

            <div>
                <label class="font-bold text-sm">صور المنتج <span class="text-slate-400 font-normal">(الأولى هي الرئيسية · حتى 2 ميجا للصورة)</span></label>
                <label class="mt-2 flex items-center justify-center gap-3 border-2 border-dashed border-slate-300 hover:border-brand-blue rounded-2xl py-6 cursor-pointer text-brand-blue font-bold">
                    <x-heroicon-o-photo class="w-8 h-8"/>اضغط لاختيار الصور
                    <input type="file" wire:model="photos" multiple accept="image/*" class="hidden">
                </label>
                <div wire:loading wire:target="photos" class="text-xs text-brand-blue mt-1">جاري الرفع...</div>
                @error('photos.*') <p class="text-brand-red text-xs font-bold mt-1">{{ $message }}</p> @enderror
                <div class="mt-3 flex flex-wrap gap-3">
                    @foreach ($existing as $i => $img)
                        <div class="relative" wire:key="ex-{{ $i }}">
                            <img src="{{ \App\Models\Product::urlFor($img) }}" class="w-20 h-24 object-cover rounded-2xl">
                            <button type="button" wire:click="removeExisting({{ $i }})" class="absolute -top-2 -start-2 bg-brand-red text-white w-7 h-7 rounded-full flex items-center justify-center"><x-heroicon-s-x-mark class="w-4 h-4"/></button>
                        </div>
                    @endforeach
                    @foreach ($photos as $i => $photo)
                        <div class="relative" wire:key="new-{{ $i }}">
                            <img src="{{ $photo->temporaryUrl() }}" class="w-20 h-24 object-cover rounded-2xl ring-2 ring-brand-blue">
                            <button type="button" wire:click="removePhoto({{ $i }})" class="absolute -top-2 -start-2 bg-brand-red text-white w-7 h-7 rounded-full flex items-center justify-center"><x-heroicon-s-x-mark class="w-4 h-4"/></button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-wrap gap-6 text-sm font-bold">
                <label class="flex items-center gap-2"><input type="checkbox" wire:model="is_active" class="h-5 w-5 rounded"> ظاهر في المتجر</label>
                <label class="flex items-center gap-2"><input type="checkbox" wire:model="is_featured" class="h-5 w-5 rounded"> منتج مميز (يظهر في الرئيسية)</label>
            </div>

            <div class="flex gap-3">
                <button class="inline-flex items-center gap-2 bg-brand-green text-white font-extrabold px-8 py-3.5 rounded-2xl shadow-lg shadow-green-200" wire:loading.attr="disabled" wire:target="save"><x-heroicon-o-check-circle class="w-7 h-7"/>حفظ المنتج</button>
                <button type="button" wire:click="resetForm" class="px-8 py-3.5 border rounded-2xl font-bold">إلغاء</button>
            </div>
        </form>
    @endif

    <div class="bg-white rounded-3xl shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr><th class="px-4 py-4 text-start">المنتج</th><th class="text-start">القسم</th><th class="text-start">السعر</th><th class="text-start">المخزون</th><th class="text-start">الحالة</th><th class="px-4 text-start">إجراءات</th></tr>
            </thead>
            <tbody>
            @forelse ($products as $p)
                <tr class="border-t" wire:key="row-{{ $p->id }}">
                    <td class="px-4 py-3"><div class="flex items-center gap-3">
                        <img src="{{ $p->image_url }}" class="w-12 h-14 object-cover rounded-xl" alt="">
                        <div><p class="font-bold">{{ $p->name }}</p><p class="text-xs text-slate-400">{{ $p->sku }}</p></div></div></td>
                    <td>{{ $p->category?->name ?? '—' }}</td>
                    <td class="font-bold">{{ number_format($p->final_price) }} @if($p->on_sale)<span class="text-xs text-slate-400 line-through">{{ number_format($p->price) }}</span>@endif</td>
                    <td class="{{ $p->stock <= 5 ? 'text-brand-red font-black' : '' }}">{{ $p->stock }}</td>
                    <td><button wire:click="toggle({{ $p->id }})" class="text-xs font-bold px-3 py-1.5 rounded-full {{ $p->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-600' }}">{{ $p->is_active ? 'ظاهر' : 'مخفي' }}</button></td>
                    <td class="px-4"><div class="flex gap-2">
                        <button wire:click="edit({{ $p->id }})" class="h-11 w-11 rounded-2xl bg-amber-50 text-brand-orange hover:bg-brand-orange hover:text-white flex items-center justify-center transition" aria-label="تعديل"><x-heroicon-o-pencil-square class="w-6 h-6"/></button>
                        <button wire:click="delete({{ $p->id }})" wire:confirm="حذف هذا المنتج نهائياً؟" class="h-11 w-11 rounded-2xl bg-red-50 text-brand-red hover:bg-brand-red hover:text-white flex items-center justify-center transition" aria-label="حذف"><x-heroicon-o-trash class="w-6 h-6"/></button>
                    </div></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-slate-500">لا توجد منتجات.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links('pagination.arabic') }}</div>
</div>
