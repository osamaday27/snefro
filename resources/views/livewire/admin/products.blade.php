<div>
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h1 class="text-2xl font-bold">Products</h1>
        <div class="flex gap-3">
            <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search..." class="rounded-lg border border-stone-300 px-3 py-2 text-sm">
            <button wire:click="create" class="bg-stone-900 text-white px-4 py-2 rounded-lg text-sm">+ New product</button>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm">{{ session('success') }}</div>
    @endif

    {{-- Form --}}
    @if ($showForm)
        <form wire:submit="save" class="bg-white rounded-xl shadow-sm p-6 mb-8 space-y-5">
            <h2 class="font-semibold text-lg">{{ $editingId ? 'Edit product' : 'New product' }}</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium">Name *</label>
                    <input type="text" wire:model="name" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5">
                    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium">Category</label>
                    <select wire:model="category_id" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5 bg-white">
                        <option value="">— None —</option>
                        @foreach ($categories as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                    </select>
                    @error('category_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="text-sm font-medium">Price (EGP) *</label>
                    <input type="number" step="0.01" wire:model="price" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5">
                    @error('price') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium">Sale price</label>
                    <input type="number" step="0.01" wire:model="sale_price" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5">
                    @error('sale_price') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-medium">Stock *</label>
                    <input type="number" wire:model="stock" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5">
                    @error('stock') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium">Sizes <span class="text-stone-400 font-normal">(comma separated)</span></label>
                    <input type="text" wire:model="sizes" placeholder="S, M, L, XL" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5">
                </div>
                <div>
                    <label class="text-sm font-medium">Colors <span class="text-stone-400 font-normal">(comma separated)</span></label>
                    <input type="text" wire:model="colors" placeholder="Black, White" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5">
                </div>
            </div>

            <div>
                <label class="text-sm font-medium">Description</label>
                <textarea wire:model="description" rows="4" class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2.5"></textarea>
            </div>

            <div>
                <label class="text-sm font-medium">Images <span class="text-stone-400 font-normal">(first image is the main one · max 2MB each)</span></label>
                <input type="file" wire:model="photos" multiple accept="image/*" class="mt-1 block w-full text-sm">
                <div wire:loading wire:target="photos" class="text-xs text-stone-500 mt-1">Uploading...</div>
                @error('photos.*') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror

                <div class="mt-3 flex flex-wrap gap-3">
                    @foreach ($existing as $i => $img)
                        <div class="relative" wire:key="ex-{{ $i }}">
                            <img src="{{ \App\Models\Product::urlFor($img) }}" class="w-20 h-24 object-cover rounded-lg">
                            <button type="button" wire:click="removeExisting({{ $i }})" class="absolute -top-2 -right-2 bg-red-600 text-white w-5 h-5 text-xs rounded-full">✕</button>
                        </div>
                    @endforeach
                    @foreach ($photos as $i => $photo)
                        <div class="relative" wire:key="new-{{ $i }}">
                            <img src="{{ $photo->temporaryUrl() }}" class="w-20 h-24 object-cover rounded-lg ring-2 ring-amber-500">
                            <button type="button" wire:click="removePhoto({{ $i }})" class="absolute -top-2 -right-2 bg-red-600 text-white w-5 h-5 text-xs rounded-full">✕</button>
                        </div>
                    @endforeach
                </div>
            </div>

            <label class="flex items-center gap-2 text-sm"><input type="checkbox" wire:model="is_active"> Visible in store</label>

            <div class="flex gap-3">
                <button class="bg-stone-900 text-white px-6 py-2.5 rounded-lg" wire:loading.attr="disabled" wire:target="save">Save product</button>
                <button type="button" wire:click="resetForm" class="px-6 py-2.5 border rounded-lg">Cancel</button>
            </div>
        </form>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-left text-stone-500 bg-stone-50">
                <tr><th class="px-4 py-3">Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th class="text-right px-4">Actions</th></tr>
            </thead>
            <tbody>
            @forelse ($products as $p)
                <tr class="border-t" wire:key="row-{{ $p->id }}">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $p->image_url }}" class="w-10 h-12 object-cover rounded" alt="">
                            <span class="font-medium">{{ $p->name }}</span>
                        </div>
                    </td>
                    <td>{{ $p->category?->name ?? '—' }}</td>
                    <td>{{ number_format($p->final_price) }} @if($p->on_sale)<span class="text-xs text-stone-400 line-through">{{ number_format($p->price) }}</span>@endif</td>
                    <td class="{{ $p->stock <= 5 ? 'text-red-600 font-semibold' : '' }}">{{ $p->stock }}</td>
                    <td>
                        <button wire:click="toggle({{ $p->id }})" class="text-xs px-2 py-1 rounded-full {{ $p->is_active ? 'bg-green-100 text-green-700' : 'bg-stone-200 text-stone-600' }}">
                            {{ $p->is_active ? 'Active' : 'Hidden' }}
                        </button>
                    </td>
                    <td class="text-right px-4 space-x-3">
                        <button wire:click="edit({{ $p->id }})" class="text-amber-600 hover:underline">Edit</button>
                        <button wire:click="delete({{ $p->id }})" wire:confirm="Delete this product?" class="text-red-600 hover:underline">Delete</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-stone-500">No products found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</div>
