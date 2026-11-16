<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Orders')]
class Orders extends Component
{
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
        if (! in_array($status, Order::STATUSES, true)) return;

        $order = Order::with('items')->findOrFail($id);

        // return stock when an order gets cancelled
        if ($status === 'cancelled' && $order->status !== 'cancelled') {
            foreach ($order->items as $item) {
                $item->product_id && \App\Models\Product::where('id', $item->product_id)->increment('stock', $item->quantity);
            }
        }
        // take stock again if a cancelled order is re-opened
        if ($order->status === 'cancelled' && $status !== 'cancelled') {
            foreach ($order->items as $item) {
                $item->product_id && \App\Models\Product::where('id', $item->product_id)->decrement('stock', $item->quantity);
            }
        }

        $order->update(['status' => $status]);
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
