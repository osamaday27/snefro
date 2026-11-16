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
#[Title('المنتجات')]
class Products extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';
    public bool $showForm = false;
    public ?int $editingId = null;

    public $category_id = '';
    public string $name = '';
    public string $short_description = '';
    public string $description = '';
    public $price = '';
    public $sale_price = '';
    public $stock = 0;
    public string $age_range = '';
    public string $gender = 'unisex';
    public string $material = '';
    public string $features = '';
    public string $care = '';
    public string $sizes = '';
    public string $colors = '';
    public bool $is_active = true;
    public bool $is_featured = false;

    public array $photos = [];
    public array $existing = [];

    protected function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:150',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'age_range' => 'nullable|string|max:60',
            'gender' => 'required|in:boys,girls,unisex',
            'material' => 'nullable|string|max:120',
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
        $this->short_description = $p->short_description ?? '';
        $this->description = $p->description ?? '';
        $this->price = $p->price;
        $this->sale_price = $p->sale_price ?? '';
        $this->stock = $p->stock;
        $this->age_range = $p->age_range ?? '';
        $this->gender = $p->gender ?? 'unisex';
        $this->material = $p->material ?? '';
        $this->features = implode("\n", $p->features ?? []);
        $this->care = $p->care ?? '';
        $this->sizes = implode('، ', $p->sizes ?? []);
        $this->colors = implode('، ', $p->colors ?? []);
        $this->is_active = $p->is_active;
        $this->is_featured = $p->is_featured;
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

    protected function commaList(string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/[,،]/u', $text))));
    }

    protected function lineList(string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $text))));
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
            'short_description' => $this->short_description ?: null,
            'description' => $this->description ?: null,
            'price' => $this->price,
            'sale_price' => $this->sale_price !== '' ? $this->sale_price : null,
            'stock' => $this->stock,
            'age_range' => $this->age_range ?: null,
            'gender' => $this->gender,
            'material' => $this->material ?: null,
            'features' => $this->lineList($this->features),
            'care' => $this->care ?: null,
            'sizes' => $this->commaList($this->sizes),
            'colors' => $this->commaList($this->colors),
            'images' => $images,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
        ];

        if ($this->editingId) {
            $product = Product::findOrFail($this->editingId);
            foreach (array_diff($product->images ?? [], $images) as $old) {
                $this->deleteFile($old);
            }
            $product->update($data);
        } else {
            $slug = Str::slug($this->name) ?: Str::lower(Str::random(6));
            if (Product::where('slug', $slug)->exists()) $slug .= '-'.Str::lower(Str::random(4));
            $product = Product::create($data + ['slug' => $slug]);
            $product->update(['sku' => 'SNF-'.str_pad($product->id, 4, '0', STR_PAD_LEFT)]);
        }

        $this->resetForm();
        $this->dispatch('toast', message: 'تم حفظ المنتج بنجاح', type: 'success');
    }

    public function delete(int $id): void
    {
        $p = Product::findOrFail($id);
        foreach ($p->images ?? [] as $img) $this->deleteFile($img);
        $p->delete();
        $this->dispatch('toast', message: 'تم حذف المنتج', type: 'info');
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
        $this->reset([
            'showForm', 'editingId', 'category_id', 'name', 'short_description', 'description', 'price',
            'sale_price', 'stock', 'age_range', 'material', 'features', 'care', 'sizes', 'colors', 'photos', 'existing',
        ]);
        $this->gender = 'unisex';
        $this->is_active = true;
        $this->is_featured = false;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.products', [
            'products' => Product::with('category')
                ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
                ->latest()->paginate(10),
            'categories' => Category::orderBy('name')->get(),
            'genders' => Product::GENDERS,
        ]);
    }
}
