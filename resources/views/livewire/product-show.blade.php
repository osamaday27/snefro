<div class="max-w-7xl mx-auto px-4 py-10">
    <nav class="text-sm text-stone-500 mb-6">
        <a href="{{ route('home') }}" wire:navigate class="hover:underline">Home</a> /
        <a href="{{ route('shop') }}" wire:navigate class="hover:underline">Shop</a> /
        <span class="text-stone-900">{{ $product->name }}</span>
    </nav>

    <div class="grid md:grid-cols-2 gap-10">
        {{-- Gallery --}}
        <div>
            @php $gallery = $product->gallery; @endphp
            <div class="aspect-[4/5] rounded-xl overflow-hidden bg-stone-100">
                <img src="{{ $gallery[$activeImage] ?? $gallery[0] }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            </div>
            @if (count($gallery) > 1)
                <div class="mt-3 grid grid-cols-5 gap-2">
                    @foreach ($gallery as $i => $img)
                        <button wire:click="$set('activeImage', {{ $i }})" wire:key="g-{{ $i }}"
                                class="aspect-square rounded-lg overflow-hidden border-2 {{ $activeImage === $i ? 'border-amber-500' : 'border-transparent' }}">
                            <img src="{{ $img }}" class="w-full h-full object-cover" alt="">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div>
            <p class="text-sm text-stone-500">{{ $product->category?->name }}</p>
            <h1 class="text-3xl font-bold mt-1">{{ $product->name }}</h1>

            <p class="mt-3 text-2xl">
                <span class="font-bold">{{ number_format($product->final_price) }} EGP</span>
                @if ($product->on_sale)
                    <span class="text-stone-400 line-through text-lg ml-2">{{ number_format($product->price) }}</span>
                @endif
            </p>

            <p class="mt-4 text-stone-600 leading-relaxed">{{ $product->description }}</p>

            @if (! empty($product->sizes))
                <div class="mt-6">
                    <p class="text-sm font-semibold mb-2">Size</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($product->sizes as $s)
                            <button wire:click="$set('size', '{{ $s }}')" wire:key="s-{{ $s }}"
                                    class="min-w-12 px-4 py-2 rounded-lg border text-sm {{ $size === $s ? 'bg-stone-900 text-white border-stone-900' : 'border-stone-300 hover:border-stone-900' }}">{{ $s }}</button>
                        @endforeach
                    </div>
                    @error('size') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            @endif

            @if (! empty($product->colors))
                <div class="mt-6">
                    <p class="text-sm font-semibold mb-2">Color</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($product->colors as $c)
                            <button wire:click="$set('color', '{{ $c }}')" wire:key="c-{{ $c }}"
                                    class="px-4 py-2 rounded-lg border text-sm {{ $color === $c ? 'bg-stone-900 text-white border-stone-900' : 'border-stone-300 hover:border-stone-900' }}">{{ $c }}</button>
                        @endforeach
                    </div>
                    @error('color') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            @endif

            <div class="mt-6">
                <p class="text-sm font-semibold mb-2">Quantity</p>
                <div class="inline-flex items-center border border-stone-300 rounded-lg">
                    <button wire:click="decrement" class="w-10 h-10 text-lg hover:bg-stone-100 rounded-l-lg">−</button>
                    <span class="w-12 text-center font-medium">{{ $qty }}</span>
                    <button wire:click="increment" class="w-10 h-10 text-lg hover:bg-stone-100 rounded-r-lg">+</button>
                </div>
                <span class="ml-3 text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $product->stock > 0 ? $product->stock.' in stock' : 'Out of stock' }}
                </span>
                @error('stock') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button wire:click="addToCart" wire:loading.attr="disabled" @disabled($product->stock < 1)
                    class="mt-8 w-full bg-stone-900 hover:bg-stone-700 disabled:opacity-40 text-white font-semibold py-4 rounded-lg transition">
                <span wire:loading.remove wire:target="addToCart">Add to cart</span>
                <span wire:loading wire:target="addToCart">Adding...</span>
            </button>

            @if ($added)
                <div class="mt-4 rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm flex justify-between items-center">
                    <span>✓ Added to your cart.</span>
                    <a href="{{ route('cart') }}" wire:navigate class="font-semibold underline">View cart</a>
                </div>
            @endif
        </div>
    </div>
</div>
