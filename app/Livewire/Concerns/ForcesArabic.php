<?php

namespace App\Livewire\Concerns;

/** لوحة الإدارة عربية دائماً */
trait ForcesArabic
{
    public function bootForcesArabic(): void
    {
        app()->setLocale('ar');
    }
}
