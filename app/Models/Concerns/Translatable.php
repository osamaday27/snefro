<?php

namespace App\Models\Concerns;

trait Translatable
{
    /** يرجع النص الإنجليزي (حقل_en) عند اللغة الإنجليزية، وإلا النص العربي الأساسي */
    public function tr(string $field): mixed
    {
        if (app()->getLocale() === 'en') {
            $v = $this->{$field.'_en'} ?? null;
            if (! blank($v)) return $v;
        }

        return $this->{$field};
    }
}
