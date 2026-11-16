<x-layouts.app :title="'تم استلام طلبك'">
    @php $waText = "مرحباً سنفرو للأطفال 👋\nأود الاستفسار عن طلبي رقم: {$order->order_number}"; @endphp
    <div class="max-w-2xl mx-auto px-4 py-14">
        <div class="text-center">
            <span class="mx-auto h-28 w-28 rounded-full bg-brand-green text-white flex items-center justify-center shadow-2xl shadow-green-200 animate-float"><x-heroicon-o-check class="w-16 h-16"/></span>
            <h1 class="text-3xl md:text-4xl font-black mt-6">شكراً لك يا {{ $order->customer_name }}! 🎉</h1>
            <p class="text-slate-600 mt-3 leading-relaxed">تم استلام طلبك رقم <strong class="text-brand-blue">{{ $order->order_number }}</strong>.<br>سنتواصل معك قريباً لتأكيد موعد التوصيل.</p>
        </div>

        <div class="mt-10 bg-white rounded-3xl shadow-sm overflow-hidden">
            <div class="divide-y">
                @foreach ($order->items as $item)
                    <div class="p-4 flex justify-between gap-3 text-sm">
                        <span><strong>{{ $item->quantity }}×</strong> {{ $item->product_name }} <span class="text-slate-500">{{ $item->size }} {{ $item->color }}</span></span>
                        <span class="font-bold">{{ number_format($item->price * $item->quantity) }} {{ config('snefro.currency') }}</span>
                    </div>
                @endforeach
                <div class="p-4 flex justify-between text-sm"><span class="text-slate-500">الشحن</span><span class="font-bold">{{ $order->shipping > 0 ? number_format($order->shipping).' '.config('snefro.currency') : 'مجاني' }}</span></div>
                <div class="p-4 flex justify-between text-lg font-black bg-brand-sky"><span>الإجمالي (يُدفع عند الاستلام)</span><span class="text-brand-blue">{{ number_format($order->total) }} {{ config('snefro.currency') }}</span></div>
            </div>
        </div>

        <div class="mt-6 bg-white rounded-3xl shadow-sm p-5 text-sm space-y-2">
            <p class="flex items-center gap-2"><x-heroicon-o-map-pin class="w-6 h-6 text-brand-orange"/><strong>العنوان:</strong> {{ $order->address }} - {{ $order->city }}</p>
            <p class="flex items-center gap-2"><x-heroicon-o-phone class="w-6 h-6 text-brand-blue"/><strong>الهاتف:</strong> <span dir="ltr">{{ $order->phone }}</span></p>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row gap-3">
            <a href="https://wa.me/{{ config('snefro.whatsapp') }}?text={{ urlencode($waText) }}" target="_blank"
               class="flex-1 inline-flex items-center justify-center gap-3 bg-[#25D366] text-white font-extrabold py-4 rounded-2xl shadow-xl shadow-green-200"><x-whatsapp-icon class="w-8 h-8"/>تابع طلبك على واتساب</a>
            <a href="{{ route('shop') }}" class="flex-1 inline-flex items-center justify-center gap-3 bg-brand-blue text-white font-extrabold py-4 rounded-2xl shadow-xl shadow-sky-200"><x-heroicon-o-shopping-bag class="w-8 h-8"/>متابعة التسوق</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <script>
        window.addEventListener('load', () => {
            const end = Date.now() + 1800;
            (function frame() {
                confetti({ particleCount: 6, angle: 60, spread: 70, origin: { x: 0 }, colors: ['#3b9ae1','#f7c948','#ef4b4b','#4cb963','#f5922f','#8a4fbf'] });
                confetti({ particleCount: 6, angle: 120, spread: 70, origin: { x: 1 }, colors: ['#3b9ae1','#f7c948','#ef4b4b','#4cb963','#f5922f','#8a4fbf'] });
                if (Date.now() < end) requestAnimationFrame(frame);
            })();
        });
    </script>
</x-layouts.app>
