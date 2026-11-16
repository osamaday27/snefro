<div>
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        @foreach ([
            ['Revenue', number_format($revenue).' EGP', 'bg-amber-500 text-stone-900'],
            ['Orders', $ordersCount, 'bg-white'],
            ['Pending', $pendingCount, 'bg-white'],
            ['Products', $productsCount, 'bg-white'],
            ['Categories', $categoriesCount, 'bg-white'],
        ] as [$label, $value, $cls])
            <div class="rounded-xl p-5 shadow-sm {{ $cls }}">
                <p class="text-xs uppercase tracking-wide opacity-70">{{ $label }}</p>
                <p class="text-2xl font-bold mt-1">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mt-8">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm">
            <div class="px-5 py-4 border-b flex justify-between"><h2 class="font-semibold">Recent orders</h2>
                <a href="{{ route('admin.orders') }}" wire:navigate class="text-sm text-amber-600">View all</a></div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-stone-500"><tr><th class="px-5 py-2">Order</th><th>Customer</th><th>Total</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse ($recentOrders as $o)
                        <tr class="border-t"><td class="px-5 py-3 font-medium">{{ $o->order_number }}</td><td>{{ $o->customer_name }}</td>
                            <td>{{ number_format($o->total) }} EGP</td><td><span class="capitalize">{{ $o->status }}</span></td></tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-6 text-center text-stone-500">No orders yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-5 py-4 border-b"><h2 class="font-semibold">Low stock</h2></div>
            <ul class="divide-y text-sm">
                @forelse ($lowStock as $p)
                    <li class="px-5 py-3 flex justify-between"><span class="truncate">{{ $p->name }}</span>
                        <span class="{{ $p->stock == 0 ? 'text-red-600' : 'text-amber-600' }} font-semibold">{{ $p->stock }}</span></li>
                @empty
                    <li class="px-5 py-6 text-center text-stone-500">All good 👍</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
