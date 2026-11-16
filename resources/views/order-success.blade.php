<x-layouts.app :title="'Order confirmed'">
    <div class="max-w-2xl mx-auto px-4 py-16">
        <div class="text-center">
            <div class="text-6xl">✅</div>
            <h1 class="text-3xl font-bold mt-4">Thank you, {{ $order->customer_name }}!</h1>
            <p class="text-stone-600 mt-2">Your order <strong>{{ $order->order_number }}</strong> has been received. We'll call you to confirm the delivery.</p>
        </div>

        <div class="mt-8 border rounded-xl divide-y">
            @foreach ($order->items as $item)
                <div class="p-4 flex justify-between text-sm">
                    <span>{{ $item->quantity }}× {{ $item->product_name }} <span class="text-stone-500">{{ $item->size }} {{ $item->color }}</span></span>
                    <span>{{ number_format($item->price * $item->quantity) }} EGP</span>
                </div>
            @endforeach
            <div class="p-4 flex justify-between text-sm"><span>Shipping</span><span>{{ number_format($order->shipping) }} EGP</span></div>
            <div class="p-4 flex justify-between font-bold"><span>Total (pay on delivery)</span><span>{{ number_format($order->total) }} EGP</span></div>
        </div>

        <div class="mt-6 text-sm text-stone-600">
            <p><strong>Deliver to:</strong> {{ $order->address }}, {{ $order->city }}</p>
            <p><strong>Phone:</strong> {{ $order->phone }}</p>
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('shop') }}" class="inline-block bg-stone-900 text-white px-6 py-3 rounded-lg">Continue shopping</a>
        </div>
    </div>
</x-layouts.app>
