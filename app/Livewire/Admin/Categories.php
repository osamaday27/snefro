<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Categories')]
class Categories extends Component
{
    public ?int $editingId = null;
    public string $name = '';

    public function save(): void
    {
        $this->validate(['name' => 'required|string|max:100']);

        $slug = Str::slug($this->name) ?: Str::random(6);
        $exists = Category::where('slug', $slug)->when($this->editingId, fn ($q) => $q->where('id', '!=', $this->editingId))->exists();
        if ($exists) $slug .= '-'.Str::lower(Str::random(3));

        Category::updateOrCreate(['id' => $this->editingId], ['name' => $this->name, 'slug' => $slug]);

        $this->reset('name', 'editingId');
    }

    public function edit(int $id): void
    {
        $c = Category::findOrFail($id);
        $this->editingId = $c->id;
        $this->name = $c->name;
    }

    public function cancel(): void
    {
        $this->reset('name', 'editingId');
    }

    public function delete(int $id): void
    {
        Category::findOrFail($id)->delete(); // products keep existing (category_id -> null)
    }

    public function render()
    {
        return view('livewire.admin.categories', [
            'categories' => Category::withCount('products')->orderBy('name')->get(),
        ]);
    }
}
