@php $in = 'mt-1.5 w-full border border-brand-line ps-12 pe-4 py-3.5 bg-white focus:outline-none focus:border-brand-ink transition'; @endphp
<div class="max-w-7xl mx-auto px-4 py-12">
    <div data-reveal class="mb-10">
        <h1 class="text-3xl md:text-4xl font-bold">{{ __('Checkout') }}</h1>
        <span class="title-line mt-4"></span>
    </div>

    @error('cart')
        <div class="mb-6 border border-red-200 bg-red-50 text-red-700 px-5 py-4 font-semibold flex items-center gap-2"><x-heroicon-o-exclamation-triangle class="w-6 h-6"/>{{ $message }}</div>
    @enderror

    <div class="grid lg:grid-cols-3 gap-8">
        <form wire:submit="placeOrder" class="lg:col-span-2 border border-brand-line p-6 md:p-8 space-y-5">
            <h2 class="font-bold text-xl flex items-center gap-2"><x-heroicon-o-map-pin class="w-7 h-7 text-brand-rose"/>{{ __('Delivery details') }}</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-sm">{{ __('Full name') }} *</label>
                    <div class="relative"><x-heroicon-o-user class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-neutral-400"/>
                        <input type="text" wire:model="customer_name" class="{{ $in }}"></div>
                    @error('customer_name') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="font-semibold text-sm">{{ __('Mobile number') }} *</label>
                    <div class="relative"><x-heroicon-o-phone class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-neutral-400"/>
                        <input type="tel" dir="ltr" wire:model="phone" class="{{ $in }} text-start" placeholder="01XXXXXXXXX"></div>
                    @error('phone') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="font-semibold text-sm">{{ __('Email (optional)') }}</label>
                <div class="relative"><x-heroicon-o-envelope class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-neutral-400"/>
                    <input type="email" dir="ltr" wire:model="email" class="{{ $in }} text-start" placeholder="name@example.com"></div>
                @error('email') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="font-semibold text-sm">{{ __('Governorate') }} *</label>
                    <div class="relative"><x-heroicon-o-building-office-2 class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-neutral-400 pointer-events-none"/>
                        <select wire:model="city" class="{{ $in }} appearance-none">
                            <option value="">{{ __('Choose governorate') }}</option>
                            @foreach ($governorates as $key => $name) <option value="{{ $key }}">{{ $name }}</option> @endforeach
                        </select></div>
                    @error('city') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="font-semibold text-sm">{{ __('Detailed address') }} *</label>
                    <div class="relative"><x-heroicon-o-home-modern class="w-6 h-6 absolute top-1/2 -translate-y-1/2 start-4 text-neutral-400"/>
                        <input type="text" wire:model="address" class="{{ $in }}" placeholder="{{ __('City / district / street / building') }}"></div>
                    @error('address') <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="font-semibold text-sm">{{ __('Order notes') }}</label>
                <textarea wire:model="notes" rows="3" class="mt-1.5 w-full border border-brand-line px-4 py-3 focus:outline-none focus:border-brand-ink transition" placeholder="{{ __('Any extra delivery details...') }}"></textarea>
            </div>

            <div class="bg-brand-blush border border-brand-pink px-5 py-4 flex items-center gap-4">
                <x-heroicon-o-banknotes class="w-10 h-10 shrink-0 text-brand-rose"/>
                <div><p class="font-bold">{{ __('Cash on delivery') }}</p><p class="text-sm text-neutral-600">{{ __('Pay in cash to the courier after you receive and check your order.') }}</p></div>
            </div>

            <button type="submit" wire:loading.attr="disabled" class="w-full inline-flex items-center justify-center gap-3 bg-brand-ink hover:bg-brand-rose disabled:opacity-60 text-white text-lg font-semibold py-4 transition">
                <x-heroicon-o-check-badge class="w-7 h-7" wire:loading.remove wire:target="placeOrder"/>
                <x-heroicon-o-arrow-path class="w-7 h-7 animate-spin" wire:loading wire:target="placeOrder"/>
                <span wire:loading.remove wire:target="placeOrder">{{ __('Confirm order') }} · {{ number_format($total) }} {{ __('EGP') }}</span>
                <span wire:loading wire:target="placeOrder">{{ __('Placing your order...') }}</span>
            </button>
        </form>

        <aside class="border border-brand-line p-6 h-fit space-y-4 lg:sticky lg:top-28">
            <h2 class="font-bold text-xl">{{ __('Your order') }}</h2>
            <div class="space-y-3 max-h-80 overflow-y-auto">
                @foreach ($items as $item)
                    <div class="flex items-center gap-3" wire:key="co-{{ $item->key }}">
                        <div class="relative shrink-0"><img src="{{ $item->product->image_url }}" class="h-16 w-14 object-cover bg-brand-mist" alt="">
                            <span class="absolute -top-2 -start-2 h-5 min-w-5 px-1 bg-brand-ink text-white text-[11px] font-bold flex items-center justify-center">{{ $item->qty }}</span></div>
                        <div class="flex-1 min-w-0"><p class="text-sm font-semibold truncate">{{ $item->product->tr('name') }}</p>
                            <p class="text-xs text-neutral-500">{{ \App\Models\Product::unit($item->size) }} {{ $item->color ? '· '.\App\Models\Product::colorLabel($item->color) : '' }}</p></div>
                        <span class="text-sm font-bold">{{ number_format($item->line_total) }}</span>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-brand-line pt-4 space-y-2">
                <div class="flex justify-between text-sm"><span class="text-neutral-500">{{ __('Subtotal') }}</span><span class="font-semibold">{{ number_format($subtotal) }} {{ __('EGP') }}</span></div>
                <div class="flex justify-between text-sm"><span class="text-neutral-500">{{ __('Shipping') }}</span><span class="font-semibold {{ $shipping == 0 ? 'text-green-700' : '' }}">{{ $shipping == 0 ? __('Free') : number_format($shipping).' '.__('EGP') }}</span></div>
                <div class="flex justify-between text-xl font-bold pt-3 border-t border-brand-line"><span>{{ __('Total') }}</span><span>{{ number_format($total) }} {{ __('EGP') }}</span></div>
            </div>
        </aside>
    </div>
</div>
