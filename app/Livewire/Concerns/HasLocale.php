<?php

namespace App\Livewire\Concerns;

/** يضبط لغة الموقع في كل طلب Livewire (الأولي والتحديثات) */
trait HasLocale
{
    public function bootHasLocale(): void
    {
        $locale = session('locale', 'ar');
        app()->setLocale(in_array($locale, ['ar', 'en'], true) ? $locale : 'ar');
    }
}
