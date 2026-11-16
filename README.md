# سنفرو للأطفال – Laravel + Livewire (عربي RTL)

## 1) إنشاء المشروع وتثبيت الحزم
```bash
composer create-project laravel/laravel snefro
cd snefro
composer require livewire/livewire blade-ui-kit/blade-heroicons
```
(blade-heroicons = أيقونات Heroicons الرسمية من فريق Tailwind)

## 2) انسخ ملفات الحزمة فوق المشروع
انسخ المجلدات: `app/ config/ database/ lang/ public/ resources/ routes/` (وافق على الاستبدال).

## 3) إعدادات .env
```
APP_NAME="Snefro"
APP_LOCALE=ar
APP_FALLBACK_LOCALE=ar
```
وفي `config/app.php` غيّر: `'timezone' => 'Africa/Cairo',`

## 4) قاعدة البيانات والتشغيل
```bash
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```
- المتجر: http://127.0.0.1:8000
- الإدارة: http://127.0.0.1:8000/admin/login  →  admin@snefro.test / password

## بيانات التواصل
كلها في ملف واحد: `config/snefro.php` (الهاتف، الواتساب، الإيميل، العنوان، الشحن).
