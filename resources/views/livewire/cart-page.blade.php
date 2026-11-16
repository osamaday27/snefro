<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex items-center gap-4 mb-8">
        <span class="h-14 w-14 rounded-2xl bg-brand-yellow text-brand-ink flex items-center justify-center shadow-lg"><x-heroicon-o-shopping-cart class="w-8 h-8"/></span>
        <h1 class="text-3xl font-black">سلة المشتريات</h1>
    </div>

    @if ($items->isEmpty())
        <div class="text-center py-20 bg-white rounded-[2rem] shadow-sm">
            <span class="mx-auto h-28 w-28 rounded-full bg-brand-sky text-brand-blue flex items-center justify-center"><x-heroicon-o-shopping-bag class="w-16 h-16"/></span>
            <p class="mt-5 text-xl font-bold">سلتك فاضية!</p>
            <p class="text-slate-500 mt-1">ابدأ بإضافة منتجات حلوة لطفلك</p>
            <a href="{{ route('shop') }}" wire:navigate class="inline-flex items-center gap-3 mt-6 bg-brand-blue text-white font-extrabold px-8 py-4 rounded-2xl shadow-xl">
                <x-heroicon-o-arrow-right class="w-6 h-6"/>تصفح المنتجات
            </a>
        </div>
    @else
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                {{-- free shipping progress --}}
                <div class="bg-white rounded-3xl p-5 shadow-sm">
                    @if ($subtotal >= $freeOver)
                        <p class="flex items-center gap-2 font-bold text-green-600"><x-heroicon-s-check-circle class="w-7 h-7"/>مبروك! طلبك يحصل على شحن مجاني 🎉</p>
                    @else
                        <p class="flex items-center gap-2 font-bold"><x-heroicon-o-truck class="w-7 h-7 text-brand-blue"/>
                            أضف منتجات بقيمة <span class="text-brand-blue">{{ number_format($freeOver - $subtotal) }} {{ config('snefro.currency') }}</span> للحصول على شحن مجاني</p>
                    @endif
                    <div class="mt-3 h-3 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-l from-brand-green to-brand-blue transition-all duration-500" style="width: {{ min(100, round($subtotal / $freeOver * 100)) }}%"></div>
                    </div>
                </div>

                @foreach ($items as $item)
                    <div class="bg-white rounded-3xl p-4 shadow-sm flex gap-4" wire:key="item-{{ $item->key }}">
                        <a href="{{ route('product', $item->product->slug) }}" wire:navigate class="shrink-0">
                            <img src="{{ $item->product->image_url }}" class="w-24 h-28 md:w-28 md:h-32 object-cover rounded-2xl bg-brand-sky" alt="">
                        </a>
                        <div class="flex-1 min-w-0 flex flex-col">
                            <div class="flex items-start justify-between gap-2">
                                <a href="{{ route('product', $item->product->slug) }}" wire:navigate class="font-extrabold hover:text-brand-blue line-clamp-2">{{ $item->product->name }}</a>
                                <button wire:click="remove('{{ $item->key }}')" aria-label="حذف"
                                        class="shrink-0 h-11 w-11 rounded-2xl bg-red-50 text-brand-red hover:bg-brand-red hover:text-white flex items-center justify-center transition"><x-heroicon-o-trash class="w-6 h-6"/></button>
                            </div>
                            <div class="mt-1 flex flex-wrap gap-2 text-xs font-bold">
                                @if ($item->size)<span class="bg-sky-100 text-brand-blue px-2.5 py-1 rounded-full">المقاس: {{ $item->size }}</span>@endif
                                @if ($item->color)<span class="bg-slate-100 px-2.5 py-1 rounded-full flex items-center gap-1.5"><i class="inline-block h-3 w-3 rounded-full border" style="background: {{ \App\Models\Product::colorHex($item->color) }}"></i>{{ $item->color }}</span>@endif
                            </div>
                            <div class="mt-auto pt-3 flex items-center justify-between">
                                <div class="inline-flex items-center gap-1 bg-slate-50 border border-slate-200 rounded-2xl p-1">
                                    <button wire:click="decrement('{{ $item->key }}', {{ $item->qty }})" class="h-10 w-10 rounded-xl bg-white hover:bg-brand-red hover:text-white flex items-center justify-center transition"><x-heroicon-o-minus class="w-6 h-6"/></button>
                                    <span class="w-10 text-center font-black">{{ $item->qty }}</span>
                                    <button wire:click="increment('{{ $item->key }}', {{ $item->qty }})" class="h-10 w-10 rounded-xl bg-white hover:bg-brand-green hover:text-white flex items-center justify-center transition"><x-heroicon-o-plus class="w-6 h-6"/></button>
                                </div>
                                <p class="text-lg font-black text-brand-blue">{{ number_format($item->line_total) }} <small>{{ config('snefro.currency') }}</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <aside class="bg-white rounded-3xl p-6 shadow-sm h-fit space-y-4 lg:sticky lg:top-28">
                <h2 class="font-extrabold text-xl flex items-center gap-2"><x-heroicon-o-receipt-percent class="w-7 h-7 text-brand-orange"/>ملخص الطلب</h2>
                <div class="flex justify-between"><span class="text-slate-500">المجموع</span><span class="font-bold">{{ number_format($subtotal) }} {{ config('snefro.currency') }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">الشحن</span><span class="font-bold {{ $shipping == 0 ? 'text-green-600' : '' }}">{{ $shipping == 0 ? 'مجاني' : number_format($shipping).' '.config('snefro.currency') }}</span></div>
                <div class="flex justify-between border-t pt-4 text-xl font-black"><span>الإجمالي</span><span class="text-brand-blue">{{ number_format($total) }} {{ config('snefro.currency') }}</span></div>
                <a href="{{ route('checkout') }}" wire:navigate class="flex items-center justify-center gap-3 bg-brand-green hover:bg-green-600 text-white text-lg font-extrabold py-4 rounded-2xl shadow-xl shadow-green-200 transition">
                    <x-heroicon-o-credit-card class="w-8 h-8"/>إتمام الطلب
                </a>
                <p class="text-xs text-slate-500 text-center flex items-center justify-center gap-1"><x-heroicon-o-banknotes class="w-5 h-5"/>الدفع عند الاستلام</p>
            </aside>
        </div>
    @endif
</div>
