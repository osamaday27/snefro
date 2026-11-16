<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@snefro.test'],
            ['name' => 'Snefro Admin', 'password' => 'password', 'is_admin' => true]
        );

        $cats = collect(['Men', 'Women', 'Shoes', 'Accessories'])->map(
            fn ($n) => Category::firstOrCreate(['slug' => Str::slug($n)], ['name' => $n])
        );

        foreach (range(1, 12) as $i) {
            $name = 'Snefro Item '.$i;
            $price = rand(250, 1500);
            Product::firstOrCreate(['slug' => Str::slug($name)], [
                'category_id' => $cats->random()->id,
                'name' => $name,
                'description' => 'Premium quality item from Snefro. Comfortable, durable and designed to match your everyday style.',
                'price' => $price,
                'sale_price' => $i % 3 === 0 ? round($price * 0.8) : null,
                'stock' => rand(5, 40),
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['Black', 'White', 'Beige'],
                'images' => [
                    "https://picsum.photos/seed/snefro{$i}a/600/750",
                    "https://picsum.photos/seed/snefro{$i}b/600/750",
                    "https://picsum.photos/seed/snefro{$i}c/600/750",
                ],
            ]);
        }
    }
}
