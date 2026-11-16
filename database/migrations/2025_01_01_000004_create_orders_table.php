<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->string('order_number')->unique();
            $t->string('customer_name');
            $t->string('phone');
            $t->string('email')->nullable();
            $t->string('address');
            $t->string('city');
            $t->text('notes')->nullable();
            $t->decimal('subtotal', 10, 2);
            $t->decimal('shipping', 10, 2)->default(0);
            $t->decimal('total', 10, 2);
            $t->string('status')->default('pending');
            $t->string('payment_method')->default('cod');
            $t->timestamps();
        });

        Schema::create('order_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $t->string('product_name');
            $t->string('size')->nullable();
            $t->string('color')->nullable();
            $t->decimal('price', 10, 2);
            $t->unsignedInteger('quantity');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
