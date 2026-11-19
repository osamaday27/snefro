<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Livewire\Concerns\ForcesArabic;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('الطلبات')]
class Orders extends Component
{
    use ForcesArabic;
    use WithPagination;

    public string $status = '';
    public ?int $openId = null;

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function toggle(int $id): void
    {
        $this->openId = $this->openId === $id ? null : $id;
    }

    public function changeStatus(int $id, string $status): void
    {
        if (! array_key_exists($status, Order::STATUSES)) return;

        $order = Order::with('items')->findOrFail($id);

        if ($status === 'cancelled' && $order->status !== 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product_id) Product::where('id', $item->product_id)->increment('stock', $item->quantity);
            }
        }
        if ($order->status === 'cancelled' && $status !== 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product_id) Product::where('id', $item->product_id)->decrement('stock', $item->quantity);
            }
        }

        $order->update(['status' => $status]);
        $this->dispatch('toast', message: 'تم تحديث حالة الطلب', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.orders', [
            'orders' => Order::with('items')
                ->when($this->status, fn ($q) => $q->where('status', $this->status))
                ->latest()->paginate(10),
            'statuses' => Order::STATUSES,
        ]);
    }
}
