<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
#[Title('الأقسام')]
class Categories extends Component
{
    use WithFileUploads;

    public ?int $editingId = null;
    public string $name = '';
    public $photo = null;
    public ?string $currentImage = null;

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'photo' => 'nullable|image|max:2048',
        ]);

        $slug = Str::slug($this->name) ?: Str::lower(Str::random(6));
        $exists = Category::where('slug', $slug)->when($this->editingId, fn ($q) => $q->where('id', '!=', $this->editingId))->exists();
        if ($exists) $slug .= '-'.Str::lower(Str::random(3));

        $data = ['name' => $this->name, 'slug' => $slug];

        if ($this->photo) {
            $this->deleteFile($this->currentImage);
            $data['image'] = $this->photo->store('categories', 'public');
        }

        Category::updateOrCreate(['id' => $this->editingId], $data);

        $this->cancel();
        $this->dispatch('toast', message: 'تم حفظ القسم بنجاح', type: 'success');
    }

    public function edit(int $id): void
    {
        $c = Category::findOrFail($id);
        $this->editingId = $c->id;
        $this->name = $c->name;
        $this->currentImage = $c->image;
        $this->photo = null;
    }

    public function cancel(): void
    {
        $this->reset('name', 'editingId', 'photo', 'currentImage');
        $this->resetValidation();
    }

    public function delete(int $id): void
    {
        $c = Category::findOrFail($id);
        $this->deleteFile($c->image);
        $c->delete(); // المنتجات تبقى بدون قسم
        $this->dispatch('toast', message: 'تم حذف القسم', type: 'info');
    }

    protected function deleteFile(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'http')) Storage::disk('public')->delete($path);
    }

    public function render()
    {
        return view('livewire.admin.categories', [
            'categories' => Category::withCount('products')->orderBy('id')->get(),
        ]);
    }
}
