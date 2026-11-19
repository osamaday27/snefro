<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\SetLocale;
use App\Livewire\Admin;
use App\Livewire\CartPage;
use App\Livewire\Checkout;
use App\Livewire\Home;
use App\Livewire\ProductShow;
use App\Livewire\Shop;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// تبديل اللغة (عربي / English)
Route::get('/lang/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['ar', 'en'], true), 404);
    session(['locale' => $locale]);
    return redirect()->back(fallback: route('home'));
})->name('lang');

// ---------- المتجر ----------
Route::middleware(SetLocale::class)->group(function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/shop', Shop::class)->name('shop');
    Route::get('/product/{product:slug}', ProductShow::class)->name('product');
    Route::get('/cart', CartPage::class)->name('cart');
    Route::get('/checkout', Checkout::class)->name('checkout');
    Route::get('/order/{order:order_number}', fn (Order $order) => view('order-success', ['order' => $order->load('items.product')]))->name('order.success');
});

// ---------- لوحة الإدارة (عربي دائماً) ----------
Route::prefix('admin')->middleware(SetLocale::class.':ar')->group(function () {
    Route::get('login', Admin\Login::class)->middleware('guest')->name('login');

    Route::post('logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

    Route::middleware(['auth', IsAdmin::class])->name('admin.')->group(function () {
        Route::get('/', Admin\Dashboard::class)->name('dashboard');
        Route::get('products', Admin\Products::class)->name('products');
        Route::get('categories', Admin\Categories::class)->name('categories');
        Route::get('orders', Admin\Orders::class)->name('orders');
    });
});
