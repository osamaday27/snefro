# سنفرو للأطفال – Laravel + Livewire (عربي RTL)

## 1) إنشاء المشروع وتثبيت الحزم (ثبّت الإصدارات دي)
```bash
composer create-project laravel/laravel snefro
cd snefro
composer require livewire/livewire:"^3.5" blade-ui-kit/blade-heroicons:"^2"
```

## 2) انسخ ملفات الحزمة فوق المشروع (وافق على الاستبدال)
المجلدات: `app/  config/  database/  lang/  public/  resources/  routes/`

## 3) إعدادات .env
```
APP_LOCALE=ar
APP_FALLBACK_LOCALE=ar
```
وفي `config/app.php`:  `'timezone' => 'Africa/Cairo',`

## 4) قاعدة البيانات والتشغيل
```bash
php artisan migrate:fresh --seed
php artisan storage:link
php artisan optimize:clear
php artisan serve
```
- المتجر: http://127.0.0.1:8000
- الإدارة: http://127.0.0.1:8000/admin/login  ←  admin@snefro.test / password

## بيانات التواصل
كلها في `config/snefro.php`.

## لو ظهر خطأ
شغّل `php artisan optimize:clear` ثم أعد المحاولة، ولو استمر ابعت نص الخطأ كاملاً.
