<div>
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h1 class="text-2xl font-bold">Orders</h1>
        <select wire:model.live="status" class="rounded-lg border border-stone-300 px-3 py-2 text-sm bg-white">
            <option value="">All statuses</option>
            @foreach ($statuses as $s) <option value="{{ $s }}" class="capitalize">{{ ucfirst($s) }}</option> @endforeach
        </select>
    </div>

    @php
        $colors = ['pending'=>'bg-amber-100 text-amber-800','processing'=>'bg-blue-100 text-blue-800','shipped'=>'bg-indigo-100 text-indigo-800','delivered'=>'bg-green-100 text-green-800','cancelled'=>'bg-red-100 text-red-800'];
    @endphp

    <div class="space-y-3">
        @forelse ($orders as $o)
            <div class="bg-white rounded-xl shadow-sm" wire:key="o-{{ $o->id }}">
                <div class="p-4 flex flex-wrap items-center gap-4 justify-between">
                    <button wire:click="toggle({{ $o->id }})" class="text-left">
                        <p class="font-semibold">{{ $o->order_number }}</p>
                        <p class="text-xs text-stone-500">{{ $o->created_at->format('d M Y, H:i') }} · {{ $o->customer_name }}</p>
                    </button>
                    <p class="font-bold">{{ number_format($o->total) }} EGP</p>
                    <div class="flex items-center gap-2">
                        <span class="text-xs px-2 py-1 rounded-full capitalize {{ $colors[$o->status] ?? '' }}">{{ $o->status }}</span>
                        <select wire:change="changeStatus({{ $o->id }}, $event.target.value)" class="rounded-lg border border-stone-300 px-2 py-1 text-sm bg-white">
                            @foreach ($statuses as $s)
                                <option value="{{ $s }}" @selected($o->status === $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if ($openId === $o->id)
                    <div class="border-t p-4 grid md:grid-cols-2 gap-6 text-sm">
                        <div class="space-y-1">
                            <p class="font-semibold mb-1">Customer</p>
                            <p>{{ $o->customer_name }}</p>
                            <p>📞 {{ $o->phone }}</p>
                            @if ($o->email) <p>✉️ {{ $o->email }}</p> @endif
                            <p>📍 {{ $o->address }}, {{ $o->city }}</p>
                            @if ($o->notes) <p class="text-stone-500">“{{ $o->notes }}”</p> @endif
                            <p class="text-xs text-stone-500 mt-2">Payment: Cash on delivery</p>
                        </div>
                        <div>
                            <p class="font-semibold mb-1">Items</p>
                            @foreach ($o->items as $item)
                                <div class="flex justify-between py-1">
                                    <span>{{ $item->quantity }}× {{ $item->product_name }} <span class="text-stone-500">{{ $item->size }} {{ $item->color }}</span></span>
                                    <span>{{ number_format($item->price * $item->quantity) }}</span>
                                </div>
                            @endforeach
                            <div class="flex justify-between border-t mt-2 pt-2"><span>Shipping</span><span>{{ number_format($o->shipping) }}</span></div>
                            <div class="flex justify-between font-bold"><span>Total</span><span>{{ number_format($o->total) }} EGP</span></div>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-xl p-10 text-center text-stone-500">No orders found.</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $orders->links() }}</div>
</div>
