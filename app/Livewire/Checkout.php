<?php

namespace App\Livewire;

use App\Livewire\Concerns\HasLocale;
use App\Models\Order;
use App\Models\Product;
use App\Services\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Checkout extends Component
{
    use HasLocale;

    public const GOVERNORATES = [
        'cairo' => ['القاهرة', 'Cairo'], 'giza' => ['الجيزة', 'Giza'], 'alexandria' => ['الإسكندرية', 'Alexandria'],
        'dakahlia' => ['الدقهلية', 'Dakahlia'], 'sharqia' => ['الشرقية', 'Sharqia'], 'qalyubia' => ['القليوبية', 'Qalyubia'],
        'gharbia' => ['الغربية', 'Gharbia'], 'monufia' => ['المنوفية', 'Monufia'], 'beheira' => ['البحيرة', 'Beheira'],
        'kafr-el-sheikh' => ['كفر الشيخ', 'Kafr El Sheikh'], 'damietta' => ['دمياط', 'Damietta'], 'port-said' => ['بورسعيد', 'Port Said'],
        'ismailia' => ['الإسماعيلية', 'Ismailia'], 'suez' => ['السويس', 'Suez'], 'north-sinai' => ['شمال سيناء', 'North Sinai'],
        'south-sinai' => ['جنوب سيناء', 'South Sinai'], 'fayoum' => ['الفيوم', 'Fayoum'], 'beni-suef' => ['بني سويف', 'Beni Suef'],
        'minya' => ['المنيا', 'Minya'], 'assiut' => ['أسيوط', 'Assiut'], 'sohag' => ['سوهاج', 'Sohag'], 'qena' => ['قنا', 'Qena'],
        'luxor' => ['الأقصر', 'Luxor'], 'aswan' => ['أسوان', 'Aswan'], 'red-sea' => ['البحر الأحمر', 'Red Sea'],
        'new-valley' => ['الوادي الجديد', 'New Valley'], 'matrouh' => ['مطروح', 'Matrouh'],
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
            'city' => ['required', Rule::in(array_keys(self::GOVERNORATES))],
            'address' => 'required|string|min:6|max:255',
            'notes' => 'nullable|string|max:500',
        ];
    }

    protected function messages(): array
    {
        return [
            'phone.regex' => __('Please enter a valid Egyptian mobile number (e.g. 01090718857).'),
            'city.in' => __('Please choose a governorate.'),
            'city.required' => __('Please choose a governorate.'),
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
        $data['city'] = self::GOVERNORATES[$data['city']][0]; // نخزن اسم المحافظة بالعربي للإدارة

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
                        'cart' => __('Sorry, the requested quantity of :name is not available.', ['name' => $i->product->tr('name')]),
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
        $en = app()->getLocale() === 'en';

        return view('livewire.checkout', [
            'items' => $cart->items(),
            'subtotal' => $cart->subtotal(),
            'shipping' => $cart->shipping(),
            'total' => $cart->total(),
            'governorates' => collect(self::GOVERNORATES)->map(fn ($g) => $g[$en ? 1 : 0]),
        ])->title(__('Checkout'));
    }
}
