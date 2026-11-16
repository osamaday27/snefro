# Snefro – Laravel + Livewire store (MVP)

## 1) Create project & install Livewire
```bash
composer create-project laravel/laravel snefro
cd snefro
composer require livewire/livewire
```

## 2) Copy these files into the project (overwrite when asked)
Copy `app/`, `database/`, `resources/`, `routes/` from this package into your project root.
(Delete `database/factories/UserFactory.php`'s usage if the default seeder complains – our DatabaseSeeder replaces it.)

## 3) Database (.env)
Set DB_* in `.env` (MySQL) or use the default SQLite, then:
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
```

## 4) Use it
- Store:  http://127.0.0.1:8000
- Admin:  http://127.0.0.1:8000/admin/login
- Login:  admin@snefro.test / password   (change it!)
