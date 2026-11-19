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
            $t->string('name_en')->nullable();
            $t->string('slug')->unique();
            $t->string('sku')->nullable()->unique();
            $t->string('short_description')->nullable();
            $t->string('short_description_en')->nullable();
            $t->text('description')->nullable();
            $t->text('description_en')->nullable();
            $t->decimal('price', 10, 2);
            $t->decimal('sale_price', 10, 2)->nullable();
            $t->unsignedInteger('stock')->default(0);
            $t->string('age_range')->nullable();      // مثال: 2-9Y أو 0-12M
            $t->string('gender')->default('unisex');
            $t->string('material')->nullable();
            $t->string('material_en')->nullable();
            $t->json('features')->nullable();
            $t->json('features_en')->nullable();
            $t->text('care')->nullable();
            $t->text('care_en')->nullable();
            $t->json('sizes')->nullable();
            $t->json('colors')->nullable();           // slugs مثل black, pink
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
