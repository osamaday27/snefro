<div>
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h1 class="text-2xl font-black flex items-center gap-3"><x-heroicon-o-clipboard-document-list class="w-8 h-8 text-brand-rose"/>الطلبات</h1>
        <select wire:model.live="status" class="border px-4 py-3 text-sm bg-white border border-brand-line font-bold">
            <option value="">كل الحالات</option>
            @foreach ($statuses as $k => $l) <option value="{{ $k }}">{{ $l }}</option> @endforeach
        </select>
    </div>

    @php $colors = ['pending'=>'bg-amber-100 text-amber-800','processing'=>'bg-blue-100 text-blue-800','shipped'=>'bg-indigo-100 text-indigo-800','delivered'=>'bg-green-100 text-green-800','cancelled'=>'bg-red-100 text-red-800']; @endphp

    <div class="space-y-3">
        @forelse ($orders as $o)
            <div class="bg-white" wire:key="o-{{ $o->id }}">
                <div class="p-4 flex flex-wrap items-center gap-4 justify-between">
                    <button wire:click="toggle({{ $o->id }})" class="text-start flex items-center gap-3">
                        <span class="h-12 w-12 bg-brand-blush text-brand-rose flex items-center justify-center">
                            @if ($openId === $o->id)<x-heroicon-o-chevron-up class="w-6 h-6"/>@else<x-heroicon-o-chevron-down class="w-6 h-6"/>@endif</span>
                        <span><p class="font-extrabold">{{ $o->order_number }}</p>
                        <p class="text-xs text-neutral-500">{{ $o->created_at->format('Y/m/d - H:i') }} · {{ $o->customer_name }}</p></span>
                    </button>
                    <p class="font-black text-lg">{{ number_format($o->total) }} {{ config('snefro.currency') }}</p>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold px-3 py-1.5 {{ $colors[$o->status] ?? '' }}">{{ $o->status_label }}</span>
                        <select wire:change="changeStatus({{ $o->id }}, $event.target.value)" class="border px-3 py-2 text-sm bg-white border border-brand-line font-semibold">
                            @foreach ($statuses as $k => $l) <option value="{{ $k }}" @selected($o->status === $k)>{{ $l }}</option> @endforeach
                        </select>
                    </div>
                </div>

                @if ($openId === $o->id)
                    <div class="border-t p-5 grid md:grid-cols-2 gap-6 text-sm">
                        <div class="space-y-2">
                            <p class="font-extrabold mb-2">بيانات العميل</p>
                            <p class="flex items-center gap-2"><x-heroicon-o-user class="w-5 h-5 text-slate-400"/>{{ $o->customer_name }}</p>
                            <p class="flex items-center gap-2"><x-heroicon-o-phone class="w-5 h-5 text-slate-400"/><span dir="ltr">{{ $o->phone }}</span></p>
                            @if ($o->email) <p class="flex items-center gap-2"><x-heroicon-o-envelope class="w-5 h-5 text-slate-400"/>{{ $o->email }}</p> @endif
                            <p class="flex items-start gap-2"><x-heroicon-o-map-pin class="w-5 h-5 text-slate-400 shrink-0"/>{{ $o->city }} - {{ $o->address }}</p>
                            @if ($o->notes) <p class="text-neutral-500 bg-brand-mist p-3">«{{ $o->notes }}»</p> @endif
                            <a href="https://wa.me/{{ $o->whatsapp }}?text={{ urlencode('مرحباً '.$o->customer_name.'، بخصوص طلبك رقم '.$o->order_number.' من سنفرو للأطفال') }}" target="_blank"
                               class="inline-flex items-center gap-2 bg-[#25D366] text-white font-bold px-5 py-2.5 mt-2"><x-whatsapp-icon class="w-6 h-6"/>مراسلة العميل</a>
                        </div>
                        <div>
                            <p class="font-extrabold mb-2">المنتجات</p>
                            @foreach ($o->items as $item)
                                <div class="flex justify-between gap-3 py-1.5">
                                    <span><strong>{{ $item->quantity }}×</strong> {{ $item->product_name }} <span class="text-neutral-500">{{ \App\Models\Product::unit($item->size) }} {{ \App\Models\Product::colorLabel($item->color) }}</span></span>
                                    <span class="font-bold">{{ number_format($item->price * $item->quantity) }}</span>
                                </div>
                            @endforeach
                            <div class="flex justify-between border-t mt-2 pt-2"><span class="text-neutral-500">الشحن</span><span>{{ number_format($o->shipping) }}</span></div>
                            <div class="flex justify-between font-black text-base"><span>الإجمالي (دفع عند الاستلام)</span><span>{{ number_format($o->total) }} {{ config('snefro.currency') }}</span></div>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white p-12 text-center text-neutral-500">لا توجد طلبات.</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $orders->links('pagination.arabic') }}</div>
</div>
