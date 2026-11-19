<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /** استخدام: SetLocale::class.':ar' لفرض لغة معينة (لوحة الإدارة) */
    public function handle(Request $request, Closure $next, ?string $force = null)
    {
        $locale = $force ?: session('locale', 'ar');
        app()->setLocale(in_array($locale, ['ar', 'en'], true) ? $locale : 'ar');

        return $next($request);
    }
}
