# سنفرو للأطفال – Snefro for Kids (Laravel 11+ / Livewire 3)

متجر ثنائي اللغة (العربية / English) بتصميم بسيط بدون حواف دائرية، ألوانه أبيض وأسود ورمادي ووردي.

## التثبيت
```bash
composer create-project laravel/laravel snefro && cd snefro
composer require livewire/livewire blade-ui-kit/blade-heroicons
```
انسخ المجلدات فوق المشروع (وافق على الاستبدال):
`app/  config/  database/  lang/  public/  resources/  routes/`

## .env
```
APP_LOCALE=ar
APP_FALLBACK_LOCALE=en
```
وفي `config/app.php`:  `'timezone' => 'Africa/Cairo',`

## التشغيل
```bash
php artisan migrate:fresh --seed
php artisan storage:link
php artisan optimize:clear
php artisan serve
```
- المتجر: http://127.0.0.1:8000        (زر تبديل اللغة في الشريط العلوي)
- الإدارة: /admin/login  ←  admin@snefro.test / password

## صور الهيرو
ضع صورك في: `public/images/1.jpg` و `2.jpg` و `3.jpg` (مقاس مقترح 1920×800).

## اللغات
- نصوص الواجهة: `lang/ar.json` (المفاتيح بالإنجليزية). أي نص جديد تكتبه بـ `__('Text')` وتضيف ترجمته هناك.
- بيانات المنتجات والأقسام: حقول عربي + حقول `English` في لوحة الإدارة.
- المقاسات والفئة العمرية بصيغة موحدة: `2-3Y` (سنوات) و `0-12M` (شهور) وتظهر بلغة الزائر.
- الألوان تُختار من لوحة ألوان جاهزة في الإدارة (تظهر بالاسم والمربع الملوّن).

## بيانات التواصل
في `config/snefro.php`.
