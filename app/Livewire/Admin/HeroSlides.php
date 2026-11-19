<?php

namespace App\Livewire\Admin;

use App\Livewire\Concerns\ForcesArabic;
use App\Models\HeroSlide;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
#[Title('صور الهيرو')]
class HeroSlides extends Component
{
    use ForcesArabic, WithFileUploads;

    public bool $showForm = false;
    public ?int $editingId = null;

    public $photo = null;
    public ?string $currentImage = null;

    public string $label = '';
    public string $label_en = '';
    public string $heading = '';
    public string $heading_en = '';
    public string $body = '';
    public string $body_en = '';
    public string $btn = '';
    public string $btn_en = '';
    public string $link = '';
    public bool $is_active = true;

    protected function rules(): array
    {
        return [
            'photo' => [$this->editingId ? 'nullable' : 'required', 'image', 'max:5120'],
            'heading' => 'required|string|max:120',
            'heading_en' => 'nullable|string|max:120',
            'label' => 'nullable|string|max:60',
            'label_en' => 'nullable|string|max:60',
            'body' => 'nullable|string|max:300',
            'body_en' => 'nullable|string|max:300',
            'btn' => 'nullable|string|max:40',
            'btn_en' => 'nullable|string|max:40',
            'link' => 'nullable|string|max:255',
        ];
    }

    protected function messages(): array
    {
        return [
            'photo.required' => 'صورة الهيرو مطلوبة.',
            'photo.image' => 'الملف يجب أن يكون صورة (JPG أو PNG أو WEBP).',
            'photo.max' => 'حجم الصورة يجب ألا يزيد عن 5 ميجا.',
            'heading.required' => 'العنوان الرئيسي مطلوب.',
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $s = HeroSlide::findOrFail($id);
        $this->resetForm();
        $this->editingId = $s->id;
        $this->currentImage = $s->image;
        $this->label = $s->tag ?? '';
        $this->label_en = $s->tag_en ?? '';
        $this->heading = $s->title;
        $this->heading_en = $s->title_en ?? '';
        $this->body = $s->text ?? '';
        $this->body_en = $s->text_en ?? '';
        $this->btn = $s->button_text ?? '';
        $this->btn_en = $s->button_text_en ?? '';
        $this->link = $s->button_url ?? '';
        $this->is_active = $s->is_active;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'tag' => $this->label ?: null,
            'tag_en' => $this->label_en ?: null,
            'title' => $this->heading,
            'title_en' => $this->heading_en ?: null,
            'text' => $this->body ?: null,
            'text_en' => $this->body_en ?: null,
            'button_text' => $this->btn ?: null,
            'button_text_en' => $this->btn_en ?: null,
            'button_url' => $this->link ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->photo) {
            $this->deleteFile($this->currentImage);
            $data['image'] = $this->photo->store('hero', 'public');
        }

        if ($this->editingId) {
            HeroSlide::findOrFail($this->editingId)->update($data);
        } else {
            HeroSlide::create($data + ['sort_order' => (int) HeroSlide::max('sort_order') + 1]);
        }

        $this->resetForm();
        $this->dispatch('toast', message: 'تم حفظ الصورة بنجاح', type: 'success');
    }

    public function move(int $id, string $dir): void
    {
        $s = HeroSlide::findOrFail($id);
        $other = HeroSlide::where('sort_order', $dir === 'up' ? '<' : '>', $s->sort_order)
            ->orderBy('sort_order', $dir === 'up' ? 'desc' : 'asc')->first();

        if (! $other) return;

        [$a, $b] = [$s->sort_order, $other->sort_order];
        $s->update(['sort_order' => $b]);
        $other->update(['sort_order' => $a]);
    }

    public function toggle(int $id): void
    {
        $s = HeroSlide::findOrFail($id);
        $s->update(['is_active' => ! $s->is_active]);
    }

    public function delete(int $id): void
    {
        $s = HeroSlide::findOrFail($id);
        $this->deleteFile($s->image);
        $s->delete();
        $this->dispatch('toast', message: 'تم حذف الصورة', type: 'info');
    }

    protected function deleteFile(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'http')) Storage::disk('public')->delete($path);
    }

    public function resetForm(): void
    {
        $this->reset(['showForm', 'editingId', 'photo', 'currentImage', 'label', 'label_en', 'heading', 'heading_en', 'body', 'body_en', 'btn', 'btn_en', 'link']);
        $this->is_active = true;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.hero-slides', [
            'slides' => HeroSlide::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }
}
