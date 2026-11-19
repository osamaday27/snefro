<div class="max-w-7xl mx-auto px-4 py-12">
    <div data-reveal class="mb-10">
        <h1 class="text-3xl md:text-4xl font-bold">{{ __('Shopping cart') }}</h1>
        <span class="title-line mt-4"></span>
    </div>

    @if ($items->isEmpty())
        <div class="text-center py-24 border border-brand-line">
            <x-heroicon-o-shopping-bag class="w-20 h-20 mx-auto text-neutral-300 animate-float"/>
            <p class="mt-5 text-xl font-bold">{{ __('Your cart is empty') }}</p>
            <p class="text-neutral-500 mt-1">{{ __('Start adding lovely items for your kid') }}</p>
            <a href="{{ route('shop') }}" wire:navigate class="group inline-flex items-center gap-3 mt-7 bg-brand-ink text-white font-semibold px-8 py-4 hover:bg-brand-rose transition">
                {{ __('Browse products') }}<x-heroicon-o-arrow-long-right class="w-6 h-6 rtl:rotate-180 transition-transform group-hover:translate-x-1 rtl:group-hover:-translate-x-1"/>
            </a>
        </div>
    @else
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                <div class="border border-brand-line p-5">
                    @if ($subtotal >= $freeOver)
                        <p class="flex items-center gap-2 font-semibold text-green-700"><x-heroicon-s-check-circle class="w-7 h-7"/>{{ __('You get free shipping!') }}</p>
                    @else
                        <p class="flex items-center gap-2 font-semibold"><x-heroicon-o-truck class="w-7 h-7 text-brand-rose"/>{{ __('Add :amount EGP more to get free shipping', ['amount' => number_format($freeOver - $subtotal)]) }}</p>
                    @endif
                    <div class="mt-3 h-1.5 bg-brand-mist"><div class="h-full bg-brand-pink transition-all duration-700" style="width: {{ min(100, round($subtotal / $freeOver * 100)) }}%"></div></div>
                </div>

                @foreach ($items as $item)
                    <div class="border border-brand-line p-4 flex gap-4 animate-fadeup" wire:key="item-{{ $item->key }}">
                        <a href="{{ route('product', $item->product->slug) }}" wire:navigate class="shrink-0 overflow-hidden">
                            <img src="{{ $item->product->image_url }}" class="w-24 h-28 md:w-28 md:h-36 object-cover bg-brand-mist transition duration-500 hover:scale-105" alt="">
                        </a>
                        <div class="flex-1 min-w-0 flex flex-col">
                            <div class="flex items-start justify-between gap-2">
                                <a href="{{ route('product', $item->product->slug) }}" wire:navigate class="font-semibold hover:text-brand-rose transition line-clamp-2">{{ $item->product->tr('name') }}</a>
                                <button wire:click="remove('{{ $item->key }}')" aria-label="{{ __('Remove') }}"
                                        class="shrink-0 h-11 w-11 border border-brand-line text-neutral-500 hover:bg-red-600 hover:text-white hover:border-red-600 flex items-center justify-center transition"><x-heroicon-o-trash class="w-6 h-6"/></button>
                            </div>
                            <div class="mt-2 flex flex-wrap gap-2 text-xs font-medium">
                                @if ($item->size)<span class="bg-brand-mist px-2.5 py-1">{{ __('Size') }}: {{ \App\Models\Product::unit($item->size) }}</span>@endif
                                @if ($item->color)<span class="bg-brand-mist px-2.5 py-1 flex items-center gap-1.5"><i class="inline-block h-3 w-3 border border-brand-line" style="background: {{ \App\Models\Product::colorHex($item->color) }}"></i>{{ \App\Models\Product::colorLabel($item->color) }}</span>@endif
                            </div>
                            <div class="mt-auto pt-3 flex items-center justify-between">
                                <div class="inline-flex items-center border border-brand-line">
                                    <button wire:click="decrement('{{ $item->key }}', {{ $item->qty }})" class="h-11 w-11 hover:bg-brand-ink hover:text-white flex items-center justify-center transition"><x-heroicon-o-minus class="w-6 h-6"/></button>
                                    <span class="w-10 text-center font-bold">{{ $item->qty }}</span>
                                    <button wire:click="increment('{{ $item->key }}', {{ $item->qty }})" class="h-11 w-11 hover:bg-brand-ink hover:text-white flex items-center justify-center transition"><x-heroicon-o-plus class="w-6 h-6"/></button>
                                </div>
                                <p class="text-lg font-bold">{{ number_format($item->line_total) }} <small class="text-xs font-semibold">{{ __('EGP') }}</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <aside class="border border-brand-line p-6 h-fit space-y-4 lg:sticky lg:top-28">
                <h2 class="font-bold text-xl">{{ __('Order summary') }}</h2>
                <div class="flex justify-between"><span class="text-neutral-500">{{ __('Subtotal') }}</span><span class="font-semibold">{{ number_format($subtotal) }} {{ __('EGP') }}</span></div>
                <div class="flex justify-between"><span class="text-neutral-500">{{ __('Shipping') }}</span><span class="font-semibold {{ $shipping == 0 ? 'text-green-700' : '' }}">{{ $shipping == 0 ? __('Free') : number_format($shipping).' '.__('EGP') }}</span></div>
                <div class="flex justify-between border-t border-brand-line pt-4 text-xl font-bold"><span>{{ __('Total') }}</span><span>{{ number_format($total) }} {{ __('EGP') }}</span></div>
                <a href="{{ route('checkout') }}" wire:navigate class="group flex items-center justify-center gap-3 bg-brand-ink hover:bg-brand-rose text-white text-lg font-semibold py-4 transition">
                    <x-heroicon-o-credit-card class="w-7 h-7"/>{{ __('Checkout') }}
                </a>
                <p class="text-xs text-neutral-500 text-center flex items-center justify-center gap-1"><x-heroicon-o-banknotes class="w-5 h-5"/>{{ __('Payment: cash on delivery') }}</p>
            </aside>
        </div>
    @endif
</div>
