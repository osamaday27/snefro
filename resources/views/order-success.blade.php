<x-layouts.app :title="__('Order received')">
    @php $waText = __('Hello Snefro for Kids, I would like to ask about my order').': '.$order->order_number; @endphp
    <div class="max-w-2xl mx-auto px-4 py-16">
        <div class="text-center">
            <span class="mx-auto h-24 w-24 bg-brand-pink flex items-center justify-center animate-float"><x-heroicon-o-check class="w-14 h-14"/></span>
            <h1 class="text-3xl md:text-4xl font-bold mt-7">{{ __('Thank you, :name!', ['name' => $order->customer_name]) }}</h1>
            <p class="text-neutral-600 mt-3 leading-relaxed">{{ __('Your order :number has been received. We will contact you soon to confirm delivery.', ['number' => $order->order_number]) }}</p>
        </div>

        <div class="mt-10 border border-brand-line divide-y divide-brand-line">
            @foreach ($order->items as $item)
                <div class="p-4 flex justify-between gap-3 text-sm">
                    <span><strong>{{ $item->quantity }}×</strong> {{ $item->product ? $item->product->tr('name') : $item->product_name }}
                        <span class="text-neutral-500">{{ \App\Models\Product::unit($item->size) }} {{ \App\Models\Product::colorLabel($item->color) }}</span></span>
                    <span class="font-semibold">{{ number_format($item->price * $item->quantity) }} {{ __('EGP') }}</span>
                </div>
            @endforeach
            <div class="p-4 flex justify-between text-sm"><span class="text-neutral-500">{{ __('Shipping') }}</span><span class="font-semibold">{{ $order->shipping > 0 ? number_format($order->shipping).' '.__('EGP') : __('Free') }}</span></div>
            <div class="p-4 flex justify-between text-lg font-bold bg-brand-blush"><span>{{ __('Total (pay on delivery)') }}</span><span>{{ number_format($order->total) }} {{ __('EGP') }}</span></div>
        </div>

        <div class="mt-6 border border-brand-line p-5 text-sm space-y-2">
            <p class="flex items-center gap-2"><x-heroicon-o-map-pin class="w-6 h-6 text-brand-rose"/><strong>{{ __('Address') }}:</strong> {{ $order->address }} - {{ $order->city }}</p>
            <p class="flex items-center gap-2"><x-heroicon-o-phone class="w-6 h-6 text-brand-rose"/><strong>{{ __('Phone') }}:</strong> <span dir="ltr">{{ $order->phone }}</span></p>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row gap-3">
            <a href="https://wa.me/{{ config('snefro.whatsapp') }}?text={{ urlencode($waText) }}" target="_blank"
               class="flex-1 inline-flex items-center justify-center gap-3 bg-[#25D366] text-white font-semibold py-4 hover:opacity-90 transition"><x-whatsapp-icon class="w-7 h-7"/>{{ __('Track your order on WhatsApp') }}</a>
            <a href="{{ route('shop') }}" class="flex-1 inline-flex items-center justify-center gap-3 bg-brand-ink text-white font-semibold py-4 hover:bg-brand-rose transition"><x-heroicon-o-shopping-bag class="w-7 h-7"/>{{ __('Continue shopping') }}</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <script>
        window.addEventListener('load', () => {
            const end = Date.now() + 1600, colors = ['#111111', '#F6B3C8', '#D9648F', '#CFCFCF'];
            (function frame() {
                confetti({ particleCount: 5, angle: 60, spread: 70, origin: { x: 0 }, colors: colors, shapes: ['square'] });
                confetti({ particleCount: 5, angle: 120, spread: 70, origin: { x: 1 }, colors: colors, shapes: ['square'] });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
        });
    </script>
</x-layouts.app>
