<div class="max-w-3xl">
    <h1 class="text-2xl font-bold mb-6">Categories</h1>

    <form wire:submit="save" class="bg-white rounded-xl shadow-sm p-5 flex gap-3 items-start">
        <div class="flex-1">
            <input type="text" wire:model="name" placeholder="Category name" class="w-full rounded-lg border border-stone-300 px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
            @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <button class="bg-stone-900 text-white px-5 py-2.5 rounded-lg">{{ $editingId ? 'Update' : 'Add' }}</button>
        @if ($editingId)
            <button type="button" wire:click="cancel" class="px-4 py-2.5 border rounded-lg">Cancel</button>
        @endif
    </form>

    <div class="mt-6 bg-white rounded-xl shadow-sm divide-y">
        @forelse ($categories as $c)
            <div class="px-5 py-4 flex items-center justify-between" wire:key="c-{{ $c->id }}">
                <div>
                    <p class="font-medium">{{ $c->name }}</p>
                    <p class="text-xs text-stone-500">{{ $c->products_count }} products · /{{ $c->slug }}</p>
                </div>
                <div class="flex gap-3 text-sm">
                    <button wire:click="edit({{ $c->id }})" class="text-amber-600 hover:underline">Edit</button>
                    <button wire:click="delete({{ $c->id }})" wire:confirm="Delete this category? Its products will stay but become uncategorized."
                            class="text-red-600 hover:underline">Delete</button>
                </div>
            </div>
        @empty
            <p class="p-6 text-center text-stone-500">No categories yet.</p>
        @endforelse
    </div>
</div>
