<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Products')]
class Products extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';
    public bool $showForm = false;
    public ?int $editingId = null;

    public $category_id = '';
    public string $name = '';
    public string $description = '';
    public $price = '';
    public $sale_price = '';
    public $stock = 0;
    public string $sizes = '';
    public string $colors = '';
    public bool $is_active = true;

    public array $photos = [];
    public array $existing = [];

    protected function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'photos.*' => 'image|max:2048',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $p = Product::findOrFail($id);

        $this->resetForm();
        $this->editingId = $p->id;
        $this->category_id = $p->category_id ?? '';
        $this->name = $p->name;
        $this->description = $p->description ?? '';
        $this->price = $p->price;
        $this->sale_price = $p->sale_price ?? '';
        $this->stock = $p->stock;
        $this->sizes = implode(', ', $p->sizes ?? []);
        $this->colors = implode(', ', $p->colors ?? []);
        $this->is_active = $p->is_active;
        $this->existing = $p->images ?? [];
        $this->showForm = true;
    }

    public function removeExisting(int $index): void
    {
        unset($this->existing[$index]);
        $this->existing = array_values($this->existing);
    }

    public function removePhoto(int $index): void
    {
        unset($this->photos[$index]);
        $this->photos = array_values($this->photos);
    }

    protected function toList(string $text): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $text))));
    }

    public function save(): void
    {
        $this->validate();

        $images = $this->existing;
        foreach ($this->photos as $photo) {
            $images[] = $photo->store('products', 'public');
        }

        $data = [
            'category_id' => $this->category_id ?: null,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'sale_price' => $this->sale_price !== '' ? $this->sale_price : null,
            'stock' => $this->stock,
            'sizes' => $this->toList($this->sizes),
            'colors' => $this->toList($this->colors),
            'images' => $images,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            $product = Product::findOrFail($this->editingId);
            // delete files that were removed from the gallery
            foreach (array_diff($product->images ?? [], $images) as $old) {
                $this->deleteFile($old);
            }
            $product->update($data);
        } else {
            $slug = Str::slug($this->name) ?: Str::random(6);
            if (Product::where('slug', $slug)->exists()) $slug .= '-'.Str::lower(Str::random(4));
            Product::create($data + ['slug' => $slug]);
        }

        $this->resetForm();
        session()->flash('success', 'Product saved successfully.');
    }

    public function delete(int $id): void
    {
        $p = Product::findOrFail($id);
        foreach ($p->images ?? [] as $img) $this->deleteFile($img);
        $p->delete();
        session()->flash('success', 'Product deleted.');
    }

    public function toggle(int $id): void
    {
        $p = Product::findOrFail($id);
        $p->update(['is_active' => ! $p->is_active]);
    }

    protected function deleteFile(string $path): void
    {
        if (! str_starts_with($path, 'http')) Storage::disk('public')->delete($path);
    }

    public function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'category_id', 'name', 'description', 'price', 'sale_price', 'stock', 'sizes', 'colors', 'photos', 'existing']);
        $this->is_active = true;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.products', [
            'products' => Product::with('category')
                ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
                ->latest()->paginate(10),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
