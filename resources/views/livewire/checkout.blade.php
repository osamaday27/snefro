<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex items-center gap-4 mb-8">
        <span class="h-14 w-14 rounded-2xl bg-brand-green text-white flex items-center justify-center shadow-lg"><x-heroicon-o-credit-card class="w-8 h-8"/></span>
        <h1 class="text-3xl font-black">إتمام الطلب</h1>
    </div>

    @error('cart')
        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 px-5 py-4 font-bold flex items-center gap-2"><x-heroicon-o-exclamation-triangle class="w-6 h-6"/>{{ $message }}</div>
    @enderror

    @php $input = 'mt-1.5 w-full rounded-2xl border border-slate-200 ps-12 pe-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white'; @endphp

    <div class="grid lg:grid-cols-3 gap-8">
        <form wire:submit="placeOrder" class="lg:col-span-2 bg-white rounded-3xl p-6 md:p-8 shadow-sm space-y-5">
            <h2 class="font-extrabold text-xl flex items-center gap-2"><x-heroicon-o-map-pin class="w-7 h-7 text-brand-orange"/>بيانات التوصيل</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-sm">الاسم بالكامل *</label>
                    <div class="relative"><x-heroicon-o-user class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-slate-400"/>
                        <input type="text" wire:model="customer_name" class="{{ $input }}" placeholder="اسمك الكريم"></div>
                    @error('customer_name') <p class="text-brand-red text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="font-bold text-sm">رقم الموبايل *</label>
                    <div class="relative"><x-heroicon-o-phone class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-slate-400"/>
                        <input type="tel" dir="ltr" wire:model="phone" class="{{ $input }} text-end" placeholder="01XXXXXXXXX"></div>
                    @error('phone') <p class="text-brand-red text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="font-bold text-sm">البريد الإلكتروني (اختياري)</label>
                <div class="relative"><x-heroicon-o-envelope class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-slate-400"/>
                    <input type="email" dir="ltr" wire:model="email" class="{{ $input }} text-end" placeholder="name@example.com"></div>
                @error('email') <p class="text-brand-red text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="font-bold text-sm">المحافظة *</label>
                    <div class="relative"><x-heroicon-o-building-office-2 class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-slate-400 pointer-events-none"/>
                        <select wire:model="city" class="{{ $input }} appearance-none">
                            <option value="">اختر المحافظة</option>
                            @foreach ($governorates as $g) <option value="{{ $g }}">{{ $g }}</option> @endforeach
                        </select></div>
                    @error('city') <p class="text-brand-red text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="font-bold text-sm">العنوان بالتفصيل *</label>
                    <div class="relative"><x-heroicon-o-home-modern class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-slate-400"/>
                        <input type="text" wire:model="address" class="{{ $input }}" placeholder="المدينة / الحي / الشارع / رقم العمارة"></div>
                    @error('address') <p class="text-brand-red text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="font-bold text-sm">ملاحظات على الطلب</label>
                <textarea wire:model="notes" rows="3" class="mt-1.5 w-full rounded-2xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="أي تفاصيل إضافية للتوصيل..."></textarea>
            </div>

            <div class="rounded-2xl bg-green-50 border border-green-200 px-5 py-4 flex items-center gap-4">
                <span class="h-14 w-14 rounded-2xl bg-brand-green text-white flex items-center justify-center shrink-0"><x-heroicon-o-banknotes class="w-8 h-8"/></span>
                <div><p class="font-extrabold">الدفع عند الاستلام</p><p class="text-sm text-slate-600">ادفع نقداً للمندوب بعد استلام طلبك وفحصه.</p></div>
            </div>

            <button type="submit" wire:loading.attr="disabled"
                    class="w-full inline-flex items-center justify-center gap-3 bg-brand-green hover:bg-green-600 disabled:opacity-60 text-white text-lg font-extrabold py-4 rounded-2xl shadow-xl shadow-green-200 transition">
                <x-heroicon-o-check-badge class="w-8 h-8" wire:loading.remove wire:target="placeOrder"/>
                <x-heroicon-o-arrow-path class="w-8 h-8 animate-spin" wire:loading wire:target="placeOrder"/>
                <span wire:loading.remove wire:target="placeOrder">تأكيد الطلب · {{ number_format($total) }} {{ config('snefro.currency') }}</span>
                <span wire:loading wire:target="placeOrder">جاري تأكيد طلبك...</span>
            </button>
        </form>

        <aside class="bg-white rounded-3xl p-6 shadow-sm h-fit space-y-4 lg:sticky lg:top-28">
            <h2 class="font-extrabold text-xl flex items-center gap-2"><x-heroicon-o-shopping-bag class="w-7 h-7 text-brand-blue"/>طلبك</h2>
            <div class="space-y-3 max-h-80 overflow-y-auto">
                @foreach ($items as $item)
                    <div class="flex items-center gap-3" wire:key="co-{{ $item->key }}">
                        <div class="relative shrink-0"><img src="{{ $item->product->image_url }}" class="h-16 w-14 object-cover rounded-xl" alt="">
                            <span class="absolute -top-2 -start-2 h-6 min-w-6 px-1 rounded-full bg-brand-ink text-white text-xs font-bold flex items-center justify-center">{{ $item->qty }}</span></div>
                        <div class="flex-1 min-w-0"><p class="text-sm font-bold truncate">{{ $item->product->name }}</p>
                            <p class="text-xs text-slate-500">{{ $item->size }} {{ $item->color ? '· '.$item->color : '' }}</p></div>
                        <span class="text-sm font-extrabold">{{ number_format($item->line_total) }}</span>
                    </div>
                @endforeach
            </div>
            <div class="border-t pt-4 space-y-2">
                <div class="flex justify-between text-sm"><span class="text-slate-500">المجموع</span><span class="font-bold">{{ number_format($subtotal) }} {{ config('snefro.currency') }}</span></div>
                <div class="flex justify-between text-sm"><span class="text-slate-500">الشحن</span><span class="font-bold {{ $shipping == 0 ? 'text-green-600' : '' }}">{{ $shipping == 0 ? 'مجاني' : number_format($shipping).' '.config('snefro.currency') }}</span></div>
                <div class="flex justify-between text-xl font-black pt-2 border-t"><span>الإجمالي</span><span class="text-brand-blue">{{ number_format($total) }} {{ config('snefro.currency') }}</span></div>
            </div>
        </aside>
    </div>
</div>
