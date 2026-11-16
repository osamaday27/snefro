<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use App\Services\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('إتمام الطلب')]
class Checkout extends Component
{
    public const GOVERNORATES = [
        'القاهرة', 'الجيزة', 'الإسكندرية', 'الدقهلية', 'الشرقية', 'القليوبية', 'الغربية', 'المنوفية',
        'البحيرة', 'كفر الشيخ', 'دمياط', 'بورسعيد', 'الإسماعيلية', 'السويس', 'شمال سيناء', 'جنوب سيناء',
        'الفيوم', 'بني سويف', 'المنيا', 'أسيوط', 'سوهاج', 'قنا', 'الأقصر', 'أسوان',
        'البحر الأحمر', 'الوادي الجديد', 'مطروح',
    ];

    public string $customer_name = '';
    public string $phone = '';
    public string $email = '';
    public string $city = '';
    public string $address = '';
    public string $notes = '';

    protected function rules(): array
    {
        return [
            'customer_name' => 'required|string|min:3|max:100',
            'phone' => ['required', 'regex:/^(\+?20|0)?1[0125][0-9]{8}$/'],
            'email' => 'nullable|email|max:150',
            'city' => ['required', Rule::in(self::GOVERNORATES)],
            'address' => 'required|string|min:6|max:255',
            'notes' => 'nullable|string|max:500',
        ];
    }

    protected function messages(): array
    {
        return [
            'phone.regex' => 'من فضلك أدخل رقم موبايل مصري صحيح (مثال: 01090718857).',
            'city.in' => 'من فضلك اختر المحافظة.',
            'city.required' => 'من فضلك اختر المحافظة.',
        ];
    }

    public function mount()
    {
        if (app(Cart::class)->items()->isEmpty()) {
            return redirect()->route('shop');
        }
    }

    public function placeOrder()
    {
        $data = $this->validate();
        $cart = app(Cart::class);
        $items = $cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('shop');
        }

        $order = DB::transaction(function () use ($data, $cart, $items) {
            foreach ($items as $i) {
                $p = Product::lockForUpdate()->find($i->product->id);
                if (! $p || $p->stock < $i->qty) {
                    throw ValidationException::withMessages([
                        'cart' => "عذراً، الكمية المطلوبة من «{$i->product->name}» غير متوفرة.",
                    ]);
                }
            }

            $order = Order::create($data + [
                'order_number' => 'SNF-'.strtoupper(Str::random(8)),
                'subtotal' => $cart->subtotal(),
                'shipping' => $cart->shipping(),
                'total' => $cart->total(),
                'status' => 'pending',
                'payment_method' => 'cod',
            ]);

            foreach ($items as $i) {
                $order->items()->create([
                    'product_id' => $i->product->id,
                    'product_name' => $i->product->name,
                    'size' => $i->size,
                    'color' => $i->color,
                    'price' => $i->product->final_price,
                    'quantity' => $i->qty,
                ]);
                $i->product->decrement('stock', $i->qty);
            }

            return $order;
        });

        $cart->clear();

        return redirect()->route('order.success', $order->order_number);
    }

    public function render()
    {
        $cart = app(Cart::class);

        return view('livewire.checkout', [
            'items' => $cart->items(),
            'subtotal' => $cart->subtotal(),
            'shipping' => $cart->shipping(),
            'total' => $cart->total(),
            'governorates' => self::GOVERNORATES,
        ]);
    }
}
