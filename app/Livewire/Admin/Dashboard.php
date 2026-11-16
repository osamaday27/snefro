<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('لوحة التحكم')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'productsCount' => Product::count(),
            'categoriesCount' => Category::count(),
            'ordersCount' => Order::count(),
            'pendingCount' => Order::where('status', 'pending')->count(),
            'revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            'lowStock' => Product::where('stock', '<=', 5)->orderBy('stock')->take(5)->get(),
            'recentOrders' => Order::latest()->take(6)->get(),
        ]);
    }
}
