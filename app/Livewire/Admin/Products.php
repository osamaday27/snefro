<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\ForcesArabic;
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
    use ForcesArabic, WithFileUploads, WithPagination;

    public string $search = '';
    public bool $showForm = false;
    public ?int $editingId = null;

    public $category_id = '';
    public string $name = '';
    public string $name_en = '';
    public string $short_description = '';
    public string $short_description_en = '';
    public string $description = '';
    public string $description_en = '';
    public $price = '';
    public $sale_price = '';
    public $stock = 0;
    public string $age_range = '';
    public string $gender = 'unisex';
    public string $material = '';
    public string $material_en = '';
    public string $features = '';
    public string $features_en = '';
    public string $care = '';
    public string $care_en = '';
    public string $sizes = '';
    public array $colors = [];
    public bool $is_active = true;
    public bool $is_featured = false;

    public array $photos = [];
    public array $existing = [];

    protected function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:150',
            'name_en' => 'nullable|string|max:150',
            'short_description' => 'nullable|string|max:255',
            'short_description_en' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'age_range' => 'nullable|string|max:60',
            'gender' => 'required|in:boys,girls,unisex',
            'material' => 'nullable|string|max:120',
            'material_en' => 'nullable|string|max:120',
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
        $this->name_en = $p->name_en ?? '';
        $this->short_description = $p->short_description ?? '';
        $this->short_description_en = $p->short_description_en ?? '';
        $this->description = $p->description ?? '';
        $this->description_en = $p->description_en ?? '';
        $this->price = $p->price;
        $this->sale_price = $p->sale_price ?? '';
        $this->stock = $p->stock;
        $this->age_range = $p->age_range ?? '';
        $this->gender = $p->gender ?? 'unisex';
        $this->material = $p->material ?? '';
        $this->material_en = $p->material_en ?? '';
        $this->features = implode("\n", $p->features ?? []);
        $this->features_en = implode("\n", $p->features_en ?? []);
        $this->care = $p->care ?? '';
        $this->care_en = $p->care_en ?? '';
        $this->sizes = implode(', ', $p->sizes ?? []);
        $this->colors = $p->colors ?? [];
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
            'name_en' => $this->name_en ?: null,
            'short_description' => $this->short_description ?: null,
            'short_description_en' => $this->short_description_en ?: null,
            'description' => $this->description ?: null,
            'description_en' => $this->description_en ?: null,
            'price' => $this->price,
            'sale_price' => $this->sale_price !== '' ? $this->sale_price : null,
            'stock' => $this->stock,
            'age_range' => $this->age_range ?: null,
            'gender' => $this->gender,
            'material' => $this->material ?: null,
            'material_en' => $this->material_en ?: null,
            'features' => $this->lineList($this->features),
            'features_en' => $this->lineList($this->features_en),
            'care' => $this->care ?: null,
            'care_en' => $this->care_en ?: null,
            'sizes' => $this->commaList($this->sizes),
            'colors' => array_values($this->colors),
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
            $slug = Str::slug($this->name_en ?: $this->name) ?: Str::lower(Str::random(6));
            if (Product::where('slug', $slug)->exists()) $slug .= '-'.Str::lower(Str::random(4));
            $product = Product::create($data + ['slug' => $slug]);
            $product->update(['sku' => 'SNF-'.str_pad((string) $product->id, 4, '0', STR_PAD_LEFT)]);
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
            'showForm', 'editingId', 'category_id', 'name', 'name_en', 'short_description', 'short_description_en',
            'description', 'description_en', 'price', 'sale_price', 'stock', 'age_range', 'material', 'material_en',
            'features', 'features_en', 'care', 'care_en', 'sizes', 'colors', 'photos', 'existing',
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
                ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%')->orWhere('name_en', 'like', '%'.$this->search.'%'))
                ->latest()->paginate(10),
            'categories' => Category::orderBy('name')->get(),
            'palette' => Product::COLORS,
        ]);
    }
}
