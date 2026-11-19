<div>
    <h1 class="text-2xl font-black mb-6 flex items-center gap-3"><x-heroicon-o-chart-bar class="w-8 h-8 text-brand-rose"/>لوحة التحكم</h1>

    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        @foreach ([
            ['الإيرادات', number_format($revenue).' '.config('snefro.currency'), 'currency-dollar', 'bg-brand-ink'],
            ['الطلبات', $ordersCount, 'clipboard-document-list', 'bg-brand-ink'],
            ['قيد المراجعة', $pendingCount, 'clock', 'bg-brand-rose'],
            ['المنتجات', $productsCount, 'cube', 'bg-brand-pink'],
            ['الأقسام', $categoriesCount, 'squares-2x2', 'bg-red-600'],
        ] as [$label, $value, $icon, $bg])
            <div class="p-5 bg-white border border-brand-line flex items-center gap-4">
                <span class="h-14 w-14 {{ $bg }} text-white flex items-center justify-center shrink-0">@svg('heroicon-o-'.$icon, 'w-8 h-8')</span>
                <div class="min-w-0"><p class="text-xs text-neutral-500 font-bold">{{ $label }}</p><p class="text-xl font-black truncate">{{ $value }}</p></div>
            </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mt-8">
        <div class="lg:col-span-2 bg-white border border-brand-line">
            <div class="px-6 py-4 border-b flex justify-between items-center"><h2 class="font-extrabold">أحدث الطلبات</h2>
                <a href="{{ route('admin.orders') }}" wire:navigate class="text-sm font-bold text-brand-rose">عرض الكل</a></div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-start text-neutral-500"><tr class="text-start"><th class="px-6 py-3 text-start">الطلب</th><th class="text-start">العميل</th><th class="text-start">الإجمالي</th><th class="text-start">الحالة</th></tr></thead>
                    <tbody>
                    @forelse ($recentOrders as $o)
                        <tr class="border-t"><td class="px-6 py-3 font-bold">{{ $o->order_number }}</td><td>{{ $o->customer_name }}</td>
                            <td>{{ number_format($o->total) }} {{ config('snefro.currency') }}</td><td>{{ $o->status_label }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-neutral-500">لا توجد طلبات بعد.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white">
            <div class="px-6 py-4 border-b"><h2 class="font-extrabold flex items-center gap-2"><x-heroicon-o-exclamation-triangle class="w-6 h-6 text-brand-rose"/>مخزون منخفض</h2></div>
            <ul class="divide-y text-sm">
                @forelse ($lowStock as $p)
                    <li class="px-6 py-3 flex justify-between gap-2"><span class="truncate">{{ $p->name }}</span>
                        <span class="{{ $p->stock == 0 ? 'text-red-600' : 'text-brand-rose' }} font-black">{{ $p->stock }}</span></li>
                @empty
                    <li class="px-6 py-8 text-center text-neutral-500">كل المنتجات متوفرة 👍</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
