<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('sku')->nullable()->unique();
            $t->string('short_description')->nullable();
            $t->text('description')->nullable();
            $t->decimal('price', 10, 2);
            $t->decimal('sale_price', 10, 2)->nullable();
            $t->unsignedInteger('stock')->default(0);
            $t->string('age_range')->nullable();
            $t->string('gender')->default('unisex');
            $t->string('material')->nullable();
            $t->json('features')->nullable();
            $t->text('care')->nullable();
            $t->json('sizes')->nullable();
            $t->json('colors')->nullable();
            $t->json('images')->nullable();
            $t->boolean('is_active')->default(true);
            $t->boolean('is_featured')->default(false);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
